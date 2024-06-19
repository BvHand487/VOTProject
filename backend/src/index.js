require('dotenv').config()
const morgan = require('morgan');
const express = require('express');
const session = require('express-session');
const { Issuer, generators } = require('openid-client');
const crypto = require('crypto');
const path = require('path')

const app = express();
const port = 3000;

const clientID = process.env.GOOGLE_CLIENT_ID;
const clientSecret = process.env.GOOGLE_CLIENT_SECRET;
const redirectUri = 'http://localhost:3000/callback';

const sessionSecret = crypto.randomBytes(64).toString('hex')

console.log(`Target environment: ${process.env.NODE_ENV}`);
const isDev = (process.env.NODE_ENV === "development")

if (isDev)
  app.use(morgan("dev"))
else
  app.use(morgan("tiny"))

app.use(session({
    secret: sessionSecret,
    resave: false,
    saveUninitialized: true,
}));

// Discover Google's OAuth 2.0 endpoint
Issuer.discover('https://accounts.google.com')
  .then(googleIssuer => {
    const client = new googleIssuer.Client({
      client_id: clientID,
      client_secret: clientSecret,
      redirect_uris: [redirectUri],
      response_types: ['code'],
    });

    app.get('/login', (req, res) => {
      const codeVerifier = generators.codeVerifier();
      const codeChallenge = generators.codeChallenge(codeVerifier);

      // Save the code verifier in the session (you should use a session store in production)
      req.session.codeVerifier = codeVerifier;

      const authUrl = client.authorizationUrl({
        scope: 'openid email profile',
        code_challenge: codeChallenge,
        code_challenge_method: 'S256',
      });

      res.redirect(authUrl);
    });

    app.get('/callback', async (req, res) => {
      const params = client.callbackParams(req);
      const tokenSet = await client.callback(redirectUri, params, { code_verifier: req.session.codeVerifier });

      const userinfo = await client.userinfo(tokenSet.access_token);
      res.json(userinfo);
    });
  })
  .catch(err => {
    console.error('Error discovering Google issuer:', err);
  });


app.get('/', (req, res) => {
    res.sendFile(path.resolve(`${__dirname}/../public/index.html`));
});

app.listen(port, () => {
  console.log(`App listening at http://localhost:${port}`);
});

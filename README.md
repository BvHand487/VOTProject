# A Web Service that uses Maxscale, Galera, OIDC with Google and Docker.

To run the development and production environments respectively:

- ```docker compose --env-file ./config/.env.dev build | docker compose up -d```

- ```docker compose --env-file ./config/.env.prod build | docker compose up -d```

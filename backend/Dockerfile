FROM node:alpine3.11 as base

WORKDIR /app

COPY package*.json ./
RUN npm install && npm install morgan
COPY . .

EXPOSE 3000


FROM base as dev

RUN npm install --global nodemon
ENV NODE_ENV=development

CMD [ "nodemon", "index.js" ]


FROM base as prod

ENV NODE_ENV=production

CMD [ "node", "./src/index.js" ]
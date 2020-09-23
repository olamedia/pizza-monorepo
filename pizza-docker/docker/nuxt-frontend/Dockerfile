FROM node:14

ENV APP_ROOT /app

RUN mkdir ${APP_ROOT}
WORKDIR ${APP_ROOT}
COPY ./pizza-frontend/ ${APP_ROOT}
COPY ./pizza-docker/docker/nuxt-frontend/nuxt.config.js ${APP_ROOT}/nuxt.config.js

RUN yarn install
RUN yarn run build

ENV HOST 0.0.0.0

FROM nginx:latest

RUN mkdir -p /app
RUN rm /etc/nginx/conf.d/*

COPY ./pizza-docker/docker/nginx/app.conf /etc/nginx/conf.d
COPY ./pizza-backend/public /app/public




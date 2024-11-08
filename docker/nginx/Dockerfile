FROM nginx:stable-alpine

ARG APP_ENV=dev
ARG APPLICATION_CONTAINER=application
ARG APPLICATION_PORT=9000

COPY nginx.conf /etc/nginx/
COPY fidu-$APP_ENV.conf /etc/nginx/sites-available/fidu-$APP_ENV.conf

RUN apk update && apk upgrade && apk add --no-cache bash

RUN set -x ; \
    addgroup -g 82 -S www-data ; \
    adduser -u 82 -D -S -G www-data www-data && exit 0 ; exit 1


RUN mkdir /etc/nginx/sites-enabled/ \
  && ln -s /etc/nginx/sites-available/fidu-$APP_ENV.conf /etc/nginx/sites-enabled/fidu \
  && rm -f /etc/nginx/conf.d/default.conf \
  && echo "upstream php-upstream { server ${APPLICATION_CONTAINER}:${APPLICATION_PORT}; }" > /etc/nginx/conf.d/upstream.conf

EXPOSE 80

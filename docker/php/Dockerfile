FROM composer as backend

WORKDIR /code/api

COPY ./code/api /code/api/
RUN composer install

FROM php:7.4-fpm-alpine

RUN apk add --update \
    composer \
    icu-dev \
    && rm -rf /var/cache/apk/*

WORKDIR /code/api

COPY --from=backend /code/api /code/api/

RUN apk add --no-cache --virtual .phpize-deps $PHPIZE_DEPS \
    && docker-php-ext-install intl \
    && docker-php-ext-install pdo \
    && docker-php-ext-install pdo_mysql

COPY ./docker/php/php.ini /usr/local/etc/php/conf.d/custom.ini

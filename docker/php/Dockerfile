FROM php:8.2-fpm as base

COPY ./scripts/* /usr/local/bin/

SHELL ["/bin/bash", "-c"]
ENV APP_HOME /app

RUN set -xeuo pipefail \
    && apt-get update \
    && apt-get install -y \
    bash \
    curl \
    libzip-dev \
    zip \
    unzip \
    npm \
    libpng-dev \
    && docker-php-ext-install pdo_mysql gd zip \
    && /usr/local/bin/docker-install-composer \
    && mkdir -p ${APP_HOME} \
    && chown -R www-data:www-data ${APP_HOME}

RUN apt-get update && apt-get install -y python3 python3-pip
RUN apt-get install -y python3-opencv

WORKDIR ${APP_HOME}

EXPOSE 9000

ENTRYPOINT ["docker-php-entrypoint-override"]
CMD ["php-fpm"]

FROM base as develop

ARG HOST_UID=1000

RUN set -xeuo pipefail \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && usermod -u "${HOST_UID}" www-data \
    && groupmod -g "${HOST_UID}" www-data \
    && chown -R www-data:www-data ${APP_HOME}

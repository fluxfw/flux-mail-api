ARG FLUX_AUTOLOAD_API_IMAGE=docker-registry.fluxpublisher.ch/flux-autoload/api:latest
ARG FLUX_REST_API_IMAGE=docker-registry.fluxpublisher.ch/flux-rest/api:latest
ARG PHP_CLI_IMAGE=php:cli-alpine
ARG PHPIMAP_SOURCE_URL=https://github.com/barbushin/php-imap/archive/master.tar.gz
ARG PHPMAILER_SOURCE_URL=https://github.com/PHPMailer/PHPMailer/archive/master.tar.gz
ARG SWOOLE_SOURCE_URL=https://github.com/swoole/swoole-src/archive/master.tar.gz

FROM $FLUX_AUTOLOAD_API_IMAGE AS flux_autoload_api
FROM $FLUX_REST_API_IMAGE AS flux_rest_api

FROM $PHP_CLI_IMAGE
ARG PHPIMAP_SOURCE_URL
ARG PHPMAILER_SOURCE_URL
ARG SWOOLE_SOURCE_URL

LABEL org.opencontainers.image.source="https://github.com/fluxapps/flux-mail-api"
LABEL maintainer="fluxlabs <support@fluxlabs.ch> (https://fluxlabs.ch)"

RUN apk add --no-cache imap-dev libstdc++ && \
    apk add --no-cache --virtual .build-deps $PHPIZE_DEPS openssl-dev && \
    (mkdir -p /usr/src/php/ext/swoole && cd /usr/src/php/ext/swoole && wget -O - $SWOOLE_SOURCE_URL | tar -xz --strip-components=1) && \
    docker-php-ext-configure imap --with-imap-ssl && \
    docker-php-ext-configure swoole --enable-openssl --enable-swoole-json && \
    docker-php-ext-install -j$(nproc) imap swoole && \
    docker-php-source delete && \
    apk del .build-deps

COPY --from=flux_autoload_api /flux-autoload-api /flux-mail-api/libs/flux-autoload-api
COPY --from=flux_rest_api /flux-rest-api /flux-mail-api/libs/flux-rest-api
RUN (mkdir -p /flux-mail-api/libs/php-imap && cd /flux-mail-api/libs/php-imap && wget -O - $PHPIMAP_SOURCE_URL | tar -xz --strip-components=1)
RUN (mkdir -p /flux-mail-api/libs/PHPMailer && cd /flux-mail-api/libs/PHPMailer && wget -O - $PHPMAILER_SOURCE_URL | tar -xz --strip-components=1)
COPY . /flux-mail-api

ENTRYPOINT ["/flux-mail-api/bin/entrypoint.php"]

USER www-data:www-data

EXPOSE 9501

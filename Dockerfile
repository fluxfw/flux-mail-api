FROM phpswoole/swoole:4.8-php8.0-alpine

LABEL org.opencontainers.image.source="https://github.com/fluxapps/FluxMailApi"
LABEL maintainer="fluxlabs <support@fluxlabs.ch> (https://fluxlabs.ch)"

RUN apk add --no-cache imap-dev openssl-dev && \
    docker-php-ext-configure imap --with-imap-ssl && \
    docker-php-ext-install imap && \
    docker-php-source delete

COPY . /FluxMailApi

ENTRYPOINT ["/FluxMailApi/bin/entrypoint.php"]

RUN /FluxMailApi/bin/build.sh

EXPOSE 9501

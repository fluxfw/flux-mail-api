FROM phpswoole/swoole:4.8-php8.0-alpine

LABEL org.opencontainers.image.source="https://github.com/fluxapps/FluxMailApi"
LABEL maintainer="fluxlabs <support@fluxlabs.ch> (https://fluxlabs.ch)"

RUN apk add --no-cache imap-dev openssl-dev && \
    docker-php-ext-configure imap --with-imap-ssl && \
    docker-php-ext-install imap && \
    docker-php-source delete

COPY . /app
ENTRYPOINT ["/app/bin/entrypoint.php"]

# TODO: Remove ignore-platform-reqs and patch (PHP8 support of php-imap/php-imap library)
# https://github.com/barbushin/php-imap/issues/563#issuecomment-867584500
RUN composer install -d /app --no-dev --ignore-platform-reqs
RUN sed -i "s/\$reverse = (int) \$reverse;/\$reverse = (bool) \$reverse;/" /app/vendor/php-imap/php-imap/src/PhpImap/Imap.php

EXPOSE 9501

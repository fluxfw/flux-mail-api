ARG REST_API_IMAGE
FROM $REST_API_IMAGE AS rest_api

FROM phpswoole/swoole:latest-alpine

LABEL org.opencontainers.image.source="https://github.com/fluxapps/flux-mail-api"
LABEL maintainer="fluxlabs <support@fluxlabs.ch> (https://fluxlabs.ch)"

RUN apk add --no-cache imap-dev openssl-dev && \
    docker-php-ext-configure imap --with-imap-ssl && \
    docker-php-ext-install imap && \
    docker-php-source delete

COPY --from=rest_api /flux-rest-api /flux-mail-api/libs/flux-rest-api
RUN (mkdir -p /flux-mail-api/libs/PHPMailer && cd /flux-mail-api/libs/PHPMailer && wget -O - https://github.com/PHPMailer/PHPMailer/archive/master.tar.gz | tar -xz --strip-components=1)
RUN (mkdir -p /flux-mail-api/libs/php-imap && cd /flux-mail-api/libs/php-imap && wget -O - https://github.com/barbushin/php-imap/archive/master.tar.gz | tar -xz --strip-components=1 && sed -i "s/\$reverse = (int) \$reverse;/\$reverse = (bool) \$reverse;/" "src/PhpImap/Imap.php") # Patch https://github.com/barbushin/php-imap/issues/563#issuecomment-867584500
COPY . /flux-mail-api

ENTRYPOINT ["/flux-mail-api/bin/entrypoint.php"]

EXPOSE 9501

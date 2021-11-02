FROM phpswoole/swoole:latest-alpine

LABEL org.opencontainers.image.source="https://github.com/fluxapps/FluxMailApi"
LABEL maintainer="fluxlabs <support@fluxlabs.ch> (https://fluxlabs.ch)"

RUN apk add --no-cache imap-dev openssl-dev && \
    docker-php-ext-configure imap --with-imap-ssl && \
    docker-php-ext-install imap && \
    docker-php-source delete

COPY --from=docker-registry.fluxpublisher.ch/flux-rest/api:latest /FluxRestApi /FluxMailApi/libs/FluxRestApi
RUN (mkdir -p /FluxMailApi/libs/PHPMailer && cd /FluxMailApi/libs/PHPMailer && wget -O - https://github.com/PHPMailer/PHPMailer/archive/master.tar.gz | tar -xz --strip-components=1)
RUN (mkdir -p /FluxMailApi/libs/php-imap && cd /FluxMailApi/libs/php-imap && wget -O - https://github.com/barbushin/php-imap/archive/master.tar.gz | tar -xz --strip-components=1 && sed -i "s/\$reverse = (int) \$reverse;/\$reverse = (bool) \$reverse;/" "src/PhpImap/Imap.php") # Patch https://github.com/barbushin/php-imap/issues/563#issuecomment-867584500
COPY . /FluxMailApi

ENTRYPOINT ["/FluxMailApi/bin/entrypoint.php"]

EXPOSE 9501

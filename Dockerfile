FROM composer:latest AS build

RUN (mkdir -p /flux-namespace-changer && cd /flux-namespace-changer && wget -O - https://github.com/flux-eco/flux-namespace-changer/releases/download/v2022-07-12-1/flux-namespace-changer-v2022-07-12-1-build.tar.gz | tar -xz --strip-components=1)

RUN (mkdir -p /build/flux-mail-api/libs/php-imap && cd /build/flux-mail-api/libs/php-imap && composer require php-imap/php-imap:5.0.0 --ignore-platform-reqs)

RUN (mkdir -p /build/flux-mail-api/libs/PHPMailer && cd /build/flux-mail-api/libs/PHPMailer && composer require phpmailer/phpmailer:v6.6.3 --ignore-platform-reqs)

RUN (mkdir -p /build/flux-mail-api/libs/flux-autoload-api && cd /build/flux-mail-api/libs/flux-autoload-api && wget -O - https://github.com/flux-eco/flux-autoload-api/releases/download/v2022-07-12-1/flux-autoload-api-v2022-07-12-1-build.tar.gz | tar -xz --strip-components=1 && /flux-namespace-changer/bin/change-namespace.php . FluxAutoloadApi FluxMailApi\\Libs\\FluxAutoloadApi)

COPY . /build/flux-mail-api

FROM scratch

COPY --from=build /build /

ARG FLUX_AUTOLOAD_API_IMAGE=docker-registry.fluxpublisher.ch/flux-autoload/api
ARG FLUX_NAMESPACE_CHANGER_IMAGE=docker-registry.fluxpublisher.ch/flux-namespace-changer

FROM $FLUX_AUTOLOAD_API_IMAGE:latest AS flux_autoload_api

FROM composer:latest AS composer

RUN (mkdir -p /code/php-imap && cd /code/php-imap && composer require php-imap/php-imap --ignore-platform-reqs)
RUN (mkdir -p /code/PHPMailer && cd /code/PHPMailer && composer require phpmailer/phpmailer --ignore-platform-reqs)

FROM $FLUX_NAMESPACE_CHANGER_IMAGE:latest AS build_namespaces

COPY --from=flux_autoload_api /flux-autoload-api /code/flux-autoload-api
RUN change-namespace /code/flux-autoload-api FluxAutoloadApi FluxMailApi\\Libs\\FluxAutoloadApi

FROM alpine:latest AS build

COPY --from=build_namespaces /code/flux-autoload-api /build/flux-mail-api/libs/flux-autoload-api
COPY --from=composer /code/php-imap /build/flux-mail-api/libs/php-imap
COPY --from=composer /code/PHPMailer /build/flux-mail-api/libs/PHPMailer
COPY . /build/flux-mail-api

RUN (cd /build && tar -czf flux-mail-api.tar.gz flux-mail-api)

FROM scratch

LABEL org.opencontainers.image.source="https://github.com/flux-eco/flux-mail-api"
LABEL maintainer="fluxlabs <support@fluxlabs.ch> (https://fluxlabs.ch)"

COPY --from=build /build /

ARG COMMIT_SHA
LABEL org.opencontainers.image.revision="$COMMIT_SHA"

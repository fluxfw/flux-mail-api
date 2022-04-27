ARG FLUX_AUTOLOAD_API_IMAGE=docker-registry.fluxpublisher.ch/flux-autoload/api
ARG FLUX_NAMESPACE_CHANGER_IMAGE=docker-registry.fluxpublisher.ch/flux-namespace-changer

FROM $FLUX_AUTOLOAD_API_IMAGE:latest AS flux_autoload_api
FROM $FLUX_NAMESPACE_CHANGER_IMAGE:latest AS flux_autoload_api_build
ENV FLUX_NAMESPACE_CHANGER_FROM_NAMESPACE FluxAutoloadApi
ENV FLUX_NAMESPACE_CHANGER_TO_NAMESPACE FluxMailApi\\Libs\\FluxAutoloadApi
COPY --from=flux_autoload_api /flux-autoload-api /code
RUN change-namespace

FROM alpine:latest AS build

COPY --from=flux_autoload_api_build /code /flux-mail-api/libs/flux-autoload-api
RUN (mkdir -p /flux-mail-api/libs/php-imap && cd /flux-mail-api/libs/php-imap && wget -O - https://github.com/barbushin/php-imap/archive/master.tar.gz | tar -xz --strip-components=1)
RUN (mkdir -p /flux-mail-api/libs/PHPMailer && cd /flux-mail-api/libs/PHPMailer && wget -O - https://github.com/PHPMailer/PHPMailer/archive/master.tar.gz | tar -xz --strip-components=1)
COPY . /flux-mail-api

FROM scratch

LABEL org.opencontainers.image.source="https://github.com/flux-eco/flux-mail-api"
LABEL maintainer="fluxlabs <support@fluxlabs.ch> (https://fluxlabs.ch)"

COPY --from=build /flux-mail-api /flux-mail-api

ARG COMMIT_SHA
LABEL org.opencontainers.image.revision="$COMMIT_SHA"

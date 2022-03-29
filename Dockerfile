ARG ALPINE_IMAGE=alpine:latest
ARG FLUX_AUTOLOAD_API_IMAGE=docker-registry.fluxpublisher.ch/flux-autoload/api:latest
ARG FLUX_NAMESPACE_CHANGER_IMAGE=docker-registry.fluxpublisher.ch/flux-namespace-changer:latest
ARG PHPIMAP_SOURCE_URL=https://github.com/barbushin/php-imap/archive/master.tar.gz
ARG PHPMAILER_SOURCE_URL=https://github.com/PHPMailer/PHPMailer/archive/master.tar.gz

FROM $FLUX_AUTOLOAD_API_IMAGE AS flux_autoload_api
FROM $FLUX_NAMESPACE_CHANGER_IMAGE AS flux_autoload_api_build
ENV FLUX_NAMESPACE_CHANGER_FROM_NAMESPACE FluxAutoloadApi
ENV FLUX_NAMESPACE_CHANGER_TO_NAMESPACE FluxMailApi\\Libs\\FluxAutoloadApi
COPY --from=flux_autoload_api /flux-autoload-api /code
RUN $FLUX_NAMESPACE_CHANGER_BIN

FROM $ALPINE_IMAGE AS build
ARG PHPIMAP_SOURCE_URL
ARG PHPMAILER_SOURCE_URL

COPY --from=flux_autoload_api_build /code /flux-mail-api/libs/flux-autoload-api
RUN (mkdir -p /flux-mail-api/libs/php-imap && cd /flux-mail-api/libs/php-imap && wget -O - $PHPIMAP_SOURCE_URL | tar -xz --strip-components=1)
RUN (mkdir -p /flux-mail-api/libs/PHPMailer && cd /flux-mail-api/libs/PHPMailer && wget -O - $PHPMAILER_SOURCE_URL | tar -xz --strip-components=1)
COPY . /flux-mail-api

FROM scratch

LABEL org.opencontainers.image.source="https://github.com/flux-eco/flux-mail-api"
LABEL maintainer="fluxlabs <support@fluxlabs.ch> (https://fluxlabs.ch)"

COPY --from=build /flux-mail-api /flux-mail-api

# flux-mail-api

Mail Api for fetch or send mails

## Installation

Hint: Use `latest` as `%tag%` (or omit it) for get the latest build

### Non-Composer

```dockerfile
COPY --from=docker-registry.fluxpublisher.ch/flux-mail-api:%tag% /flux-mail-api /%path%/libs/flux-mail-api
```

or

```dockerfile
RUN (mkdir -p /%path%/libs/flux-mail-api && cd /%path%/libs/flux-mail-api && wget -O - https://docker-registry.fluxpublisher.ch/api/get-build-archive/flux-mail-api.tar.gz?tag=%tag% | tar -xz --strip-components=1)
```

or

Download https://docker-registry.fluxpublisher.ch/api/get-build-archive/flux-mail-api.tar.gz?tag=%tag% and extract it to `/%path%/libs/flux-mail-api`

Hint: If you use `wget` without pipe use `--content-disposition` to get the correct file name

#### Usage

```php
require_once __DIR__ . "/%path%/libs/flux-mail-api/autoload.php";
```

### Composer

```json
{
    "repositories": [
        {
            "type": "package",
            "package": {
                "name": "flux/flux-mail-api",
                "version": "%tag%",
                "dist": {
                    "url": "https://docker-registry.fluxpublisher.ch/api/get-build-archive/flux-mail-api.tar.gz?tag=%tag%",
                    "type": "tar"
                },
                "autoload": {
                    "files": [
                        "autoload.php"
                    ]
                }
            }
        }
    ],
    "require": {
        "flux/flux-mail-api": "*"
    }
}
```

## Environment variables

| Variable | Description | Default value |
| -------- | ----------- | ------------- |
| **FLUX_MAIL_API_MAIL_HOST** | Mail server host name | - |
| **FLUX_MAIL_API_MAIL_PORT** | Mail server port | - |
| **FLUX_MAIL_API_MAIL_TYPE** | Mail server type<br>imap, pop3 or nntp | - |
| **FLUX_MAIL_API_MAIL_USER_NAME** | Mail user name<br>Use *FLUX_MAIL_API_MAIL_USER_NAME_FILE* for docker secrets | - |
| **FLUX_MAIL_API_MAIL_PASSWORD** | Mail password<br>Use *FLUX_MAIL_API_MAIL_PASSWORD_FILE* for docker secrets | - |
| FLUX_MAIL_API_MAIL_ENCRYPTION_TYPE | Type to encrypt the connection to the server<br>ssl, tls or tls-auto | - |
| FLUX_MAIL_API_MAIL_BOX | Mail box path | INBOX |
| FLUX_MAIL_API_MAIL_MARK_AS_READ | Mark fetched mails as read | true |
| **FLUX_MAIL_API_SMTP_HOST** | SMTP server host name | - |
| **FLUX_MAIL_API_SMTP_PORT** | SMTP server port | - |
| **FLUX_MAIL_API_SMTP_FROM** | From email address | - |
| FLUX_MAIL_API_SMTP_FROM_NAME | From name | - |
| FLUX_MAIL_API_SMTP_ENCRYPTION_TYPE | Type to encrypt the connection to the server<br>ssl, tls or tls-auto | - |
| FLUX_MAIL_API_SMTP_USER_NAME | SMTP user name<br>Use *FLUX_MAIL_API_SMTP_USER_NAME_FILE* for docker secrets | - |
| FLUX_MAIL_API_SMTP_PASSWORD | SMTP password<br>Use *FLUX_MAIL_API_SMTP_PASSWORD_FILE* for docker secrets | - |
| FLUX_MAIL_API_SMTP_AUTH_TYPE | Type to authenticate on the server<br>PLAIN, LOGIN, CRAM-MD5 or XOAUTH2 | (Auto detect) |

Minimal variables required to set are **bold**

## Example

Look at [flux-mail-rest-api](https://github.com/flux-caps/flux-mail-rest-api)

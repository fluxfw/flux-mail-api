# FluxMailApi

## Environment variables

| Variable | Description | Default value |
| -------- | ----------- | ------------- |
| FLUX_MAIL_API_HTTPS_CERT | Path to HTTPS certificate file<br>Set this will enable listen on HTTPS<br>Should be on a volume | - |
| FLUX_MAIL_API_HTTPS_KEY | Path to HTTPS key file<br>Should be on a volume | - |
| FLUX_MAIL_API_LISTEN | Listen IP | 0.0.0.0 |
| FLUX_MAIL_API_PORT | Listen port | 9501 |
| **FLUX_MAIL_API_FETCH_HOST** | Mail server host name | - |
| **FLUX_MAIL_API_FETCH_PORT** | Mail server port | - |
| **FLUX_MAIL_API_FETCH_TYPE** | Mail server type<br>imap, pop3 or nntp | - |
| **FLUX_MAIL_API_FETCH_USER_NAME** | Mail user name | - |
| **FLUX_MAIL_API_FETCH_PASSWORD** | Mail password | - |
| FLUX_MAIL_API_FETCH_ENCRYPTION_TYPE | Type to encrypt the connection to the server<br>ssl, tls or tls-auto | - |
| FLUX_MAIL_API_FETCH_BOX | Mail box path | INBOX |
| FLUX_MAIL_API_FETCH_MARK_AS_READ | Mark fetched mails as read | true |
| **FLUX_MAIL_API_SMTP_HOST** | SMTP server host name | - |
| **FLUX_MAIL_API_SMTP_PORT** | SMTP server port | - |
| FLUX_MAIL_API_SMTP_ENCRYPTION_TYPE | Type to encrypt the connection to the server<br>ssl, tls or tls-auto | - |
| FLUX_MAIL_API_SMTP_USER_NAME | SMTP user name | - |
| FLUX_MAIL_API_SMTP_PASSWORD | SMTP password | - |
| FLUX_MAIL_API_SMTP_AUTH_TYPE | Type to authenticate on the server<br>PLAIN, LOGIN, CRAM-MD5 or XOAUTH2 | (Auto detect) |
| **FLUX_MAIL_API_SEND_FROM** | From email address | - |
| FLUX_MAIL_API_SEND_FROM_NAME | From name | - |

Minimal variables required to set are **bold**

## Examples

[examples](examples)

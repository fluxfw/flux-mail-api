#!/usr/bin/env sh

set -e

# TODO: Remove ignore-platform-reqs and patch (PHP8 support of php-imap/php-imap library)
composer install -d "$(dirname $0)/.." --no-dev --ignore-platform-reqs

"$(dirname $0)/../vendor/fluxlabs/fluxrestapi/bin/build.sh"

# https://github.com/barbushin/php-imap/issues/563#issuecomment-867584500
sed -i "s/\$reverse = (int) \$reverse;/\$reverse = (bool) \$reverse;/" "$(dirname $0)/../vendor/php-imap/php-imap/src/PhpImap/Imap.php"

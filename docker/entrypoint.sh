#!/bin/sh
set -e

APP=/var/www/duel_h/app

# core.php / database.php は gitignore 対象なので、無ければローカル用テンプレートを置く
for f in core.php database.php; do
  if [ ! -f "$APP/Config/$f" ]; then
    cp "/opt/duel_h-config/$f" "$APP/Config/$f"
    echo "[duel_h] Created app/Config/$f from docker/config/$f"
  fi
done

mkdir -p "$APP/tmp/cache/models" "$APP/tmp/cache/persistent" "$APP/tmp/cache/views" \
         "$APP/tmp/logs" "$APP/tmp/sessions" "$APP/tmp/tests"
chmod -R 777 "$APP/tmp"

exec docker-php-entrypoint "$@"

#!/usr/bin/env bash
set -euo pipefail

APP_PATH="${APP_PATH:-/var/www/pesantren}"
BRANCH="${BRANCH:-main}"

if [ ! -d "$APP_PATH" ]; then
  echo "Application path not found: $APP_PATH"
  exit 1
fi

cd "$APP_PATH"

git pull origin "$BRANCH"
php artisan down
composer install --no-interaction --prefer-dist --no-progress --no-dev --optimize-autoloader
npm ci --no-fund --no-audit
npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
chmod -R 775 storage bootstrap/cache
php artisan up

echo "Deployment completed successfully."

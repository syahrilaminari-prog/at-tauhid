# Production deployment checklist

## 1. Environment configuration
- Copy `.env.example` to `.env`.
- Set `APP_ENV=production` and `APP_DEBUG=false`.
- Set `APP_URL` to the final HTTPS domain.
- Generate a new `APP_KEY` with `php artisan key:generate`.
- Configure `DB_*`, `MAIL_*`, and `CACHE_*` values for the production server.
- Enable `SESSION_SECURE_COOKIE=true` and `SESSION_SAME_SITE=lax`.

## 2. Security hardening
- Ensure HTTPS is enforced with a valid TLS certificate.
- Keep `APP_FORCE_HTTPS=true` in production.
- Verify the security headers are present: `X-Frame-Options`, `X-Content-Type-Options`, `Referrer-Policy`, and `Permissions-Policy`.
- Restrict database, admin, and public access through the hosting firewall.
- Disable error display in production and log errors to files.

## 3. Laravel readiness
- Run:
  ```bash
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
  php artisan optimize
  ```
- Run migrations:
  ```bash
  php artisan migrate --force
  ```
- Ensure storage is writable and create a public symlink:
  ```bash
  php artisan storage:link
  ```

## 4. Backup and recovery
- Schedule database backup using `scripts/backup-database.ps1`.
- Store backup files in the `backups/` directory or a secure external storage.
- Keep at least one offsite or remote copy of the database backup.
- Test the restore process periodically.

## 5. Operational checks
- Confirm the public landing page loads correctly.
- Validate login, admin dashboard, and all role-based flows.
- Check queue workers and scheduler status.
- Monitor logs in `storage/logs` and alerts in the hosting platform.
- Review the application after the first production deployment before opening public access.

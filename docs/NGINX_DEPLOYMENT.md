# Nginx deployment

Set the Nginx document root to `/var/www/pdhfoundation/source/public` using `deploy/nginx/pdhfoundation.conf`.

```bash
sudo mkdir -p /var/www/pdhfoundation/source
sudo chown -R www-data:www-data /var/www/pdhfoundation
cd /var/www/pdhfoundation/source
sudo -u www-data composer install --no-dev --optimize-autoloader
sudo -u www-data cp .env.example .env
sudo -u www-data mkdir -p storage/logs storage/sessions public/uploads/{foundation,banks,cms/banners,slips}
sudo chown -R www-data:www-data storage public/uploads
sudo find storage public/uploads -type d -exec chmod 775 {} \;
sudo find storage public/uploads -type f -exec chmod 664 {} \;
sudo -u www-data php database/migrate.php
sudo nginx -t
sudo systemctl reload nginx php8.4-fpm
```

Set production values only in `/var/www/pdhfoundation/source/.env`, including `APP_ENV=production`, `APP_DEBUG=false`, the HTTPS `APP_URL`, and the production database credentials. Do not copy `.env` into Git.

Before each release, back up the database and `public/uploads`. Deploy with `git pull --ff-only`, run `composer install --no-dev --optimize-autoloader`, then run `php database/migrate.php`. To roll back application code, deploy the previous Git revision; restore the database backup before rolling back a migration that changed data or schema.

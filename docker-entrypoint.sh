#!/bin/sh
set -e

echo "Preparing Child Project environment..."

# Ensure all required cache directories exist
mkdir -p /var/www/html/storage/framework/cache/data
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/bootstrap/cache

# Fix permissions
find /var/www/html/storage /var/www/html/bootstrap/cache -type d -exec chmod 775 {} +
find /var/www/html/storage /var/www/html/bootstrap/cache -type f -exec chmod 664 {} +
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Clear caches
php artisan view:clear || true
php artisan config:clear || true
php artisan cache:clear || true

# Generate APP_KEY if not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Storage link
rm -rf /var/www/html/public/storage
ln -s ../storage/app/public /var/www/html/public/storage

# Run migrations (if DB is configured)
echo "Running migrations..."
php artisan migrate --force || echo "Migration failed (DB might not be ready), skipping..."

# Clear caches
php artisan view:clear || true
php artisan config:clear || true
php artisan cache:clear || true

echo "Starting Supervisor..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf

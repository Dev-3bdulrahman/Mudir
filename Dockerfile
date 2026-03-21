# Coolify Configuration for Child Project
FROM php:8.3-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
  nginx \
  libpng-dev \
  libjpeg-turbo-dev \
  freetype-dev \
  libzip-dev \
  zip \
  unzip \
  git \
  curl \
  oniguruma-dev \
  libxml2-dev \
  icu-dev \
  bash \
  shadow \
  nodejs \
  npm \
  mysql-client \
  supervisor

# Configure user
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install -j$(nproc) \
  gd zip pdo_mysql mbstring exif pcntl bcmath xml intl

# Configure PHP-FPM
RUN echo "listen = /tmp/php-fpm.sock" > /usr/local/etc/php-fpm.d/zz-docker.conf \
  && echo "listen.mode = 0666" >> /usr/local/etc/php-fpm.d/zz-docker.conf \
  && echo "listen.owner = www-data" >> /usr/local/etc/php-fpm.d/zz-docker.conf \
  && echo "listen.group = www-data" >> /usr/local/etc/php-fpm.d/zz-docker.conf

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer files
COPY composer.json composer.lock ./
RUN composer install --no-interaction --optimize-autoloader --no-dev --no-scripts

# Copy application
COPY . .
RUN composer dump-autoload --optimize
RUN npm install && npm run build

# Configure Nginx
COPY nginx.conf /etc/nginx/http.d/default.conf

# Configure Supervisor
RUN mkdir -p /etc/supervisor/conf.d
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Setup entrypoint
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Create directories and set permissions
RUN mkdir -p /var/www/html/storage/logs /var/www/html/bootstrap/cache \
  && chown -R www-data:www-data /var/www/html \
  && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 3000

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]

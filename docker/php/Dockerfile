FROM php:8.2-fpm-alpine AS builder

# Install build dependencies one by one (Alpine-specific packages only)
RUN apk add --no-cache build-base
RUN apk add --no-cache autoconf
RUN apk add --no-cache g++
RUN apk add --no-cache make
RUN apk add --no-cache libpng-dev
RUN apk add --no-cache libjpeg-turbo-dev
RUN apk add --no-cache freetype-dev
RUN apk add --no-cache libzip-dev
RUN apk add --no-cache oniguruma-dev
RUN apk add --no-cache postgresql-dev
RUN apk add --no-cache libxml2-dev
RUN apk add --no-cache zlib-dev
RUN apk add --no-cache bzip2-dev
RUN apk add --no-cache curl-dev
RUN apk add --no-cache icu-dev

# Configure GD extension with optimizations
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# Install PHP extensions one by one to avoid memory issues
RUN docker-php-ext-install pdo
RUN docker-php-ext-install pdo_pgsql
RUN docker-php-ext-install pgsql
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install zip
# RUN docker-php-ext-install fileinfo
RUN docker-php-ext-install exif
RUN docker-php-ext-install pcntl
RUN docker-php-ext-install bcmath
# RUN docker-php-ext-install tokenizer

# Install DOM and XML extensions separately
# RUN docker-php-ext-install dom
RUN docker-php-ext-install xml
# RUN docker-php-ext-install xmlreaderw
# RUN docker-php-ext-install xmlwriter

# Install GD extension (most memory intensive) - single threaded
RUN docker-php-ext-install gd

# Production stage
FROM php:8.2-fpm-alpine AS production

# Set arguments
ARG USER_ID=1000
ARG GROUP_ID=1000

# Install only runtime dependencies one by one
RUN apk add --no-cache libpng
RUN apk add --no-cache libjpeg-turbo
RUN apk add --no-cache freetype
RUN apk add --no-cache libzip
RUN apk add --no-cache zip
RUN apk add --no-cache jpegoptim
RUN apk add --no-cache optipng
RUN apk add --no-cache pngquant
RUN apk add --no-cache gifsicle
# RUN apk add --no-cache vim
RUN apk add --no-cache unzip
RUN apk add --no-cache git
RUN apk add --no-cache curl
RUN apk add --no-cache oniguruma
RUN apk add --no-cache postgresql-libs
RUN apk add --no-cache libxml2
RUN apk add --no-cache supervisor
RUN apk add --no-cache nodejs
RUN apk add --no-cache npm
RUN apk add --no-cache zlib
RUN apk add --no-cache bzip2
RUN apk add --no-cache icu-libs

# Copy PHP extensions from builder stage
COPY --from=builder /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=builder /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create application user
RUN addgroup -g ${GROUP_ID} siakadponpesdemo.bellukstudio.my.id && \
    adduser -D -s /bin/sh -u ${USER_ID} -G siakadponpesdemo.bellukstudio.my.id siakadponpesdemo.bellukstudio.my.id

# Set working directory
WORKDIR /var/www/siakadponpesdemo.bellukstudio.my.id

# Copy application files with proper ownership
COPY --chown=siakadponpesdemo.bellukstudio.my.id:siakadponpesdemo.bellukstudio.my.id . .

# Fix git ownership issue by configuring safe directory as root
RUN git config --global --add safe.directory /var/www/siakadponpesdemo.bellukstudio.my.id

# Set proper permissions before switching users
RUN chown -R siakadponpesdemo.bellukstudio.my.id:siakadponpesdemo.bellukstudio.my.id /var/www/siakadponpesdemo.bellukstudio.my.id && \
    chmod -R 755 /var/www/siakadponpesdemo.bellukstudio.my.id

# Create necessary directories with proper permissions
RUN mkdir -p /var/www/siakadponpesdemo.bellukstudio.my.id/vendor && \
    mkdir -p /var/www/siakadponpesdemo.bellukstudio.my.id/storage && \
    mkdir -p /var/www/siakadponpesdemo.bellukstudio.my.id/bootstrap/cache && \
    chown -R siakadponpesdemo.bellukstudio.my.id:siakadponpesdemo.bellukstudio.my.id /var/www/siakadponpesdemo.bellukstudio.my.id/vendor && \
    chown -R siakadponpesdemo.bellukstudio.my.id:siakadponpesdemo.bellukstudio.my.id /var/www/siakadponpesdemo.bellukstudio.my.id/storage && \
    chown -R siakadponpesdemo.bellukstudio.my.id:siakadponpesdemo.bellukstudio.my.id /var/www/siakadponpesdemo.bellukstudio.my.id/bootstrap/cache && \
    chmod -R 775 /var/www/siakadponpesdemo.bellukstudio.my.id/storage && \
    chmod -R 775 /var/www/siakadponpesdemo.bellukstudio.my.id/bootstrap/cache

# Switch to application user for composer and npm
USER siakadponpesdemo.bellukstudio.my.id

# Configure git for the application user as well
RUN git config --global --add safe.directory /var/www/siakadponpesdemo.bellukstudio.my.id

# Install dependencies
RUN composer install --optimize-autoloader --no-dev --no-interaction

# Install NPM dependencies and build assets
# RUN npm ci --only=production && npm run build && npm cache clean --force

# Expose port 9000
EXPOSE 9000

# Start php-fpm
CMD ["php-fpm"]

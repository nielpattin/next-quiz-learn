FROM webdevops/php-nginx:8.3-alpine

# Set working directory
WORKDIR /app

# Install additional dependencies as root
USER root
RUN apk add --no-cache postgresql-client libpq php83-pdo php83-pdo_pgsql \
    && mkdir -p /app/storage/framework/cache /app/storage/framework/sessions /app/storage/framework/views /app/bootstrap/cache \
    && chown -R application:application /app \
    && chmod -R 775 /app/storage /app/bootstrap/cache

# Copy application code
COPY --chown=application:application . .

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Composer dependencies
RUN composer install --no-dev --optimize-autoloader

# Set environment variables for Laravel
ENV WEB_DOCUMENT_ROOT=/app/public
ENV APP_ENV=production
ENV APP_DEBUG=false

# Optimize Laravel (commands moved to custom entrypoint script)

# Copy custom entrypoint script and make it executable
COPY --chown=application:application docker-entrypoint-custom.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint-custom.sh

# Set custom entrypoint
CMD ["docker-entrypoint-custom.sh"]
FROM php:8.3.11-apache

# Instalar dependencias del sistema
RUN apt-get update -y && apt-get install -y \
    openssl zip unzip git nano sqlite3 \
    && docker-php-ext-install pdo_mysql

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copiar el código del proyecto
COPY . /var/www/html
COPY ./public/.htaccess /var/www/html/.htaccess
WORKDIR /var/www/html

# Configurar Git como seguro para evitar warnings
RUN git config --global --add safe.directory /var/www/html

# Instalar dependencias de Laravel
RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

# Crear base de datos SQLite y asegurar permisos
RUN mkdir -p database \
    && touch database/database.sqlite \
    && chmod -R 777 database \
    && chmod -R 777 storage

# Generar clave y preparar la aplicación
RUN php artisan key:generate
RUN php artisan migrate --seed --force
RUN php artisan storage:link

# Configurar Apache para apuntar a public/
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf
RUN sed -i 's|AllowOverride None|AllowOverride All|g' /etc/apache2/apache2.conf

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Exponer el puerto HTTP
EXPOSE 80

# Comando principal
CMD ["apache2-foreground"]
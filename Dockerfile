# Multi-stage build para Laravel
FROM php:8.2-cli AS build

WORKDIR /app

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl libpng-dev libonig-dev libxml2-dev \
    libpq-dev libicu-dev libfreetype6-dev libjpeg62-turbo-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensões PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install pdo_pgsql zip gd intl

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copiar arquivos de dependências
COPY composer.json composer.lock ./

# Instalar dependências PHP
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copiar código fonte
COPY . .

# Preparar ambiente para Laravel
RUN cp .env.example .env && \
    composer dump-autoload --optimize

# Stage de produção
FROM php:8.2-apache

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    libzip-dev unzip libpng-dev libonig-dev libxml2-dev zip \
    libpq-dev libicu-dev libfreetype6-dev libjpeg62-turbo-dev \
    libapache2-mod-evasive && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensões PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install pdo_pgsql zip gd intl && \
    docker-php-ext-enable pdo_pgsql

# Configurar Apache
RUN a2enmod rewrite evasive && \
    sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# Configurar evasive
RUN mkdir -p /var/log/apache2/evasive && \
    chown -R www-data:www-data /var/log/apache2/evasive
COPY ./evasive.conf /etc/apache2/mods-available/evasive.conf

# Copiar aplicação
WORKDIR /var/www/html
COPY --from=build /app /var/www/html

# Remover .env de build e configurar permissões
RUN rm -f .env && \
    chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html && \
    chmod -R 775 storage bootstrap/cache

# Script de inicialização simplificado
RUN echo '#!/bin/bash\n\
if [ ! -f .env ]; then\n\
    cp .env.example .env\n\
    sed -i "s/APP_ENV=local/APP_ENV=production/" .env\n\
    sed -i "s/APP_DEBUG=true/APP_DEBUG=false/" .env\n\
fi\n\
if ! grep -q "APP_KEY=base64:" .env; then\n\
    php artisan key:generate --no-interaction --force\n\
fi\n\
if [ ! -f bootstrap/cache/config.php ]; then\n\
    php artisan config:cache\n\
    php artisan route:cache\n\
    php artisan view:cache\n\
fi\n\
chown -R www-data:www-data storage bootstrap/cache\n\
apache2-foreground' > /usr/local/bin/start.sh && \
    chmod +x /usr/local/bin/start.sh

EXPOSE 80
CMD ["/usr/local/bin/start.sh"]
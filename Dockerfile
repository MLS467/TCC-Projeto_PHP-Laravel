# Etapa 1: Construção com Composer
FROM composer:2 AS build

WORKDIR /app

# Copia todo o projeto primeiro
COPY . .

# Garante que o .env exista durante a instalação (alguns pacotes precisam)
RUN cp .env.example .env

# Instala dependências do Composer
RUN composer install --no-dev --optimize-autoloader

# Etapa 2: Container final com Apache e PHP
FROM php:8.2-apache

# Instala extensões PHP necessárias
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl libpng-dev libonig-dev libxml2-dev zip \
    && docker-php-ext-install pdo pdo_mysql zip

# Ativa o mod_rewrite no Apache (necessário para Laravel)
RUN a2enmod rewrite

# Define diretório de trabalho
WORKDIR /var/www/html

# Copia o projeto já com dependências instaladas
COPY --from=build /app /var/www/html

# Ajusta permissões (importante para storage e cache)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Expõe porta padrão do Apache
EXPOSE 80

# Comando para iniciar Apache
CMD ["apache2-foreground"]

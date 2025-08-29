# Etapa 1: Construção com Composer
FROM composer:2 AS build

WORKDIR /app

# Copia composer.json e composer.lock primeiro para aproveitar cache do Docker
COPY composer.json composer.lock ./

# Instala dependências do Composer sem scripts
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copia o resto do projeto
COPY . .

# Cria um .env temporário para evitar erros durante o build
RUN cp .env.example .env || echo "APP_KEY=" > .env

# Executa scripts do composer após ter todos os arquivos
RUN composer dump-autoload --optimize

# Etapa 2: Container final com Apache e PHP
FROM php:8.2-apache

# Instala extensões PHP necessárias (com pdo_pgsql)
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl libpng-dev libonig-dev libxml2-dev zip \
    libpq-dev  # Instala as bibliotecas de desenvolvimento do PostgreSQL

# <--- adiciona aqui limita requisições abusivas
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl libpng-dev libonig-dev libxml2-dev zip \
    libpq-dev \
    libapache2-mod-evasive

RUN a2enmod evasive

# cria pasta de logs pro evasive
RUN mkdir -p /var/log/apache2/evasive && chown -R www-data:www-data /var/log/apache2/evasive

COPY ./evasive.conf /etc/apache2/mods-available/evasive.conf

# Instala a extensão pdo_pgsql
RUN docker-php-ext-install pdo pdo_pgsql zip

# Ativa o mod_rewrite no Apache (necessário para Laravel)
RUN a2enmod rewrite

# Ajusta DocumentRoot para apontar para o diretório public do Laravel
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# Define diretório de trabalho
WORKDIR /var/www/html

# Copia o projeto já com dependências instaladas
COPY --from=build /app /var/www/html

# Remove o .env temporário do build
RUN rm -f /var/www/html/.env

# Ajusta permissões (importante para storage e cache)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Cria script de inicialização
RUN echo '#!/bin/bash\n\
# Cria .env se não existir\n\
if [ ! -f /var/www/html/.env ]; then\n\
    cp /var/www/html/.env.example /var/www/html/.env\n\
fi\n\
\n\
# Gera chave da aplicação se não existir\n\
if ! grep -q "APP_KEY=base64:" /var/www/html/.env; then\n\
    php artisan key:generate --no-interaction\n\
fi\n\
\n\
# Cache de configuração\n\
php artisan config:cache\n\
php artisan route:cache\n\
php artisan view:cache\n\
\n\
# Inicia Apache\n\
apache2-foreground' > /usr/local/bin/start.sh \
    && chmod +x /usr/local/bin/start.sh

# Expõe porta padrão do Apache
EXPOSE 80

# Comando para iniciar com configuração do Laravel
CMD ["/usr/local/bin/start.sh"]

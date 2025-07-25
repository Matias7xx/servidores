# Use uma imagem base oficial do PHP com Apache
FROM php:8.2-apache

#RUN useradd -m -s /bin/bash -G www-data harbor

# Instale as extensões necessárias
RUN apt-get update && apt-get install -y \
    sudo \
    nano \
    libpng-dev \
    libjpeg-dev \
    libpq-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    nodejs \
    npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_pgsql pdo_mysql zip

# Habilite o módulo de reescrita do Apache
RUN a2enmod rewrite

# Configurar o Apache para servir o Laravel
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Configurar o tamanho máximo de upload e de post criando o arquivo customizado
RUN echo "upload_max_filesize = 1G\npost_max_size = 1G\nmemory_limit = 1024M\nmax_execution_time = 1200" > /usr/local/etc/php/conf.d/uploads.ini \
    && cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini

# Instale o Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Copie o conteúdo do projeto para o diretório de trabalho no container
COPY . /var/www/html
COPY entrypoint.sh /entrypoint.sh

# Defina as permissões corretas
RUN chown -R www-data:www-data /var/www/html \
    && chmod +x /entrypoint.sh

# Comando para iniciar o Apache
CMD ["/entrypoint.sh"]

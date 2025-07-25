#!/bin/bash

# Saia imediatamente em caso de erro
set -e

# Instala as dependências do Composer, se o vendor não existir
composer install --no-interaction --prefer-dist --optimize-autoloader

# Gera a chave da aplicação, caso não exista
php artisan key:generate --force

# Executa as migrações do banco de dados
php artisan migrate --force

# Cria o link simbólico para o storage, se ainda não existir
php artisan storage:link

echo "🏗️ Executando install e build do npm..."
npm install
npm run build

# Executa qualquer outra preparação necessária
php artisan config:clear
php artisan route:clear
# php artisan config:cache
# php artisan route:cache

#Iniciar o processamento das filas
# php artisan queue:work

# Inicie o Apache no foreground
apache2-foreground

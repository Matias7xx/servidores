#!/bin/bash
set -e

echo "Instalando dependências..."
composer install --no-interaction --prefer-dist --optimize-autoloader

echo "Gerando chave da aplicação..."
php artisan key:generate --force

echo "Executando migrações..."
php artisan migrate --force

echo "Criando link simbólico do storage..."
php artisan storage:link

#echo "Executando install e build do npm..."
#npm install
#npm run build

echo "Limpando cache..."
php artisan config:clear
php artisan route:clear

echo "Ajustando permissões de pasta..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

echo "Iniciando servidor Apache..."
apache2-foreground

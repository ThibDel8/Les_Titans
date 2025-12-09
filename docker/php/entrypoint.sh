#!/bin/sh
set -e

# Création des dossiers si absents
mkdir -p /var/www/html/public/images/profiles

# Correction des droits (volume monté)
chown -R www-data:www-data /var/www/html/public/images
chmod -R 775 /var/www/html/public/images

# Lancer PHP-FPM
exec php-fpm

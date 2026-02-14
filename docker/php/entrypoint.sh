#!/bin/sh
set -e

# Création des dossiers si absents
mkdir -p /var/www/html/public/images/profiles

# Lancer PHP-FPM
exec php-fpm

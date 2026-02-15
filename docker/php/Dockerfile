# Dockerfile pour PHP 8.4-FPM + Symfony (WSL2 friendly)
FROM php:8.4-fpm

# Récupérer Composer depuis l'image officielle
COPY --from=composer:2.9.5 /usr/bin/composer /usr/bin/composer

# Droits User pour WSL2
ARG UID=1000
ARG GID=1000

# Installer les dépendances système et extensions PHP
RUN apt-get update && apt-get install -y --no-install-recommends \
        apt-utils \
        gnupg \
        ca-certificates \
        unzip \
        p7zip-full \
        zip \
        git \
        curl \
        libpng-dev \
        libjpeg62-turbo-dev \
        libwebp-dev \
        libxpm-dev \
        libfreetype6-dev \
        libonig-dev \
        libicu-dev \
        libzip-dev \
        imagemagick \
        libmagickwand-dev \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
        --with-xpm \
    && docker-php-ext-install -j$(nproc) pdo_mysql gd intl opcache zip \
    && pecl install imagick xdebug \
    && docker-php-ext-enable imagick xdebug \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Copier l’entrypoint
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

WORKDIR /var/www/html

RUN if ! getent group ${GID}; then groupadd -g ${GID} app; fi \
 && useradd -u ${UID} -g ${GID} -m app || true

USER app

ENTRYPOINT ["entrypoint.sh"]

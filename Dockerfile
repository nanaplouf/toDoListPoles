FROM php:8.2-fpm

# Installer dépendances système et extension MongoDB
RUN apt-get update && apt-get install -y \
    git unzip libssl-dev pkg-config && \
    pecl install mongodb && \
    docker-php-ext-enable mongodb

# Copier Composer depuis l'image officielle
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copier uniquement les fichiers de Composer d'abord
COPY composer.json composer.lock* ./

# Installer les dépendances PHP (en ignorant la vérification de l’extension)
RUN composer install --no-interaction --no-progress --ignore-platform-req=ext-mongodb || true

# Copier le reste du projet
COPY . .

# Lancer composer install au démarrage (utile en dev si vendor est monté)
CMD composer install --no-interaction --no-progress --ignore-platform-req=ext-mongodb && php-fpm
# Utiliser une image Apache officielle avec PHP intégré
FROM php:7.4-apache

# Copier la configuration Apache
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Copier les fichiers du site
COPY . /var/www/html/

# Donner les bonnes permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Activer les modules Apache nécessaires
RUN a2enmod rewrite

# Exposer le port 80
EXPOSE 80

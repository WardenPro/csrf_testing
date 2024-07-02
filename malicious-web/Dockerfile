FROM php:7.4-apache

COPY apache.conf /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite

EXPOSE 80

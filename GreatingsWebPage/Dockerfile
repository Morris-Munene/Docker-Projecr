FROM php:8.2-apache

COPY index.php /var/www/html/

WORKDIR /var/www/html

RUN docker-php-ext-install opcache

CMD ["apache2-foreground"]

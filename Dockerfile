# Mara: Dockerfile für PHP 8.2 mit Apache
FROM php:8.2-apache

# Mara: PDO MySQL Extension installieren falls der user sie nicht schon hat
RUN docker-php-ext-install pdo pdo_mysql

# Mara: Apache mod_rewrite aktivieren
RUN a2enmod rewrite

# Mara: Apache DocumentRoot auf /var/www/html setzen 
# AllowOverride für .htaccess aktivieren
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

WORKDIR /var/www/html

FROM php:8.3-apache
RUN a2enmod rewrite
RUN docker-php-ext-install pdo_mysql
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf
# COPY . /var/www/html/
EXPOSE 80

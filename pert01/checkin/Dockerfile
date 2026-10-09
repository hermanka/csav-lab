FROM php:8.3-apache
RUN apt-get update && apt-get install -y \
    libcurl4-openssl-dev \
    && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install curl
# COPY index.php /var/www/html/index.php
# COPY style.css /var/www/html/style.css
EXPOSE 80

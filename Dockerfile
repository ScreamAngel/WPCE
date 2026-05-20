# Resmi PHP ve Apache imajını kullan
FROM php:8.2-apache

# PostgreSQL için gerekli sistem kütüphanelerini ve PHP eklentilerini kur
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# Proje dosyalarını sunucuya kopyala
COPY . /var/www/html/

# Portu aç
EXPOSE 80

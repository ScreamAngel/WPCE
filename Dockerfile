# Resmi PHP ve Apache imajını kullan
FROM php:8.2-apache

# MySQL bağlantısı için gerekli eklentileri kur
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Proje dosyalarını sunucuya kopyala
COPY . /var/www/html/

# Portu aç
EXPOSE 80

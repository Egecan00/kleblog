FROM php:8.3-fpm 
 
# Sisteme gerekli paketlerin yüklenmesi 
RUN apt-get update && apt-get install -y \ 
    build-essential \ 
    libpng-dev \ 
    libjpeg62-turbo-dev \ 
    libfreetype6-dev \ 
    locales \ 
    zip \ 
    jpegoptim optipng pngquant gifsicle \ 
    vim \ 
    unzip \ 
    git \ 
    curl \ 
    && docker-php-ext-install pdo_mysql 
 
# Composer'ı yükleyin 
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer 
 
WORKDIR /var/www 
EXPOSE 9000 
CMD ["php-fpm"]
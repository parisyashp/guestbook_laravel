# FROM php:8.2-fpm-alpine
# This is the base image. It means our image will start with a minimal Linux distribution (Alpine)
# that already has PHP 8.2 with PHP-FPM installed.
# PHP-FPM (FastCGI Process Manager) is the component that executes PHP code,
# typically used with web servers like Nginx or Apache.
FROM php:8.2-fpm-alpine

# WORKDIR /var/www/html
# Sets the working directory inside the container. All subsequent commands (COPY, RUN, CMD)
# will be executed relative to this directory unless specified otherwise.
# This is where your Laravel project files will reside.
WORKDIR /var/www/html

# RUN apk add --no-cache ...
# `apk` is the package manager for Alpine Linux.
# `add --no-cache` ensures that package caches are not stored, keeping the image size small.
# We install system-level dependencies required by Laravel or its extensions:
# - git: Often needed for Composer to download packages from Git repositories.
# - curl: A command-line tool for transferring data, used by various scripts.
# - zip, unzip: For handling compressed files, common for Composer.
# - mysql-client: Command-line client for MySQL, useful for interacting with the DB server
#                 from within the container (e.g., for `php artisan migrate`).
# - libpng-dev, libjpeg-turbo-dev: Development libraries for image processing.
#   Needed if you enable the 'gd' PHP extension, which is good for basic image handling.
# - nodejs, npm: JavaScript runtime and package manager. Essential if your Laravel app uses
#   frontend build tools like Laravel Mix or Vite (check for `package.json` in your project).
#   If `guestbook_laravel` doesn't use them, you can comment out/remove these for a smaller image.
RUN apk add --no-cache \
    git \
    curl \
    zip \
    unzip \
    mysql-client \
    libpng-dev \
    libjpeg-turbo-dev \
    nginx 
    #nodejs \
    #npm

# RUN docker-php-ext-install pdo_mysql gd
# This command compiles and installs specific PHP extensions.
# - pdo_mysql: PHP Data Objects (PDO) extension for MySQL. Absolutely essential for Laravel
#              to connect to a MySQL database.
# - gd: Graphics Draw extension for image manipulation. Useful if you ever need to resize
#       images or create thumbnails within your Laravel app.
RUN docker-php-ext-install pdo_mysql gd

# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
# This is a multi-stage build technique. It takes the `composer` executable
# from the official Composer Docker image (latest version) and copies it
# into our current image. This ensures we have the latest Composer.
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# *** CRITICAL CHANGE HERE: COPY ALL APPLICATION CODE BEFORE COMPOSER INSTALL ***
# This ensures 'artisan' and other project files are present
COPY . .

# Copy Nginx configuration into the container
# Ini adalah konfigurasi Nginx yang akan digunakan oleh Nginx di dalam container ini.
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# Setel izin yang benar untuk folder storage dan cache Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Hapus konfigurasi Nginx default jika ada
RUN rm /etc/nginx/conf.d/default.conf || true 

# Expose port 80 untuk Nginx (Web Server)
EXPOSE 80
# Expose port 9000 untuk PHP-FPM (opsional, untuk debugging langsung ke FPM)
EXPOSE 9000

# Buat script entrypoint kustom untuk menjalankan PHP-FPM dan Nginx secara bersamaan
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh 
RUN chmod +x /usr/local/bin/entrypoint.sh 

# Gunakan script entrypoint kustom
ENTRYPOINT ["entrypoint.sh"]
# CMD tidak diperlukan di sini karena entrypoint.sh akan menjalankan keduanya.
# CMD ["php-fpm"] # Ini akan digantikan oleh entrypoint.sh
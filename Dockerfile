# Usa una imagen oficial de PHP con Apache incorporado
FROM php:8.2-apache

# Habilita el módulo de reescritura de Apache (útil para URLs limpias)
RUN a2enmod rewrite

# Instala dependencias del sistema y extensiones de PHP necesarias para SQLite (PDO)
RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite

# Copia todos los archivos de tu proyecto al directorio web del servidor Apache
COPY . /var/www/html/

# Asegura los permisos correctos para que la base de datos SQLite se pueda escribir en el contenedor
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html

# Expone el puerto estándar de Apache
EXPOSE 80
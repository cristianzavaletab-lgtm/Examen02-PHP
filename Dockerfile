# Usa la imagen oficial de PHP con Apache
FROM php:8.2-apache

# Habilitar SQLite en PDO
RUN apt-get update && \
    apt-get install -y sqlite3 libsqlite3-dev && \
    docker-php-ext-install pdo pdo_sqlite

# Habilitar mod_rewrite para Apache (útil para URLs limpias)
RUN a2enmod rewrite

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Copiar archivos del proyecto
COPY . /var/www/html/

# Dar permisos a la carpeta de uploads y a la base de datos para que Apache pueda escribir
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/uploads \
    && chmod 777 /var/www/html

# Exponer el puerto de Apache
EXPOSE 80

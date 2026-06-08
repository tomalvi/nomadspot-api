FROM richarvey/nginx-php-fpm:latest

# Copiar el proyecto al contenedor
COPY . /var/www/html

# Configurar el directorio raíz para Laravel
ENV WEBROOT /var/www/html/public
ENV APP_ENV production

# Instalar dependencias de PHP sin entorno de desarrollo
RUN composer install --no-dev --optimize-autoloader

# Dar permisos correctos a las carpetas de almacenamiento
RUN chown -R nw:nw /var/www/html/storage /var/www/html/bootstrap/cache
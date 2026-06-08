# Usamos una versión específica que incluye PHP 8.4
FROM richarvey/nginx-php-fpm:php84-latest

# Copiar el proyecto al contenedor
COPY . /var/www/html

# Configurar el directorio raíz para Laravel
ENV WEBROOT /var/www/html/public
ENV APP_ENV production

# Forzar a Composer a instalar saltándose restricciones si fuera necesario, 
# aunque con PHP 8.4 pasará limpio
RUN composer install --no-dev --optimize-autoloader

# Dar permisos correctos a las carpetas de almacenamiento
RUN chown -R nw:nw /var/www/html/storage /var/www/html/bootstrap/cache
#!/bin/bash

# 🔥 Forzar la creación de tablas e importación al arrancar
echo "🚀 Ejecutando migraciones..."
php artisan migrate --force

echo "📥 Importando datos de ciudades..."
# php artisan data:import

echo "⚡ Optimizando caché de Laravel..."
php artisan config:clear
php artisan optimize

echo "🟢 Arrancando el servidor web..."
php artisan serve --host=0.0.0.0 --port=$PORT
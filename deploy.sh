#!/bin/bash

echo "⚡ Optimizando caché de Laravel..."
php artisan config:clear
php artisan optimize

echo "🟢 Arrancando el servidor web..."
php artisan serve --host=0.0.0.0 --port=$PORT
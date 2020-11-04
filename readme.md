# movies-api
Laravel movies API


# Instalar laravel 5.8

composer create-project laravel/laravel="5.8.*" movies-api


# Modificar archivo .env

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=movies_api_rest
DB_USERNAME={}
DB_PASSWORD={}


# Instalar dependencias

composer update


# Ejecutar las migraciones

php artisan migrate


# Generar llaves

php artisan passport:install


# Poblar las tablas

php artisan db:seed


# Ejecutar el servidor

php artisan serve

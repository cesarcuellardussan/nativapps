

# Despliegue de la API Médica de Pacientes

Este documento describe cómo desplegar la API Médica de Pacientes en una máquina con Docker y Docker Compose instalados, o en una máquina con Laragon instalado.

## Opción 1: Con Docker Compose

Clona el proyecto en una máquina que tenga Docker y Docker Compose instalados.

git clone https://github.com/cesarcuellardussan/nativapps.git

Accede al directorio del proyecto.

cd medical-patients-api

Ejecuta los siguientes comandos para construir e iniciar la API.

sudo docker-compose build

sudo docker-compose up -d

Copia el archivo .env.example a .env.

sudo docker exec nativapps_php_1 cp .env.example .env

Instala las dependencias de Composer.

sudo docker exec nativapps_php_1 composer install

Migra la base de datos y crea los datos de prueba.

sudo docker exec nativapps_php_1 php artisan  migrate:fresh --seed

Si recibes un error de permisos en la carpeta storage, ejecuta los siguientes comandos para otorgar permisos al usuario www-data.

sudo docker container exec -it nativapps_php_1 bash

chown -R www-data:www-data storage

chmod -R 775 storage

exit

sudo docker-compose restart

Una vez que hayas completado estos pasos, la API estará disponible en la dirección IP de tu máquina en el puerto 80.

## Opción 2: Con Laragon

Descarga e instala Laragon.

Clona el proyecto en la carpeta www de Laragon.

git clone https://github.com/cesarcuellardussan/nativapps.git
Instala PHP 8.1.10.

Dentro del proyecto raiz de la carpeta llamada medical-patients-api ejecuta los siguientes comandos:

cp .env.example .env
composer install
php artisan migrate:fresh --seed

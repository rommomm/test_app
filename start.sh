#!/bin/bash

cp src/.env.example src/.env
cd .docker
cp .env.example .env

# Fetch the user's UID and GID
uid=$(id -u)
gid=$(id -g)

# Update PUID and PGID values in the .env file
sed -i "s/PUID=[0-9]*/PUID=$uid/" .env
sed -i "s/PGID=[0-9]*/PGID=$gid/" .env

# Start app
docker-compose stop
docker-compose build
docker-compose up -d
docker-compose run php composer install
docker-compose run php php artisan queue:table
docker-compose run php php artisan migrate:fresh


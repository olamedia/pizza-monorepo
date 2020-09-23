#!/bin/sh

docker-compose -f ./pizza-docker/docker-compose.yml run backend php artisan migrate:fresh --seed


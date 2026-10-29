#!/usr/bin/env sh
set -eu

docker compose up -d --build
docker compose exec -T app php artisan migrate --seed
printf 'Doce Gestão disponível em http://localhost:8000\n'

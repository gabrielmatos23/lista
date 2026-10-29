#!/usr/bin/env sh
set -eu

docker compose build
if [ ! -f database/database.sqlite ]; then
  touch database/database.sqlite
fi
docker compose run --rm app php artisan key:generate --force
docker compose run --rm app php artisan migrate:fresh --seed

#!/bin/bash
docker run --rm \
    --pull=always \
    -v "$(pwd)":/opt \
    -w /opt \
    laravelsail/php82-composer:latest \
    bash -c "composer install" \
&& cp .env.example .env \
&& ./vendor/bin/sail up -d \
&& ./vendor/bin/sail artisan key:generate \
&& ./vendor/bin/sail npm install --prefix frontend \
&& ./vendor/bin/sail artisan migrate:fresh \
&& ./vendor/bin/sail artisan db:seed --class=TestRecipesSeeder \
&& ./vendor/bin/sail test

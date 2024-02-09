#!/bin/bash
./vendor/bin/sail artisan migrate:fresh --database=mysql-test \
&& ./vendor/bin/sail artisan db:seed --class=TestRecipesSeeder --database=mysql-test \
&& ./vendor/bin/sail dusk

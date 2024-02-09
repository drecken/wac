# How To

## Build

```
git clone git@github.com:drecken/wac.git
cd wac
sh scripts/build.sh
```

This script should end with passing all the PHPUnit tests

> the command for running frontend differs depending if we are running it for testing `npm run test` or for
> browsing `npm run dev`

## Test

### PHPUnit

```
./vendor/bin/sail test
```

### Dusk

> **start the frontend server for _dusk tests_ in another terminal**

```
./vendor/bin/sail npm run test --prefix frontend
```

then continue with

```
sh scripts/dusk.sh
```

check `tests/Browser/screenshots` for some screenshots

on Windows you can use

```
explorer.exe `wslpath -w "$PWD"./tests/Browser/screenshots/`
```

### Frontend

> Make sure the backend server is not running

> **start the frontend server for _host_ [browsing](http://localhost:3000/recipes)**

```
./vendor/bin/sail npm run dev --prefix frontend
 ```

## Seed

Testing data

```
./vendor/bin/sail artisan db:seed --class=TestRecipesSeeder
 ```

Recipe with 2-5 ingredients & 3-8 steps

```
./vendor/bin/sail artisan db:seed --class=RecipeSeeder
```

10 recipes

```
./vendor/bin/sail artisan db:seed
```

# Packages Used

- [jzonta/faker-restaurant](https://github.com/jzonta/FakerRestaurant) - recipe & ingredient names
- [spatie/eloquent-sortable](https://github.com/spatie/eloquent-sortable) - steps ordering
- [spatie/laravel-sluggable](https://github.com/spatie/laravel-sluggable) - recipe slug generation
- [spatie/laravel-query-builder](https://github.com/spatie/laravel-query-builder) - JSON:API query parameters
- [spatie/laravel-json-api-paginate](https://github.com/spatie/laravel-json-api-paginate) - JSON:API pagination

# Notes

## Database

Could improve the normalization, especially with ingredients, but would have to make a lot more assumptions.

### Search

used simple like statements, in the future, probably switch to Scout

### Slug

The package is great, generates the slug using observer on create and handle uniqueness

### Ordering

Again handled by the package, Spatie packages are great

### Recipes

all fields are required

### Email

it is not specified if in order to add a recipe you need to be a registered user

I assume that anyone can add a recipe without being logged in, and the email can be provided in the recipe form

it will not be a unique field since one email address may create multiple recipes

### Ingredients

I assume its just a one to many relationship with a name field

If ingredients were a many to many table

- this would require to have a predefined list of them or a lot more work to allow user to create them
- could add quantity and units to the pivot table (conversion from cups to grams)
- could add singular and plural columns for irregular plural forms ex `leaf/leaves`
- would make it more cumbersome for users to create recipes, but it would give us a lot better data we could use in the
  future

### Steps

I assume its just a one to many orderable relationship with a description field

### Search

Search is triggered by pressing enter, or clicking the search button

Keyword - I assume its just like Ingredient but for all text fields

## Fronted (Nuxt.js, TypeScript & Pinia)

First time working with all three, had to read the documentation many times. Overall I think I did ok, but there's
definitely room for improvement.

In Nuxt add something for generating routes to api instead of using `useRuntimeConfig().public.apiBase +`

spent too much time on
issues [1](https://github.com/unjs/ofetch/issues/156) & [2](https://github.com/nuxt/nuxt/issues/15031)

had to resort to `{server: false}` when using `useFetch` (eventually used `$fetch`)

errors after installing pinia using `sail npm install` without `--prefix frontend`

I know there are some type issues but I decided not to spend any more time trying to fix them for the mvp

Decided to just use [MVP.css](https://andybrewer.github.io/mvp/) instead of Tailwind to save some time

Could probably extract some components out of the pages (like the pagination).

**Definitely need some error handling**

## Dusk

Also used it for the first time, wasted a lot of time getting it to work with Nuxt.js. I feel like there's definitely
room improvement in how it's all set up, but I just wanted to get it done at this point. Would prefer to not have to run
frontend with a different command for testing.

## Issue with Getting started

Couldn't connect to the database using `docker exec -it laravel-mysql-1 bash -c "mysql -uroot -ppassword"`.
Received `Error response from daemon: No such container: laravel-mysql-1` 

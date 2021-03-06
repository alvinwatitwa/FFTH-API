# FFTH API

Done using Laravel framework and php 


## Database ERD

The below is a diagram illustrating the db schema and entity relations diagram:

![img](https://github.com/alvinwatitwa/FFTH-API/blob/fdee006146b151ea8b727fc7b96bed3d5950da66/screenshots/ffth-erd-resized.png)


## Getting Started

Clone the project by running

```
git clone https://github.com/alvinwatitwa/FFTH-API.git
```
### Prerequisites


run the following commands

```
cp .env.example .env

```
create a mysql database

set the login credentials of the database in your env file

then run the following commands

```
composer install
php artisan migrate
php artisan key:generate
php artisan passport:install
php artisan db:seed
```

then start the development server by running

```
php artisan serve
```

## Routes
```
routes/api.php
```

## Postman Api Documentation

https://documenter.getpostman.com/view/5053664/Tzz5uyh9

## Testing

Please run the following command for testing

```
vendor/bin/phpunit  tests\Feature\Http\Controllers\Api\ChildControllerTest.php
```

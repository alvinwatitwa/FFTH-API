# FFTH API

Done using Laravel framework and php 7.2

## Getting Started

Clone the project by running

```
git clone https://github.com/ngarawakimani/ffth_api.git
```
### Prerequisites

create a mysql database 

run the following commands

```
cp .env.example .env
php artisan key:generate

```

set the name of your database in your env file

then run the following commands

```
composer install
php artisan migrate
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

## Authorisation
![img](https://github.com/ngarawakimani/ffth_api/blob/develop/screenshots/2019-07-08_0105.png)

## Make a GET Request
![img](https://github.com/ngarawakimani/ffth_api/blob/develop/screenshots/2019-07-08_0106.png)

## Example Successfull Request
![img](https://github.com/ngarawakimani/ffth_api/blob/develop/screenshots/2019-07-08_0108.png)

## Example Unsuccessfull Request
![img](https://github.com/ngarawakimani/ffth_api/blob/develop/screenshots/2019-07-08_0107.png)

## Testing

Please run the following command for unit testing

```
vendor/bin/phpunit  tests\Feature\Http\Controllers\Api\ChildControllerTest.php
```

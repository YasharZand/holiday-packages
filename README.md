

## About AirAsia Holiday Package App

This API provides the CRUD functions for Holiday Packages and their Reservations. It was written to fullfil an AirAsia code challenge. Written in Laravel 8.0 as a RESTfull API with Laravel Passport authentication.


## Installation

First download the code using git or any other way you prefer:
```bash
https://github.com/YasharZand/holiday-packages.git
```
Then install all dependancies by running composer in the workspace root directory:
```bash
composer install
php artisan key:generate
```
Set your database credentials in the .env file
Do a migrate so the schema be deployed in your database gracefullly
```bash
php artisan migrate 
```
or 
```bash
php artisan migrate:fresh
```
Lastly setup the client passport configs:
```bash
php artisan passport:install
```
Your API is ready to run if no errors up to this point.

## Running the API backend

To run the backend you can simply use:
```bash
php artisan serve
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

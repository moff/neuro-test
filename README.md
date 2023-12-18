# Installation

- clone the repository
- cd into the cloned repository directory
- run command `cp .env.example .env` and set credentials for databases (dev and test) in that file
- cd into application folder and run command `cp .env.example .env` and set database credentials in that file (don't forget to copy constants for testing database as well)
- start the app using command `docker-compose up -d`
- install Composer dependencies via `docker-compose run --rm -u laravel app composer install --prefer-dist --optimize-autoloader` or `make composer-install`
- generate APP_KEY via `docker-compose exec -u laravel app php artisan key:generate`

To ensure that the app is up and running open `http://localhost:8082/` in a browser

!!! [Database diagram file](NeuroDB.png)

# Running tests

Migrate test database using command `docker-compose exec -u laravel app php artisan migrate:fresh --database=mysql-testing`
Or alternatively you can use Makefile command `make migrate-test-db`

To run tests use command `docker-compose exec -u laravel app php artisan test`
Or alternatively you can use Makefile command `make test`

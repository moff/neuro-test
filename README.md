# Installation

- clone the repository
- run command `cp .env.example .env` and set credentials for databases (dev and test) in that file
- cd into the cloned repository directory
- start the app using command `docker-compose up -d`

To ensure that the app is up and running open `http://localhost:8082/` in a browser


# Running tests

First you have to configure connection to MySQL in `phpunit.xml`, add this to `<php>` section:
```xml
<server name="DB_CONNECTION" value="mysql-testing" force="true"/>
```

To run tests use command `docker-compose exec -u laravel app php artisan test`

Or alternatively you can use Makefile command `make test`

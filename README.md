## Decription
This is test project for Drivvn company done by Adam Olecký. Project runs in dockerized enviroment using Symfony framework and Doctrine ORM.

## Getting Started

1. Run `docker compose up --build --force-recreate -d` (no need to force recreate or build flags fo fist run, but generally this is also 'reset images and containers' command)
2. Open `http://localhost` in your favorite web browser (SSL certificate is self-signed. Postman is working, but browsers could have problem)
3. Cli to php container to run commands: `docker exec -it drivvn-test-php-1 /bin/sh`

## What's next?

Project should be set by now. You could use makefile in root folder or execute following commands in container manually (for example if name collision prevents script from running) to reset DB if corrupted. 

### Run inside php container:
1. run creation of DB: `bin/console doctrine:database:create`
2. run migrations: `bin/console doctrine:migrations:migrate`
3. run fixtures: `bin/console doctrine:fixtures:load`
4. run creation of test DB: `bin/console -env=test docntrine:schema:create`
5. if you are annoyed by deprecated stuff showing in cli run: `export SYMFONY_DEPRECATIONS_HELPER=weak`

## Run tests

Because there are application tests is involving test DB, there is need to populate tables with fixtures first.

### Run inside php container:
1. `php bin/console --env=test doctrine:fixtures:load` to populate test DB
2. `php bin/phpunit` to run unit tests

## PHPCS & PHPStan 
PHP cs fixer: 
`tools/php-cs-fixer/vendor/bin/php-cs-fixer fix src`
`tools/php-cs-fixer/vendor/bin/php-cs-fixer fix tests`

PHP Stan: 
`vendor/bin/phpstan analyse src tests`


## Requests
### POST /cars
Checks of the request are performed on the level of validators and before insertions into DB. That assures for example, that there is no possibility of adding non-existent id to db. 

```
curl --location --request POST 'http://localhost/cars' \
--header 'Content-Type: application/json' \
--data-raw '{
    "make": "skoda",
    "model": "a6",
    "build_at": "2010-08-02 13:37:55",
    "colours": [1]
}'
```
### GET /car/<id>
```
curl --location --request GET 'http://localhost/car/1'
```
### DELETE /cars/<id>
```
curl --location --request DELETE 'http://localhost/cars/1'
```
### GET /cars
```
curl --location --request GET 'http://localhost/cars'
```

## Optional

### How to document API? 
Best course of action seems like Swagger OpenApi. With Swagger UI we could generate page, that could serve users both as testing range for request and documentation. (https://github.com/swagger-api/swagger-ui)

### How can extra data models improve design? 
Because entities and models represents real world scenarios it is hard to say what would be best course of action. But we can see that there are car params: make and model. Assuming that there could be more cars from one maker and more than one model we are would have problems with data redundancy. Meaning there would be multiple rows with same or inconsistent values. Therefore creating maker entity and model entity could solve this issue. Relations could for example : 

car -> many to one -> model -> many to one -> maker (assuming that one model is made only by one maker)

## Summary
That should be enough to run test project. After loading fixtures it should contain one car, 4 colors (colours) in app DB. I also made little change on naming preferences for build date param, where i used build_at (which is by default accepted by doctrine orm as datetime format). 

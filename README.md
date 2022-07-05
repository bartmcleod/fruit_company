# FruitCompany
A demo project demonstrating maintainable database integration testing

## Run it
```apacheconf
docker compose up -d
```

## Install the app
```apacheconf
docker compose exec php composer install
```

## Create databases and load data
You need two databases:
 1. fruit_company
 2. fruit_company_test

Load the structure in fruit_company
Load each of the table contents from data/ in fruit_company if you want sample data
@todo: provide commands


## Run tests
```apacheconf
docker compose exec php bash
vendor/bin/phpunit
```
or (where php is the docker compose service name)
```apacheconf
docker compose exec php vendor/bin/phpunit
```

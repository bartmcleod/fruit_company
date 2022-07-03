# FruitCompany
A demo project demonstrating maintainable database integration testing

## Run it
```apacheconf
docker compose up -d
```

## Install the app
Run this command (on the host, for now, should be in docker)
```apacheconf
composer install
```

## Run unit tests
```apacheconf
docker compose exec php bash
vendor/bin/phpunit
```

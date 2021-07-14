## DeFiChain Masternode Health

Masternode Health is a microservice to collect, analyse and optionally inform about the server and masternode stats 
/ health.

All functions can be used with an rest API. Docu can be found here in wiki as soon as it's released.

## setup Masternode Health by yourself

This service is based on the PHP framework Laravel. For local development, you can use the included docker setup 
(`docker-compose up -d`).

Then copy the `.env` using `cp .env.example .env` and then generate a new application key `php artisan key:generate`.

After that you need to install the composer dependencies (`composer install`) and run the database migrations (`php 
artisan migrate`).

## using docker alias

It's best practice to use docker for all the commands above. To use the docker commands in an effective way, you 
might want to setup some alias commands. You can use this demo alias setup:

- alias dc='docker-compose'
- alias dart='docker-compose exec app php artisan'
- alias dphp='docker-compose exec app php'
- alias dtests=' docker-compose -f docker-compose.yml run --rm app vendor/bin/phpunit'
- alias dcomposer='docker-compose run --rm -u www-data app composer'

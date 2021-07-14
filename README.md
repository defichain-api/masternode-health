## DeFiChain Masternode Health

Masternode Health is a microservice to collect, analyse and optionally inform about the server and masternode stats 
/ health.

All functions can be used with an rest API. Docu can be found here in wiki as soon as it's released.

## setup Masternode Health by yourself

This service is based on the PHP framework Laravel. For local development, you can use the included docker setup 
(`docker-compose up -d`).
After that you need to install the composer dependencies (`composer install`) and run the database migrations (`php 
artisan migrate`).


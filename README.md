# DeFiChain Masternode Health

Masternode Health is a microservice to collect, analyse and inform about the server and masternode stats / health.

All functions can be used with an rest API. [Docu can be here](http://docs.defichain-masternode-health.com/).

# companion server script

To use this tool in an effective way, we recommend to use
the [companion python app](https://github.com/defichain-api/masternode-health-server).

# setup Masternode Health by yourself

This service is based on the PHP framework Laravel. For local development, you can use the included docker setup
(`docker-compose up -d`).

Then copy the `.env` using `cp .env.example .env` and then generate a new application key `php artisan key:generate`.

After that you need to install the composer dependencies (`composer install`) and run the database
migrations (`php artisan migrate`).

# Bugs or suggestions?
Open issue or submit a pull request to
[https://github.com/defichain-api/masternode-health/issues](https://github.com/defichain-api/masternode-health/issues)

# License
MIT

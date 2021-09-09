![DeFiChain Community Project](https://blog.defichain.com/content/images/size/w2000/2021/05/DeFiChain-Community-Projects.png)

![CI](https://github.com/github/docs/actions/workflows/main.yml/badge.svg)
[![codecov](https://codecov.io/gh/defichain-api/masternode-health/branch/master/graph/badge.svg?token=7OI2BYPCI8)](https://codecov.io/gh/defichain-api/masternode-health)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)


# DeFiChain Masternode Health

Masternode Health is a microservice to collect, analyse and inform about the server and masternode stats / health.

All functions can be used with an rest API. [Docu can be here](http://docs.defichain-masternode-health.com/).

# companion server script

To use this tool in an effective way, we recommend to use
the [companion python app](https://github.com/defichain-api/masternode-health-server).

# setup Masternode Health by yourself

This service is based on the PHP framework Laravel.

Then copy the `.env` using `cp .env.example .env` and then generate a new application key `php artisan key:generate`.
In this file you need to add your own DB and Redis configuration.

After that you need to install the composer dependencies (`composer install`) and run the database
migrations (`php artisan migrate`).

## local testing & development
For local development, you can use the included docker setup
(`docker-compose up -d`). The `.env.example` is preconfigured for this setup.

# Bugs or suggestions?
Open issue or submit a pull request to
[https://github.com/defichain-api/masternode-health/issues](https://github.com/defichain-api/masternode-health/issues)

# License
MIT

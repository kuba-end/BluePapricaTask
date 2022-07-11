# BluePaprica


## Pre-installation

Your system must have the following packages installed:

| Package       | Version |
|---------------|---------|
| PHP           | \>= 8.0 |
| MySQL         | \>= 5.7 |


## Configuration

To set-up your Database credentials you need first to run the following command:
```bash
cp .env .env.local
```
And edit **only** the `.env.local` file.

## Installation

### Development environment

#### 1. Setup

**a)** Install
```bash
composer install
bin/console doctrine:database:create
bin/console doctrine:schema:create
symfony server:start
```
#### 2. Run tests

**a)** PHPSpec
```bash
vendor/bin/phpspec run
```

**b)** Coding Standard

```bash
vendor/bin/ecs check src
```


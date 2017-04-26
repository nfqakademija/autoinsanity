# AutoInsanity

[![Build Status](https://scrutinizer-ci.com/g/nfqakademija/autoinsanity/badges/build.png?b=master)](https://scrutinizer-ci.com/g/nfqakademija/autoinsanity/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/nfqakademija/autoinsanity/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/nfqakademija/autoinsanity/?branch=master)

# Project Description

This web project collects vehicle adverts from various websites and allows users to browse this data.

# Environment requirements

* PHP 7.1
* MySQL
* Symfony 3.2

# Installation
## Download and prepare the project

1. Install [Git](https://git-scm.com/downloads)
1. Clone repository `git clone https://github.com/nfqakademija/autoinsanity.git`
1. cd 'autoinsanity'
1. Get [Composer](https://getcomposer.org/download/)
1. Run `composer install`

## Prepare database - run commands:
1. Create database with `bin/console doctrine:database:create --if-not-exists`
1. Create tables with `bin/console doctrine:schema:update --force`
1. Run `php bin/console doctrine:fixtures:load` to insert all needed fixtures to the database.

## Run project

1. Run `php bin/console server:start`
1. Go to `http://127.0.0.1:8000/`

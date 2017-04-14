# AutoInsanity

[![Build Status](https://scrutinizer-ci.com/g/nfqakademija/autoinsanity/badges/build.png?b=master)](https://scrutinizer-ci.com/g/nfqakademija/autoinsanity/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/nfqakademija/autoinsanity/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/nfqakademija/autoinsanity/?branch=master)

# Table of Contents

* [Project Description](#project-description)
* [Requirements](#requirements)
* [Prepare project](#download)
* [Prepare database](#database)
* [Run project](#run)

# <a name="project-description"></a>Project Description

This web project collects vehicle adverts from various websites and allows users to browse this data.

# <a name="requirements"></a>Environment requirements

* PHP (7.0)
* MySQL
* Symfony 3.2

## <a name="download"></a>Download and prepare the project

1. Install [Git](https://git-scm.com/downloads)
1. Clone repository 'git clone https://github.com/nfqakademija/autoinsanity.git'
1. cd 'autoinsanity'
1. Get [Composer](https://getcomposer.org/download/)
1. Run 'composer install'

## <a name="database"></a>Prepare database - run commands:

* Run 'php bin/console doctrine:fixtures:load' to insert all needed fixtures to the database.

## <a name="run"></a>Run project

1. Run 'php bin/console server:start'
1. Go to 'http://127.0.0.1:8000/'

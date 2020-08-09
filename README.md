# AtariLegend

The AtariLegend project

AtariLegend is a website for Atari ST enthusiasts and retro gamers in general.
The site has been up since 2004, but was abandoned around 2009. It is time for
an update/upgrade :wink:

# Local installation

Follow the instructions below to setup your local environment. Alternatively,
use the [pre-configured Docker setup](Docker/README.md).

## Prerequisites

* A web server with PHP, with the `mysqli` and `gd` extensions (Require PNG and JPEG support)
* MySQL, with the SQL mode `only_full_group_by` disabled (e.g. `sql_mode=''`)
* NodeJS + NPM + Composer

## Instructions

* Clone the project from GitHub
* Install the Composer dependencies: `composer install -d public/php/`
* Install the NPM dependencies: `npm install`
* Run Grunt to generate the CSS files: `npm run grunt`
* Point your web server document root to `public/`
* Obtain a dump of the database and import it into your MySQL server (See: https://www.atarilegend.com/data/database-dumps/)
* Obtain a copy of the images and import them in `public/data/images` (See same URL above)
* Create a PHP file containing the MySQL connection details in `public/php/config/connection_settings.php`:

```php
<?php

$db_host = "YOUR_DB_HOSTNAME";
$db_username = "YOUR_DB_USER_NAME";
$db_password = "YOUR_DB_PASSWORD";
$db_databasename = "YOUR_DB_NAME";
```

* Create a PHP file containing the SMTP settings in `public/php/config/email_settings.php`:

```php
<?php

$email_mailer = 'smtp';   // See PHPMailer for possible values
$smtp_username = '...';
$smtp_password = '...';
$smtp_port = 587;
$smtp_host = '...';
$smtp_auth = true;
$smtp_secure = 'ssl';
```

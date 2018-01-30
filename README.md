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
* NodeJS + NPM

## Instructions

* Clone the project from GitHub
* Install the NPM dependencies: `npm install`
* Run Grunt to generate the CSS files: `npm run grunt`
* Point your web server document root to `Website/AtariLegend/`
* Obtain a dump of the database and import it into your MySQL server
* Create a PHP file containing the MySQL connection details in `Website/AtariLegend/php/config/connection_settings.php`:

```php
<?php

$db_host = "YOUR_DB_HOSTNAME";
$db_username = "YOUR_DB_USER_NAME";
$db_password = "YOUR_DB_PASSWORD";
$db_databasename = "YOUR_DB_NAME";
```
=======
Atarilegend is a website for Atari ST enthousiasts and retro gamers in general. The site has been up since 2004, but was abandonned around 2009. It is time for an update/upgrade ;-)


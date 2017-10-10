# AtariLegend
The AtariLegend project

AtariLegend is a website for Atari ST enthusiasts and retro gamers in general.
The site has been up since 2004, but was abandoned around 2009. It is time for
an update/upgrade :wink:

# Local installation

## Prerequisites

* A web server with PHP, with the `mysqli` and `gd` extensions (Require PNG and JPEG support)
* MySQL
* NodeJS + NPM

## Instructions

* Clone the project from GitHub
* Install the NPM dependencies: `npm install`
* Run Grunt to generate the CSS files: `npm run grunt`
* Point your web server document root to `AtariLegend/Website/AtariLegend/`
* Obtain a dump of the database and import it into your MySQL server
* Create a PHP file containing the MySQL connection details in `Website/AtariLegend/php/config/connect.php`:

```php
<?php
$db_username = "YOUR_DB_USER_NAME";
$db_password = "YOUR_DB_PASSWORD";
$db_databasename = "YOUR_DB_NAME";

$mysqli = new mysqli("YOUR_DB_SERVER", $db_username, $db_password, $db_databasename);
?>
```

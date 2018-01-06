<?php
/**
 * Script to purge old database and media dumps (backups and public dumps)
 *
 * Takes one argument: The path to the folder containing the dumps to purge.
 *
 * Dumps are expected to be named with a date, e.g. 2017-01-01<something>
 */

// Interval of backups to keep. See the PHP DateInterval class for the syntax
const PURGE_INTERVAL = "P30D";

// Ensure this script is only run on command line
if (php_sapi_name() !== "cli") {
    die("This script can only be run on the command line");
}

// Check presence of file path in arguments
if (sizeof($argv) < 2) {
    echo "Usage: ".basename(__FILE__)." </path/to/dumps>\n\n";
    echo "  Purge DB or media dumps older than an interval (".PURGE_INTERVAL.")\n";
    exit(1);
}

$path = $argv[1];

$oldest_date = new DateTime();
$oldest_date->sub(new DateInterval(PURGE_INTERVAL));

echo "Dumps older than ".$oldest_date->format("Y-m-d")." will be purged.\n\n";

foreach (scandir($path) as $file) {
    if (preg_match("/^(\d{4}-\d{2}-\d{2})/", $file, $matches)) {
        $filedate = new DateTime($matches[1]);
        $filepath = $path."/".$file;

        if ($filedate < $oldest_date) {
            echo "Removing old dump: $filepath\n";
            unlink($filepath) or die("Error deleting dump $filepath");
        } else {
            echo "Keeping recent dump: $filepath\n";
        }
    }
}

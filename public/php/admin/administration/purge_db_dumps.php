<?php
/**
 * Script to purge old database and media dumps (backups and public dumps)
 *
 * Takes one argument: The path to the folder containing the dumps to purge.
 *
 * Dumps are expected to be named with a date, e.g. 2017-01-01<something>
 */

// Interval of backups to keep. See the PHP DateInterval class for the syntax
const DEFAULT_PURGE_INTERVAL = "P30D";

// Ensure this script is only run on command line
if (php_sapi_name() !== "cli") {
    die("This script can only be run on the command line");
}
// Ensure we're using PHP 7.1+, needed for the $optind argument to getopt()
if (version_compare(phpversion(), "7.1.0", "<")) {
    die("This script requires PHP 7.1 or above");
}

// Check presence of file path in arguments
if (sizeof($argv) < 2) {
    echo "Usage: ".basename(__FILE__)." [-q] </path/to/dumps>\n\n";
    echo "  Purge DB or media dumps older than an interval\n\n";
    echo "  -q            Quiet mode (only report errors)\n";
    echo "  -i=<interval> Interval to purge (see PHP DateInterval for the syntax)\n";
    echo "                Defaults to: ".DEFAULT_PURGE_INTERVAL."\n";
    exit(1);
}

$options = getopt("qi::", [], $optind);
$quiet_mode = isset($options["q"]);

$path = $argv[$optind];

$oldest_date = new DateTime();
if (isset($options["i"])) {
    $oldest_date->sub(new DateInterval($options["i"]));
} else {
    $oldest_date->sub(new DateInterval(DEFAULT_PURGE_INTERVAL));
}

if (!$quiet_mode) {
    echo "Dumps older than ".$oldest_date->format("Y-m-d")
        ." will be purged from: $path\n\n";
}

$files = scandir($path) or die("Unable to list files from: $path");
foreach ($files as $file) {
    if (preg_match("/^(\d{4}-\d{2}-\d{2})/", $file, $matches)) {
        $filedate = new DateTime($matches[1]);
        $filepath = $path."/".$file;

        if ($filedate < $oldest_date) {
            if (!$quiet_mode) {
                echo "Removing old dump: $filepath\n";
            }
            unlink($filepath) or die("Error deleting dump $filepath");
        } else {
            if (!$quiet_mode) {
                echo "Keeping recent dump: $filepath\n";
            }
        }
    }
}

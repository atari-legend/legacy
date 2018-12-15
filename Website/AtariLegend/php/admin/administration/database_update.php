<?php

/**
 * Locate database upgrade scripts in INI files and execute them.
 */

require_once __DIR__."/../../config/common.php";
require_once __DIR__."/../../config/admin.php";

//load the search fields of the quick search side menu
require_once __DIR__."/../../admin/games/quick_search_games.php";

require_once __DIR__."/../common/DatabaseUpdate.php";
require_once __DIR__."/../../common/DAO/ChangeDAO.php";

$changeDao = new \AL\Common\DAO\ChangeDao($mysqli);

$updates = [];

// Find all INI files containing DB updates
foreach (glob("../../admin/administration/database_scripts/**/*.ini") as $filename) {
    $update_folder = dirname($filename);
    $id = (int) basename($update_folder);
    $ini = parse_ini_file($filename);

    $updates[$id] = new \AL\Admin\Common\DatabaseUpdate(
        $db_databasename,
        $id,
        $filename,
        $ini["description"],
        $ini["condition"],
        $ini["execute_on"],
        // Some updates may not have an SQL statement if they have an addition.php script
        isset($ini["sql"]) ? $ini["sql"] : null,
        // Auto-execute by default, if not set
        isset($ini["autoexecute"]) ? filter_var($ini["autoexecute"], FILTER_VALIDATE_BOOLEAN) : true,
        // Do not disable foreign key constraints by default
        isset($ini["disable_fk"]) ? filter_var($ini["disable_fk"], FILTER_VALIDATE_BOOLEAN) : false,
        file_exists("$update_folder/addition.php")
    );
}

// Sort array by database update id
asort($updates);

foreach ($updates as $update) {
    // Do we already have this update in our database_change table?
    $change = $changeDao->getChangeByUpdateId($update->getId());

    if ($change == null) {
        // Change doesn't exist in the DB, has never been run

        // Run test condition query
        $condition_resultset = $mysqli->query($update->getCondition())
            or die("Failed to execute test condition for update ".$update->getId()
                ." (".$update->getCondition().") : ".$mysqli->error);

        // Check if the condition query was supposed to fail or not
        $condition_query_result = \AL\Admin\Common\DatabaseUpdate::EXECUTE_ON_FAILURE;
        if ($condition_resultset->fetch_row()) {
            // Condition query succeeded
            $condition_query_result = \AL\Admin\Common\DatabaseUpdate::EXECUTE_ON_SUCCESS;
        }
        $condition_resultset->free();

        // Should we execute it automatically, or was it requested as a specific update?
        if ($update->getAutoExecute()
            || (isset($execute_id) && $update->getId() == $execute_id)) {
            // Only execute if the condition query is in the expected
            // failed / succeeded state
            if ($condition_query_result == $update->getExecuteOn()) {
                // Being a transaction so that we don't let the DB in an unstable
                // state if something goes wrong
                mysqli_begin_transaction($mysqli) or die("Error while starting transaction: ".$mysqli->error);
                if ($update->getDisableForeignKeyChecks()) {
                    $mysqli->query("SET foreign_key_checks = false");
                }

                if ($update->hasAdditionScript()) {
                    // Run addition script
                    require_once __DIR__."/database_scripts/".$update->getId()."/addition.php";
                } else {
                    // Run query specified in INI file
                    $mysqli->query($update->getSql())
                        or die("Error executing script ".$update->getId()
                            ." (".$update->getSql()."): ".$mysqli->error);
                }

                // Restore FK checks
                $mysqli->query("SET foreign_key_checks = true");

                // Insert change in database
                $change = new \AL\Common\Model\Database\Change(
                    -1,
                    $update->getId(),
                    $update->getDescription(),
                    time(),
                    'implemented',
                    $update->getFilename(),
                    $update->hasAdditionScript()
                        ? file_get_contents(__DIR__."/database_scripts/".$update->getId()."/addition.php")
                        : file_get_contents($update->getFilename())
                );
                $changeDao->insertChange($change);

                // Commit transaction
                mysqli_commit($mysqli) or die("Unable to commit transaction: ".$mysqli->error);
            }

            $smarty->append('database_update', array(
                'database_update_id' => $update->getId(),
                'update_description' => $update->getDescription(),
                'implementation_state' => 'implemented',
                'allow_execute' => "no",
                'file_name' => $update->getFilename(),
                'test_result' => ""
            ));
        } else {
            // Change is NOT set to auto-execute
            $can_be_executed = $condition_query_result == $update->getExecuteOn();
            $smarty->append('database_update', array(
                'database_update_id' => $update->getId(),
                'update_description' => $update->getDescription(),
                'implementation_state' => ($can_be_executed ? 'pending' : 'test condition failed'),
                'allow_execute' => ($can_be_executed ? "yes" : "no"),
                'file_name' => $update->getFilename(),
                'test_result' => ($can_be_executed
                    ? "Ready to Execute"
                    : "Expected ".$update->getExecuteOn()." but got $condition_query_result")
            ));
        }
    } else {
        // Change already existed in database
        $smarty->append('database_update', array(
            'database_update_id' => $change->getUpdateId(),
            'update_description' => $change->getDescription(),
            'implementation_state' => $change->getState(),
            'allow_execute' => "no",
            'file_name' => $change->getFilename(),
            'test_result' => ""
        ));
    }
}

// Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "database_update.html");

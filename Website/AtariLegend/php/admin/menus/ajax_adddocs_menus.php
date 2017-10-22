<?php
/***************************************************************************
*                             ajax_adddocs_menus.php
*                            -----------------------
*   begin                : 2016
*   copyright            : (C) 2016 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : Creation from scratch for smarty usage
*
*   Id: ajax_adddocs_menus.php,v 0.1 2016/10/14 STG
*
***************************************************************************/

/*
***********************************************************************************
Build game series page
***********************************************************************************
*/
include("../../config/common.php");
include("../../config/admin.php");

        //set base sqls
            $sql_build = "SELECT game.game_id AS 'software_id',
                           game.game_name AS 'software_name',
                           game_publisher.pub_dev_id as 'publisher_id',
                           pd1.pub_dev_name as 'publisher_name',
                           game_developer.dev_pub_id as 'developer_id',
                           pd2.pub_dev_name as 'developer_name',
                           game_year.game_year AS 'year',
                           'Game' AS software_type
                           FROM game
                           LEFT JOIN game_year on (game_year.game_id = game.game_id)
                           LEFT JOIN game_publisher ON (game_publisher.game_id = game.game_id)
                           LEFT JOIN pub_dev pd1 ON (pd1.pub_dev_id = game_publisher.pub_dev_id)
                           LEFT JOIN game_developer ON (game_developer.game_id = game.game_id)
                           LEFT JOIN pub_dev pd2 on (pd2.pub_dev_id = game_developer.dev_pub_id)";

            $sql_build_aka = "SELECT game.game_id AS 'software_id',
                           game_aka.aka_name AS 'software_name',
                           game_publisher.pub_dev_id as 'publisher_id',
                           pd1.pub_dev_name as 'publisher_name',
                           game_developer.dev_pub_id as 'developer_id',
                           pd2.pub_dev_name as 'developer_name',
                           game_year.game_year AS 'year',
                           'Game' AS software_type
                           FROM game_aka
                           LEFT JOIN game ON (game_aka.game_id = game.game_id)
                           LEFT JOIN game_year on (game_year.game_id = game.game_id)
                           LEFT JOIN game_publisher ON (game_publisher.game_id = game.game_id)
                           LEFT JOIN pub_dev pd1 ON (pd1.pub_dev_id = game_publisher.pub_dev_id)
                           LEFT JOIN game_developer ON (game_developer.game_id = game.game_id)
                           LEFT JOIN pub_dev pd2 on (pd2.pub_dev_id = game_developer.dev_pub_id)";

            $sql_build_tool = "SELECT tools.tools_id AS 'software_id',
                                tools.tools_name AS 'software_name',
                                '' AS publisher_id,
                                'n/a' AS publisher_name,
                                '' AS developer_id,
                                'n/a' AS developer_name,
                                'n/a' AS year,
                                'Tool' AS software_type
                                FROM tools";

if (isset($action) and ($action=="game_browse" xor $action=="game_search")) {
    // Create WHERE clause for browse dropdown
    if ($action=="game_browse") {
        if (isset($query) and $query== "num") {
            $sql_build .= " WHERE game_name REGEXP '^[0-9].*'";
            $sql_build_aka .= " WHERE aka_name REGEXP '^[0-9].*'";
            $sql_build_tool .= " WHERE tools_name REGEXP '^[0-9].*'";
        } else {
            $sql_build .= " WHERE game_name LIKE '$query%'";
            $sql_build_aka .= " WHERE aka_name LIKE '$query%'";
            $sql_build_tool .= " WHERE tools_name LIKE '$query%'";
        }
    }
    // Create WHERE clause for search field
    if ($action=="game_search") {
        if (isset($query) and $query!=="empty") {
            $query = $mysqli->real_escape_string($query);
            $sql_build .= " WHERE game_name LIKE '%$query%'";
            $sql_build_aka .= " WHERE aka_name LIKE '%$query%'";
            $sql_build_tool .= " WHERE tools_name LIKE '%$query%'";
        } elseif ($query=="empty") {
            $sql_build .= " WHERE game_name REGEXP '^[0-9].*'";
            $sql_build_aka .= " WHERE aka_name REGEXP '^[0-9].*'";
            $sql_build_tool .= " WHERE tools_name REGEXP '^[0-9].*'";
        }
    }

    $sql_build .= " GROUP BY game_name";
    $sql_build_aka .= " GROUP BY aka_name";
    $sql_build_tool .= " GROUP BY tools_name";

    //Perform queries
    $mysqli->query("CREATE TEMPORARY TABLE temp ENGINE=MEMORY $sql_build") or die(mysqli_error());
    $mysqli->query("INSERT INTO temp $sql_build_aka") or die(mysqli_error());
    $mysqli->query("INSERT INTO temp $sql_build_tool") or die("Couldn't query Software Database7 ($sql_build_tool)");

    $sql_series_link = $mysqli->query("SELECT * FROM temp ORDER BY software_name ASC") or die(mysqli_error());

    $smarty->assign('smarty_action', 'game_list');

    while ($query_series_link = $sql_series_link->fetch_array(MYSQLI_BOTH)) {
        // This smarty is used for creating the list of games contained within a game series
        $smarty->append('series_link', array(
            'game_id' => $query_series_link['software_id'],
            'game_name' => $query_series_link['software_name'],
            'publisher_id' => $query_series_link['publisher_id'],
            'publisher_name' => $query_series_link['publisher_name'],
            'developer_id' => $query_series_link['developer_id'],
            'developer_name' => $query_series_link['developer_name'],
            'software_type' => $query_series_link['software_type'],
            'year' => $query_series_link['year']));
    }
}

    // Create dropdown values a-z
    $az_value = az_dropdown_value(0);
    $az_output = az_dropdown_output(0);

    $smarty->assign('az_value', $az_value);
    $smarty->assign('az_output', $az_output);
    $smarty->assign('mySelect', 'num');
    $smarty->assign('menu_disk_id', $menu_disk_id);

if (isset($list) and $list=="full") {
    $smarty->assign('smarty_action', 'full_list');
} else {
    $smarty->assign('smarty_action', 'inner_list');
}

//Send all smarty variables to the templates
$smarty->display("file:".$cpanel_template_folder."ajax_menus_add_docs.html");

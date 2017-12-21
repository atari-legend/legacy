<?php
/***************************************************************************
 *                                db_menu_function.php
 *                            -----------------------
 *   begin                : oct 26, 2017
 *   copyright            : (C) 2017 Atari Legend
 *   email                : silversurfer@atari-forum.com
 *   actual update        : Start.
 *
 *   - The purpose of this file is to gather some functions relating to the
 *     admin menus section.
 *
 ***************************************************************************/

//
// Software list connected to a menu disk
//
function menu_disk_software_list($menu_disk_id) {
    global $mysqli;

    $sql_games = "SELECT game.game_id AS 'software_id',
         game.game_name AS 'software_name',
         pub_dev.pub_dev_id AS 'developer_id',
         pub_dev.pub_dev_name AS 'developer_name',
         game_year.game_year AS 'year',
         menu_disk_title.menu_disk_title_id,
         menu_types_main.menu_types_text,
         menu_disk_title_author.menu_disk_title_author_id,
         menu_disk_title_set.menu_disk_title_set_chain
         FROM menu_disk_title
         LEFT JOIN menu_disk_title_author ON (menu_disk_title_author.menu_disk_title_id = menu_disk_title.menu_disk_title_id)
         LEFT JOIN menu_disk_title_set ON (menu_disk_title_set.menu_disk_title_id = menu_disk_title.menu_disk_title_id)
         LEFT JOIN menu_disk_title_game ON (menu_disk_title.menu_disk_title_id = menu_disk_title_game.menu_disk_title_id)
         LEFT JOIN game ON (menu_disk_title_game.game_id = game.game_id)
         LEFT JOIN game_developer ON (game.game_id = game_developer.game_id)
         LEFT JOIN pub_dev ON (game_developer.dev_pub_id = pub_dev.pub_dev_id)
         LEFT JOIN game_year ON (game.game_id = game_year.game_id)
         LEFT JOIN menu_types_main ON (menu_disk_title.menu_types_main_id = menu_types_main.menu_types_main_id)
         WHERE menu_disk_title.menu_disk_id = '$menu_disk_id' AND menu_disk_title.menu_types_main_id = '1' ORDER BY game.game_name ASC";

    $sql_demos = "SELECT demo.demo_id AS 'software_id',
         demo.demo_name AS 'software_name',
         crew.crew_id AS 'developer_id',
         crew.crew_name AS 'developer_name',
         demo_year.demo_year AS 'year',
         menu_disk_title.menu_disk_title_id,
         menu_types_main.menu_types_text,
         menu_disk_title_author.menu_disk_title_author_id,
         menu_disk_title_set.menu_disk_title_set_chain
         FROM menu_disk_title
         LEFT JOIN menu_disk_title_author ON (menu_disk_title_author.menu_disk_title_id = menu_disk_title.menu_disk_title_id)
         LEFT JOIN menu_disk_title_set ON (menu_disk_title_set.menu_disk_title_id = menu_disk_title.menu_disk_title_id)
         LEFT JOIN menu_disk_title_demo ON (menu_disk_title.menu_disk_title_id = menu_disk_title_demo.menu_disk_title_id)
         LEFT JOIN demo ON (menu_disk_title_demo.demo_id = demo.demo_id)
         LEFT JOIN demo_year ON (demo.demo_id = demo_year.demo_id)
         LEFT JOIN crew_demo_prod ON (demo.demo_id = crew_demo_prod.demo_id)
         LEFT JOIN crew ON (crew_demo_prod.crew_id = crew.crew_id)
         LEFT JOIN menu_types_main ON (menu_disk_title.menu_types_main_id = menu_types_main.menu_types_main_id)
         WHERE menu_disk_title.menu_disk_id = '$menu_disk_id' AND menu_disk_title.menu_types_main_id = '2' ORDER BY demo.demo_name ASC";

    $sql_tools = "SELECT tools.tools_id AS 'software_id',
         tools.tools_name AS 'software_name',
         '' AS developer_id,
         '' AS developer_name,
         '' AS year,
         menu_disk_title.menu_disk_title_id,
         menu_types_main.menu_types_text,
         menu_disk_title_author.menu_disk_title_author_id,
         menu_disk_title_set.menu_disk_title_set_chain
         FROM menu_disk_title
         LEFT JOIN menu_disk_title_author ON (menu_disk_title_author.menu_disk_title_id = menu_disk_title.menu_disk_title_id)
         LEFT JOIN menu_disk_title_set ON (menu_disk_title_set.menu_disk_title_id = menu_disk_title.menu_disk_title_id)
         LEFT JOIN menu_disk_title_tools ON (menu_disk_title.menu_disk_title_id = menu_disk_title_tools.menu_disk_title_id)
         LEFT JOIN tools ON (menu_disk_title_tools.tools_id = tools.tools_id)
         LEFT JOIN menu_types_main ON (menu_disk_title.menu_types_main_id = menu_types_main.menu_types_main_id)
         WHERE menu_disk_title.menu_disk_id = '$menu_disk_id' AND menu_disk_title.menu_types_main_id = '3' ORDER BY tools.tools_name ASC";

    $drop = $mysqli->query("DROP TABLE IF EXISTS temp") or die('Error: ' . mysqli_error($mysqli));

    $temp_query = $mysqli->query("CREATE TEMPORARY TABLE temp ENGINE=MEMORY $sql_games") or die('Error: ' . mysqli_error($mysqli));
    $temp_query = $mysqli->query("INSERT INTO temp $sql_demos") or die('Error: ' . mysqli_error($mysqli));
    $temp_query = $mysqli->query("INSERT INTO temp $sql_tools") or die('Error: ' . mysqli_error($mysqli));

    $temp_query = $mysqli->query("SELECT * FROM temp GROUP BY menu_disk_title_id ORDER BY menu_disk_title_id ASC") or die('Error: ' . mysqli_error($mysqli));

    $drop = $mysqli->query("DROP TABLE IF EXISTS temp") or die('Error: ' . mysqli_error($mysqli));

    return $temp_query;
}

function menu_disk_doc_list($menu_disk_id) {
    global $mysqli;

    $sql_doc_games = "SELECT game.game_name AS 'software_name',
                              game.game_id AS 'software_id',
                              game_year.game_year AS 'year',
                              pub_dev.pub_dev_name AS 'developer_name',
                              pub_dev.pub_dev_id AS 'developer_id',
                              doc_disk_game.doc_id AS 'doc_id',
                              doc.doc_type_id,
                              menu_types_main.menu_types_text,
                              menu_disk_title_author.menu_disk_title_author_id,
                              menu_disk_title.menu_disk_title_id AS 'menu_disk_title_id'
                              FROM menu_disk_title
                              LEFT JOIN menu_disk_title_author ON (menu_disk_title_author.menu_disk_title_id = menu_disk_title.menu_disk_title_id)
                              LEFT JOIN menu_disk_title_doc_games ON (menu_disk_title.menu_disk_title_id = menu_disk_title_doc_games.menu_disk_title_id)
                              LEFT JOIN doc_disk_game ON (menu_disk_title_doc_games.doc_games_id = doc_disk_game.doc_disk_game_id)
                              LEFT JOIN doc ON (doc_disk_game.doc_id = doc.doc_id)
                              LEFT JOIN game ON (game.game_id = doc_disk_game.game_id)
                              LEFT JOIN game_developer ON (game.game_id = game_developer.game_id)
                              LEFT JOIN pub_dev ON (game_developer.dev_pub_id = pub_dev.pub_dev_id)
                              LEFT JOIN game_year ON (game.game_id = game_year.game_id)
                              LEFT JOIN menu_types_main ON (menu_disk_title.menu_types_main_id = menu_types_main.menu_types_main_id)
                              WHERE menu_disk_title.menu_disk_id = '$menu_disk_id' AND menu_disk_title.menu_types_main_id = '6' ORDER BY game.game_name ASC";

    $sql_doc_tools = "SELECT tools.tools_name AS 'software_name',
                              tools.tools_id AS 'software_id',
                              '0' AS year,
                              'n/a' AS developer_name,
                              '0' AS developer_id,
                              doc_disk_tool.doc_id AS 'doc_id',
                              doc.doc_type_id,
                              menu_types_main.menu_types_text,
                              menu_disk_title_author.menu_disk_title_author_id,
                              menu_disk_title.menu_disk_title_id AS 'menu_disk_title_id'
                              FROM menu_disk_title
                              LEFT JOIN menu_disk_title_author ON (menu_disk_title_author.menu_disk_title_id = menu_disk_title.menu_disk_title_id)
                              LEFT JOIN menu_disk_title_doc_tools ON (menu_disk_title.menu_disk_title_id = menu_disk_title_doc_tools.menu_disk_title_id)
                              LEFT JOIN doc_disk_tool ON (menu_disk_title_doc_tools.doc_tools_id = doc_disk_tool.doc_disk_tool_id)
                              LEFT JOIN doc ON (doc_disk_tool.doc_id = doc.doc_id)
                              LEFT JOIN tools ON (tools.tools_id = doc_disk_tool.tools_id)
                              LEFT JOIN menu_types_main ON (menu_disk_title.menu_types_main_id = menu_types_main.menu_types_main_id)
                              WHERE menu_disk_title.menu_disk_id = '$menu_disk_id' AND menu_disk_title.menu_types_main_id = '6' ORDER BY tools.tools_name ASC";

    $temp_query2 = $mysqli->query("CREATE TEMPORARY TABLE temp2 ENGINE=MEMORY $sql_doc_games") or die('Error1: ' . mysqli_error($mysqli));
    $temp_query2 = $mysqli->query("INSERT INTO temp2 $sql_doc_tools") or die('Error2: ' . mysqli_error($mysqli));

    $temp_query2 = $mysqli->query("SELECT * FROM temp2 GROUP BY menu_disk_title_id ORDER BY menu_disk_title_id ASC") or die('Error: ' . mysqli_error($mysqli));

    return $temp_query2;
}

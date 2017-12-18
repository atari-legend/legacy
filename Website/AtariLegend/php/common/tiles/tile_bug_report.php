<?php
/***************************************************************************
*                              tile_bug_report.php
*                            --------------------------
*   begin                : September 12, 2017
*   copyright            : (C) 2017 Atari Legend
*   email                : admin@atarilegend.com
*
*   Id: tile_bug_report.php,v 0.10 2017/09/12 ST Graveyard
*
***************************************************************************/

//*********************************************************************************************
// This is the php code for the 'bug report' tile
//*********************************************************************************************

//let's get all the types
$query_bug_report_type = $mysqli->query("SELECT * FROM bug_report_type") or die("query error, bug report");

while ($sql_bug_report_type = $query_bug_report_type->fetch_array(MYSQLI_BOTH)) {
    $smarty->append(
    
        'bug_report_type',
             array('bug_report_type_id' => $sql_bug_report_type['bug_report_type_id'],
                   'bug_report_type' => $sql_bug_report_type['bug_report_type'])
    
    );
}

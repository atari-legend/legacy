<?php
/***************************************************************************
*                               tile_stats.php
*                            -----------------------
*   begin                : Friday, april 15, 2017
*   copyright            : (C) 2017 Atari Legend
*   email                : martens_maarten@hotmail.com
*   actual update        : Creation of file
*
*   Id: tile_stats.phph,v 0.1 2017/04/15 00:46 ST Graveyard
*
***************************************************************************/

//*********************************************************************************************
// This is the php code for the stats tile
//*********************************************************************************************

//*******************************
// Get the user stats
//*******************************

$stack = statistics_stack();

// smack the stack into a smarty var and pray it works
foreach ($stack as $value) {
    $smarty->append('statistics', array(
        'value' => $value
    ));
}

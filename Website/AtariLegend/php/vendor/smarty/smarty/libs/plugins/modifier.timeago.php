<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty date modifier plugin
 * Purpose:  converts unix timestamps or datetime strings to words
 * Type:     modifier<br>
 * Name:     timeago<br>
 * @author   AtariLegend
 * @param string
 * @return string
 */
function smarty_modifier_timeago($timestamp) {
    $date = new \DateTime();
    $now = $date->format('U');
    $shortlog_date = "";

    if ($now-$timestamp <60) {
        $diff = $now-$timestamp;
        $shortlog_date .= " $diff seconds ago";
    }
    if ($now-$timestamp >60 and $now-$timestamp <3600) {
        $diff = $now-$timestamp;
        $diff = floor($diff / 60);
        $shortlog_date .= " $diff minutes ago";
    }
    if ($now-$timestamp >3600 and $now-$timestamp <86400) {
        $diff = $now-$timestamp;
        $diff = floor($diff / 3600);
        $shortlog_date .= " $diff hours ago";
    }
    if ($now-$timestamp >86400 and $now-$timestamp <172800) {
        $diff = $now-$timestamp;
        $diff = floor($diff / 3600);
        $shortlog_date .= " yesterday";
    }
    if ($now-$timestamp >172800) {
        $time = new \DateTime();
        $time->setTimestamp($timestamp);
        $change_date = $time->format('M d');
        $shortlog_date .= " on $change_date";
    }

    return $shortlog_date;
}

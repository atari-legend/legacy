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
    $message = "";

    if ($now-$timestamp <60) {
        $diff = $now-$timestamp;
        $message .= " $diff seconds ago";
    }
    if ($now-$timestamp >60 and $now-$timestamp <3600) {
        $diff = $now-$timestamp;
        $diff = floor($diff / 60);
        $message .= " $diff minutes ago";
    }
    if ($now-$timestamp >3600 and $now-$timestamp <86400) {
        $diff = $now-$timestamp;
        $diff = floor($diff / 3600);
        $message .= " $diff hours ago";
    }
    if ($now-$timestamp >86400 and $now-$timestamp <172800) {
        $diff = $now-$timestamp;
        $diff = floor($diff / 3600);
        $message .= " yesterday";
    }
    if ($now-$timestamp >172800) {
        $time = new \DateTime();
        $time->setTimestamp($timestamp);
        $change_date = $time->format('M d');
        $message .= " on $change_date";
    }

    return $message;
}

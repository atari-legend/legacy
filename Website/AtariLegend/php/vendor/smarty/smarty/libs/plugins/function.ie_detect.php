<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {ie_detect} function plugin
 *
 * Type:     function<br>
 * Name:     ie_detect<br>
 * Date:     2.10.2004<br>
 * Purpose:  Detect IE browser<br>
 * Input:<br>
 *
 * Example:    
 *  {ie_detect}
 *  {if $ie}
 *  <link rel="stylesheet" type="text/css" href="only-ie.css" />
 *  {else}
 *  <link rel="stylesheet" type="text/css" href="not-ie.css" />
 *  {/if}
 * @link http://smartbee.sourceforge.net/
 * @author   Martin Konicek <martin_konicek@centrum.cz>
 * @version  1.0
 * @param null
 * @param Smarty
 * @return boolen
 */
function smarty_function_ie_detect($params, &$smarty)
{
  $ie = strpos($_SERVER["HTTP_USER_AGENT"], 'MSIE') ? true : false;
  $ie = strpos($_SERVER["HTTP_USER_AGENT"], 'Opera') ? false : $ie;
  if($ie){
    $smarty->assign('ie', true);
  } else {
    $smarty->assign('ie', false);
  }
}

/* vim: set expandtab: */

?>

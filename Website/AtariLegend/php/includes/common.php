<?php
/*******************************************************************************
*                                common.php
*                            -----------------------
*   begin                : Tuesday, february 11, 2004
*   copyright            : (C) 2003 Atari Legend
*   email                : maarten.martens@freebel.net
*
*   Id: common.php,v 0.10 2015/08/20 00:02 ST Graveyard
*
********************************************************************************

*********************************************************************************
*In here we call all comon includes and variables ... We also check on sessions!
*********************************************************************************/

//D.Wetherilt
//20140915
// No longer valid
//import_request_variables('GPC'); 
// will replace with this for now:
extract($_REQUEST);

include("../../includes/connect.php"); 
include("../../includes/config_smarty.php");
include("../../includes/functions.php"); 
include("../../includes/user_functions.php");
include("../../includes/constants.php");
include("../../includes/config.php");
include("../../includes/karma.php");

//Check if the user is logged on to the site
sec_session_start();

//create skin switch links dynamically with called page
//using the filter command, this should be a safe way of using PHP_SELF
$variables = $_SERVER['QUERY_STRING'];

if (strpos($variables,'skin') !== false) {
    $variables = substr($variables, 7);
}

$variables = str_replace("action=modify_user", "", $variables);
$variables = str_replace("action=delete_user", "", $variables);
$variables = str_replace("action=reset_pwd", "", $variables);
$variables = str_replace("action=delete_avatar", "", $variables);

$php_self = filter_var($_SERVER['PHP_SELF'], FILTER_SANITIZE_STRING);
$php_self.= '?skin=0';
$php_self.= '&';
$php_self.= $variables;
$smarty->assign('skin_switch_0', $php_self );

$php_self = filter_var($_SERVER['PHP_SELF'], FILTER_SANITIZE_STRING);
$php_self.= '?skin=1';
$php_self.= '&';
$php_self.= $variables;
$smarty->assign('skin_switch_1', $php_self );

$php_self = filter_var($_SERVER['PHP_SELF'], FILTER_SANITIZE_STRING);
$php_self.= '?skin=2';	
$php_self.= '&';
$php_self.= $variables;
$smarty->assign('skin_switch_2', $php_self );


//Let's see if the user has choosen a skin
if (isset($skin))
{
	$_SESSION['skin'] = $skin;
}

if (isset($_SESSION['skin']))
{	
	if ($_SESSION['skin'] == '0')
	{
		$smarty->assign('css_file', '../../../templates/0/css/style.css');
		$smarty->assign('img_dir', '../../../templates/0/images/');
		
		foreach (glob("../../../templates/0/images/trivia/*.*") as $filename) {
			$filename = substr ($filename, 3);
			$smarty->append('image',
				array('image_name' => $filename ));
		}	
	}
	elseif ($_SESSION['skin'] == '1')
	{
		$smarty->assign('css_file', '../../../templates/1/css/style.css');
		$smarty->assign('img_dir', '../../../templates/1/images/');
		
		foreach (glob("../../../templates/1/images/trivia/*.*") as $filename) {
			$filename = substr ($filename, 3);
			$smarty->append('image',
				array('image_name' => $filename ));
		}
	}
	else
	{
		$smarty->assign('css_file', '../../../templates/2/css/style.css');
		$smarty->assign('img_dir', '../../../templates/2/images/');

		
		foreach (glob("../../../templates/2/images/trivia/*.*") as $filename) {
			$filename = substr ($filename, 3);
			$smarty->append('image',	
				array('image_name' => $filename ));
		}
			
	}
}
else
{
	$smarty->assign('css_file', '../../../templates/1/css/style.css');
	$smarty->assign('img_dir', '../../../templates/1/images/');
	
	foreach (glob("../../../templates/1/images/trivia/*.*") as $filename) {
		$filename = substr ($filename, 3);
		$smarty->append('image',
			array('image_name' => $filename ));
	}
}

if (login_check($mysqli) == true) {
	
	$smarty->assign('user_session',
	     array('userid' => $_SESSION['userid'],
		   'user_id' => $_SESSION['user_id'],
		   'permission' => $_SESSION['permission']));
}


if (SITESTATUS=="offline") {

		if ($_SESSION['permission']!=="1"){
			
			header("Location: ".SITEURL."blank.php");
			
			}
}
?>

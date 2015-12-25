<?php
/***************************************************************************
*                                skin_switcher.php
*                            --------------------------
*   copyright            : (C) 2015 Atari Legend
*   email                : silversurfer@atari-forum.com
*						   
*
***************************************************************************/

//Skin Switching functions

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
$variables = str_replace("&", "&amp;", $variables);

$php_self = filter_var($_SERVER['PHP_SELF'], FILTER_SANITIZE_STRING);
$php_self.= '?skin=0';
$php_self.= '&amp;';
$php_self.= $variables;
$smarty->assign('skin_switch_0', $php_self );

$php_self = filter_var($_SERVER['PHP_SELF'], FILTER_SANITIZE_STRING);
$php_self.= '?skin=1';
$php_self.= '&amp;';
$php_self.= $variables;
$smarty->assign('skin_switch_1', $php_self );

$php_self = filter_var($_SERVER['PHP_SELF'], FILTER_SANITIZE_STRING);
$php_self.= '?skin=2';	
$php_self.= '&amp;';
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

?>

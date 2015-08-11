<?php
/*******************************************************************************
*                                common.php
*                            -----------------------
*   begin                : Tuesday, february 11, 2004
*   copyright            : (C) 2003 Atari Legend
*   email                : maarten.martens@freebel.net
*
*   Id: common.php,v 0.10 2004/02/11 23:30 Gatekeeper
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

include("../includes/connect.php"); 
include("../includes/config_smarty.php");
include("../includes/functions.php"); 
include("../includes/user_functions.php");
include("../includes/constants.php");
include("../includes/config.php");

//Check if the user is logged on to the site
sec_session_start();

//Let's see if the user has choosen a skin
if (isset($skin))
{
	$_SESSION['skin'] = $skin;
}

if (isset($_SESSION['skin']))
{	
	if ($_SESSION['skin'] == '0')
	{
		$smarty->assign('css_file', '../templates/0/css/style.css');
		$smarty->assign('img_dir', '../templates/0/images/');
		
		foreach (glob("../templates/0/images/trivia/*.*") as $filename) {
			$smarty->append('image',
				array('image_name' => $filename ));
		}	
	}
	elseif ($_SESSION['skin'] == '1')
	{
		$smarty->assign('css_file', '../templates/1/css/style.css');
		$smarty->assign('img_dir', '../templates/1/images/');
		
		foreach (glob("../templates/1/images/trivia/*.*") as $filename) {
			$smarty->append('image',
				array('image_name' => $filename ));
		}
	}
	else
	{
		$smarty->assign('css_file', '../templates/2/css/style.css');
		$smarty->assign('img_dir', '../templates/2/images/');
		
		foreach (glob("../templates/2/images/trivia/*.*") as $filename) {
			$smarty->append('image',	
				array('image_name' => $filename ));
		}
			
	}
}
else
{
	$smarty->assign('css_file', '../templates/1/css/style.css');
	$smarty->assign('img_dir', '../templates/1/images/');
	
	foreach (glob("../templates/1/images/trivia/*.*") as $filename) {
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

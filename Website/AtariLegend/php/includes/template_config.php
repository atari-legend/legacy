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

//Set which template is going to be used
if (isset($_SESSION['skin']))
{		
		
		$set_skin = $_SESSION['skin'];
		
		$cpanel_template_folder = "../../../themes/templates/1/admin/";
		$mainsite_template_folder = "../../../themes/templates/1/main/";
		$smarty->assign("template_dir", "../../../themes/styles/$set_skin/");
		
		foreach (glob("../../../themes/styles/$set_skin/images/trivia/*.*") as $filename) {
			$filename = substr ($filename, 3);
			$smarty->append('image',
				array('image_name' => $filename ));
		}
}
else
{	
	$cpanel_template_folder = "../../../themes/templates/1/admin/";
	$mainsite_template_folder = "../../../themes/templates/1/main/";
	$smarty->assign('template_dir', '../../../themes/styles/1/');
	
	foreach (glob("../../../themes/styles/1/images/trivia/*.*") as $filename) {
		$filename = substr ($filename, 3);
		$smarty->append('image',
			array('image_name' => $filename ));
	}
}

?>

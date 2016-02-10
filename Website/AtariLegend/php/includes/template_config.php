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
		
		$smarty->assign("template_dir", "../../../templates/$set_skin/");
		
		foreach (glob("../../../templates/$set_skin/images/trivia/*.*") as $filename) {
			$filename = substr ($filename, 3);
			$smarty->append('image',
				array('image_name' => $filename ));
		}
}
else
{
	$smarty->assign('template_dir', '../../../templates/1/');
	
	foreach (glob("../../../templates/1/images/trivia/*.*") as $filename) {
		$filename = substr ($filename, 3);
		$smarty->append('image',
			array('image_name' => $filename ));
	}
}

?>

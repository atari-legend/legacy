<?php
    require '../libs/class.dropshadow.php'; 
	
	$ds = new dropShadow(false); 
    $ds->setShadowPath('../templates/shadows/'); 
    $ds->loadImage($_GET['img']); 
    $ds->resizeToSize($_GET['w'], 0); 

	//header('Content-type: image/jpeg'); // this is the new line 
    if ($_GET['shadow'] == 1) { 
        $colour = (isset($_GET['bgcolour'])) ? $_GET['bgcolour'] : 'FFFFFF'; 
        $ds->applyShadow($colour); 
        $ds->showShadow('png', 80); 
    } else { 
        $ds->showFinal('png', 80); 
    }    
?>

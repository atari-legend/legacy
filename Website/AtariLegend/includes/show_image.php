<?php
extract($_REQUEST);
//
//example: file=../data/images/game_screenshots/521.png&resize=420,null,null,null&crop=null,null,null,null
//WideImage_Image resize( [mixed $width = null], [mixed $height = null], [string $fit = 'inside'], [string $scale = 'any'])

//Parameters: resize
//mixed   $width   	The new width (smart coordinate), or null.
//mixed   $height   	The new height (smart coordinate), or null.
//string  $fit   	'inside', 'outside', 'fill'
//string  $scale   	'down', 'up', 'any'

//WideImage_Image crop( [mixed $left = 0], [mixed $top = 0], [mixed $width = '100%'], [mixed $height = '100%'])

//Parameters: crop
//mixed   	$left   	Left-coordinate of the crop rect, smart coordinate
//mixed   	$top   	Top-coordinate of the crop rect, smart coordinate
//mixed   	$width   	Width of the crop rect, smart coordinate
//mixed   	$height   	Height of the crop rect, smart coordinate


    include "../includes/wideimage/WideImage.php";
//The foreach loop, we may be able to implement the whole API this way
//The foreach loop solves the problem of getting the image manipulations in the desired order.
//Doc: http://wideimage.sourceforge.net/wp-content/current/doc/WideImage/WideImage_Image.html
foreach ( $_GET as $key => $value ) {


            	//set value for filepath
		if($key=="file") { 

			$file_path = $value; 
			
			$image = WideImage::load("$file_path");
		}

		//set value for resizing
		if($key=="resize") { 

			$resize_exp = explode(",",$value); 
			$resize_width=$resize_exp[0]; if($resize_width=="null") {$resize_width=NULL;}
			$resize_height=$resize_exp[1]; if($resize_height=="null") {$resize_height=NULL;}
			$resize_fit=$resize_exp[2]; if($resize_fit=="null") {$resize_fit=NULL;}
			$resize_scale=$resize_exp[3]; if($resize_scale=="null") {$resize_scale=NULL;}

			$image = $image->resize($resize_width,$resize_height,$resize_fit,$resize_scale);
			
		}
		
		//set value for croping
		if($key=="crop") { 

			$crop_exp = explode(",",$value); 
			$crop_left=$crop_exp[0]; if($crop_left=="null") {$crop_left=NULL;}
			$crop_top=$crop_exp[1]; if($crop_top=="null") {$crop_top=NULL;}
			$crop_width=$crop_exp[2]; if($crop_width=="null") {$crop_width=NULL;}
			$crop_height=$crop_exp[3]; if($crop_height=="null") {$crop_height=NULL;}
			
			if(isset($crop_left) AND is_null($crop_top)) {

			$image = $image->crop($crop_left,$crop_width);
			}

			if(isset($crop_top) AND is_null($crop_left)) {

			$image = $image->crop($crop_top,$crop_height);

			}

			if(isset($crop_top) AND isset($crop_left)) {

			$image = $image->crop($crop_left,$crop_top,$crop_width,$crop_height);
			}


		}

		//passing 2 values in minimum_size
		//this one is useful when the crop value i larger then the size of the image.
		if($key=="minimum_size") {
			
			$minimum_exp = explode(",",$value);
			$minimum_width = $minimum_exp[0];
			$minimum_height = $minimum_exp[1];

		}
            }

	// lets check if the image is atleast the size of the minimum values passed
	if(isset($minimum_width) or isset($minimum_height)) {

		$current_width = $image->getWidth();
		$current_height = $image->getHeight();

		//if height is smaller then minimum height resize
		if($current_height<$minimum_height) {

		$image = $image->resize($minimum_width,$minimum_height,'fill','up');

		}

  	}






$image->output('png');
?>

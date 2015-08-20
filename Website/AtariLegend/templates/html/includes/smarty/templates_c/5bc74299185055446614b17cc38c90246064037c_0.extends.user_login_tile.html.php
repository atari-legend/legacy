<?php /* Smarty version 3.1.27, created on 2015-08-20 00:00:34
         compiled from "C:\xampp\htdocs\Website\AtariLegend\templates\html\main\user_login_tile.html" */ ?>
<?php
/*%%SmartyHeaderCode:2801155d4fc82381ad3_65444666%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7ad4f9c9b3fcd6c661f5562824c11147fdc3cdda' => 
    array (
      0 => 'C:\\xampp\\htdocs\\Website\\AtariLegend\\templates\\html\\main\\user_login_tile.html',
      1 => 1439646672,
      2 => 'file',
    ),
    '0b434d1269af3ea2ee9c51a4fb9cf99276ac29a7' => 
    array (
      0 => 'C:\\xampp\\htdocs\\Website\\AtariLegend\\templates\\html\\main\\statistics_tile.html',
      1 => 1437082837,
      2 => 'file',
    ),
    'e7af6cf8d96735d558a8830271877bf5c366e6b6' => 
    array (
      0 => 'C:\\xampp\\htdocs\\Website\\AtariLegend\\templates\\html\\main\\did_you_know_tile.html',
      1 => 1429049022,
      2 => 'file',
    ),
    '82af6f34bf74a9e8fa94586a0c7dac5d2b4b09be' => 
    array (
      0 => 'C:\\xampp\\htdocs\\Website\\AtariLegend\\templates\\html\\main\\date_quote_tile.html',
      1 => 1436740659,
      2 => 'file',
    ),
    '513504490e099820d5a6c22bd657854a2facccf8' => 
    array (
      0 => 'C:\\xampp\\htdocs\\Website\\AtariLegend\\templates\\html\\main\\hotlinks_tile.html',
      1 => 1439590749,
      2 => 'file',
    ),
    'f2dd737f8b8522e0b58ff30b92668f630f44ce71' => 
    array (
      0 => 'C:\\xampp\\htdocs\\Website\\AtariLegend\\templates\\html\\main\\screenstar_tile.html',
      1 => 1439590695,
      2 => 'file',
    ),
    '0ce5ce749902da8ea269a5f92f7fd2dacdb856d2' => 
    array (
      0 => 'C:\\xampp\\htdocs\\Website\\AtariLegend\\templates\\html\\main\\who_is_it_tile.html',
      1 => 1439590715,
      2 => 'file',
    ),
    '8cb1b5889685f5e6e65a438dae5abcfdeb4ac07c' => 
    array (
      0 => 'C:\\xampp\\htdocs\\Website\\AtariLegend\\templates\\html\\main\\latest_reviews_tile.html',
      1 => 1439590726,
      2 => 'file',
    ),
    '341c666a58d025274ab59259e46c759ac4498371' => 
    array (
      0 => 'C:\\xampp\\htdocs\\Website\\AtariLegend\\templates\\html\\main\\latest_news_tile.html',
      1 => 1439590565,
      2 => 'file',
    ),
    '54ad2cb9c3c30f8ee6c2591a9b75c5adffe35a2a' => 
    array (
      0 => 'C:\\xampp\\htdocs\\Website\\AtariLegend\\templates\\html\\main\\frontpage.html',
      1 => 1439640118,
      2 => 'file',
    ),
    '7136aadf2a443439ae87c865b1e2d75eebbc5f7f' => 
    array (
      0 => 'C:\\xampp\\htdocs\\Website\\AtariLegend\\templates\\html\\main\\main.html',
      1 => 1440021631,
      2 => 'file',
    ),
    '83517ed6dd2ed6984733a17ad0334b689126147d' => 
    array (
      0 => '83517ed6dd2ed6984733a17ad0334b689126147d',
      1 => 0,
      2 => 'string',
    ),
  ),
  'nocache_hash' => '2801155d4fc82381ad3_65444666',
  'variables' => 
  array (
    'css_file' => 0,
    'img_dir' => 0,
    'skin_switch_1' => 0,
    'skin_switch_0' => 0,
    'skin_switch_2' => 0,
    'number' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_55d4fc824b25d8_82743898',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_55d4fc824b25d8_82743898')) {
function content_55d4fc824b25d8_82743898 ($_smarty_tpl) {
if (!is_callable('smarty_function_math')) require_once 'C:\\xampp\\htdocs\\Website\\AtariLegend\\templates\\html\\includes\\smarty\\libs\\plugins\\function.math.php';

$_smarty_tpl->properties['nocache_hash'] = '2801155d4fc82381ad3_65444666';
?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="description" content="Atari Legend : The number 1 Atari ST resource on the web">
		<meta name="keywords" content="atari, atari st, games, game, demo, demos, reviews, articles, interviews, st">
		<title> Atari Legend | Legends Never Die</title>
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
		<link href="<?php echo $_smarty_tpl->tpl_vars['css_file']->value;?>
" type="text/css" rel="stylesheet">
		<link type="text/css" href="../../../templates/html/includes/main_css/jquery-ui.css" rel="Stylesheet" />
		<?php echo '<script'; ?>
 type='text/javascript' src='../../../templates/html/includes/js/respond.min.js'><?php echo '</script'; ?>
> <!-- script needed for the side menu -->
		<?php echo '<script'; ?>
 type='text/JavaScript' src='../../../templates/html/includes/js/sha512.js'><?php echo '</script'; ?>
> <!-- log on security script -->
		<?php echo '<script'; ?>
 type='text/JavaScript' src='../../../templates/html/includes/js/md5.js'><?php echo '</script'; ?>
>  <!-- log on security script -->
        <?php echo '<script'; ?>
 type='text/JavaScript' src='../../../templates/html/includes/js/forms.js'><?php echo '</script'; ?>
> <!-- log on security script -->
		<?php echo '<script'; ?>
 type="text/javascript" src="../../../templates/html/includes/js/jquery-2.1.4.min.js"><?php echo '</script'; ?>
> <!-- main jquery stuff -->
		<?php echo '<script'; ?>
 type="text/javascript" src="../../../templates/html/includes/js/jquery-ui.min.js"><?php echo '</script'; ?>
> <!-- main jqueryUI stuff -->
		
	<?php echo '<script'; ?>
 type="text/javascript"> <!-- script needed for the autocompletion search engine -->
		$(document).ready(function()
		{
			$('#auto').autocomplete(
			{
				source: "../includes/autocomplete.php",
				minLength: 2
			});
		$(window).resize(function() {
    		$(".ui-autocomplete").css('display', 'none');
			});
		});
	<?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 type="text/javascript"> <!-- script needed for the side menu -->
			//<![CDATA[ 
			$(window).load(function(){
			  $("[data-toggle]").click(function() {
				var toggle_el = $(this).data("toggle");
				$(toggle_el).toggleClass("open-sidebar");
			  });
			});
			//]]> 
		<?php echo '</script'; ?>
>
	</head>
	<body id="body">
		<div id="wrapper">
			<header>
				<div id="top_background">
					<!-- This is the side menu only visible for smartphones (max resolution 480pc)-->				
					<div class="container" style="position: fixed;">
					  <div id="sidebar">
						  <ul>
							<li><a href="#" title="Games" class="top_button"><button type="button" class="topbutton" id="games_side">GAMES</button></a></li>
							<li><a href="#" title="Menus" class="top_button"><button type="button" class="topbutton" id="menus_side">MENUS</button></a></li>
							<li><a href="#" title="Demos" class="top_button"><button type="button" class="topbutton" id="demos_side">DEMOS</button></a></li>
							<li><a href="#" title="Links" class="top_button"><button type="button" class="topbutton" id="links_side">LINKS</button></a></li>
							<li><a href="#" title="About" class="top_button"><button type="button" class="topbutton" id="about_side">ABOUT</button></a></li>
						  </ul>
						  <ul id="search_ul">
							  <li id="searchbutton_side"><input id="search_text_side" type="text" name="search_text" maxlength="11" /></li>
							  <li><a href="#" title="search"><img id="search_side" src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
menu_search.png" alt="search" /></a></li>
						  </ul>
						  <div class="skin-wrap">
							<nav class="skin-menu">
							  <ul class="clearfix">
								<li>
									<button type="button" class="topbutton" id="skin_side">SKIN</button>
									<ul class="sub-menu">
										<li><a href="<?php echo $_smarty_tpl->tpl_vars['skin_switch_1']->value;?>
">LEGACY</a></li>
										<li><a href="<?php echo $_smarty_tpl->tpl_vars['skin_switch_0']->value;?>
">TOS 2.07</a></li>
										<li><a href="<?php echo $_smarty_tpl->tpl_vars['skin_switch_2']->value;?>
">PICASSO</a></li>
									</ul>
								</li>
							  </ul>
							</nav>
						  </div>
					  </div>
					  <div class="main-content">
							<button type="button" data-toggle=".container" id="sidebar-toggle" style="border:none; cursor: pointer;">
							  <span class="bar"></span>
							  <span class="bar"></span>
							  <span class="bar"></span>
							</button>
					  </div>
					</div>		
					<!-- end of side menu-->
					<div id="left">
						<img id="logo_img" src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
logos/top_logo0<?php echo smarty_function_math(array('equation'=>'rand(1,5)'),$_smarty_tpl);?>
.png" alt="logo" />
						<img id="logo_img_480" src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
logos/top_logo01_480.png" alt="logo_480" />
					</div>
					<div id="right">
						<img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
top_right0<?php echo smarty_function_math(array('equation'=>'rand(1,2)'),$_smarty_tpl);?>
.png" alt="bee" />
					</div>
					<?php $_smarty_tpl->tpl_vars['number'] = new Smarty_Variable(rand(1,5), null, 0);?>
					<?php if ((1 & $_smarty_tpl->tpl_vars['number']->value)) {?>
					<img id="animation" src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
animations/animation0<?php echo smarty_function_math(array('equation'=>'rand(1,5)'),$_smarty_tpl);?>
.gif" alt="animation" />
					<?php } else { ?>
					<img id="animation_vert" src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
animations/animation_vert0<?php echo smarty_function_math(array('equation'=>'rand(1,2)'),$_smarty_tpl);?>
.gif" alt="animation" />
					<?php }?>
				</div>			
				<nav id="main_nav">
					<ul id="main_nav_ul">
						<li><a href="#" title="Home"><img id="home" src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
menu_home.png" alt="home" /></a></li>
						<li><a href="#" title="Games" class="top_button"><button type="button" class="topbutton" id="games">GAMES</button></a></li>
						<li><a href="#" title="Menus" class="top_button"><button type="button" class="topbutton" id="menus">MENUS</button></a></li>
						<li><a href="#" title="Demos" class="top_button"><button type="button" class="topbutton" id="demos">DEMOS</button></a></li>
						<li><a href="#" title="Links" class="top_button"><button type="button" class="topbutton" id="links">LINKS</button></a></li>
						<li><a href="#" title="About" class="top_button"><button type="button" class="topbutton" id="about">ABOUT</button></a></li>
						<li><div class="searchbutton" id="search_text"><input type="text" id="auto" /></div></li>
						<li><a href="#" title="search"><img id="search" src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
menu_search.png" alt="search" /></a></li>
					</ul>
				</nav>	
			</header>	
			<?php
$_smarty_tpl->properties['nocache_hash'] = '2801155d4fc82381ad3_65444666';
?>

	
	<?php echo '<script'; ?>
 type="text/javascript" src="../../../templates/html/includes/js/jquery-ui.js"><?php echo '</script'; ?>
><!-- This script is needed for the animation of all the tiles - slide effect -->
    <?php echo '<script'; ?>
 type="text/javascript" src="../../../templates/html/includes/js/jssor.slider.mini.js"><?php echo '</script'; ?>
>  <!-- This script is needed for the animation in the welcome tile -->
	
	<?php echo '<script'; ?>
> <!-- This script is needed for the animation in the welcome tile -->
		    jQuery(document).ready(function ($) {

            var _SlideshowTransitions = [
            //Fade
            { $Duration: 3000, $Opacity: 2 }
            ];

            var options = {
                $AutoPlay: true,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $AutoPlaySteps: 1,                                  //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
                $AutoPlayInterval: 5000,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1,                               //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1

                $ArrowKeyNavigation: true,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                $SlideDuration: 500,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide , default value is 20
                //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                //$SlideHeight: 400,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                $SlideSpacing: 0, 					                //[Optional] Space between each slide in pixels, default value is 0
                $DisplayPieces: 1,                                  //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
                $ParkingPosition: 0,                                //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
                $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                $PlayOrientation: 1,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                $DragOrientation: 3,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

                $SlideshowOptions: {                                //[Optional] Options to specify and enable slideshow or not
                    $Class: $JssorSlideshowRunner$,                 //[Required] Class to create instance of slideshow
                    $Transitions: _SlideshowTransitions,            //[Required] An array of slideshow transitions to play slideshow
                    $TransitionsOrder: 1,                           //[Optional] The way to choose transition to play slide, 1 Sequence, 0 Random
                    $ShowLink: true                                    //[Optional] Whether to bring slide link on top of the slider when slideshow is running, default value is false
                },

                $BulletNavigatorOptions: {                                //[Optional] Options to specify and enable navigator or not
                    $Class: $JssorBulletNavigator$,                       //[Required] Class to create navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 1,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
                    $Lanes: 1,                                      //[Optional] Specify lanes to arrange items, default value is 1
                    $SpacingX: 10,                                   //[Optional] Horizontal space between each item in pixel, default value is 0
                    $SpacingY: 10,                                   //[Optional] Vertical space between each item in pixel, default value is 0
                    $Orientation: 1                                 //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
                },

                $ArrowNavigatorOptions: {
                    $Class: $JssorArrowNavigator$,              //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
                }
            };
			
			var jssor_slider1 = new $JssorSlider$("welcome", options);
					
			//responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {

                //reserve blank width for margin+padding: margin+padding-left (10) + margin+padding-right (10)
                var paddingWidth = -20;

                //minimum width should reserve for text
                var minReserveWidth = 300;

                var parentElement = jssor_slider1.$Elmt.parentNode;

                //evaluate parent container width
                var parentWidth = parentElement.clientWidth;

               if (parentWidth) {

                    //exclude blank width
                    var availableWidth = parentWidth - paddingWidth;

                    //calculate slider width as 70% of available width
                    var sliderWidth = availableWidth * 0.7;

                    //slider width is maximum 600
                    sliderWidth = Math.min(sliderWidth, 845);

                    //slider width is minimum 200
                    sliderWidth = Math.max(sliderWidth, 200);
                    var clearFix = "none";

                    //evaluate free width for text, if the width is less than minReserveWidth then fill parent container
                    if (availableWidth - sliderWidth < minReserveWidth) {

                        //set slider width to available width
                        sliderWidth = availableWidth;

                        //slider width is minimum 200
                        sliderWidth = Math.max(sliderWidth, 200);

                        clearFix = "both";
                    }

                    //clear fix for safari 3.1, chrome 3
                    $('#clearFixDiv').css('clear', clearFix);

                    jssor_slider1.$ScaleWidth(sliderWidth);
                }
                else
                    window.setTimeout(ScaleSlider, 30);
            }
            ScaleSlider();

            $(window).bind("load", ScaleSlider);
            $(window).bind("resize", ScaleSlider);
            $(window).bind("orientationchange", ScaleSlider);
            //responsive code end
 
        }); 
	<?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
><!-- This script is needed for the animation of all the tiles - slide effect -->
	  $(function() {

		// run the currently selected effect
		function runEffect() {
		
			if ($(window).width() < 640)  
			{
				$( "#latest_news" ).effect("slide", { direction: "right" }, 1000 );
				$( "#welcome" ).effect("slide", { direction: "left" }, 1000 );
				$( "#whoisit_position_front" ).effect("slide", { direction: "left" }, 1000 );
				$( "#logon" ).effect("slide", { direction: "left" }, 1000 );
				$( "#datequote_position_front" ).effect("slide", { direction: "left" }, 1000 );
				$( "#didyouknow_position_front" ).effect("slide", { direction: "right" }, 1000 );
				$( "#statistics_position_front" ).effect("slide", { direction: "left" }, 1000 );
				$( "#contact_tiles" ).effect("slide", { direction: "right" }, 1000 );
				$( "#screenstar_position_front" ).effect("slide", { direction: "right" }, 1000 );
				$( "#latest_reviews" ).effect("slide", { direction: "left" }, 1000 );
				$( "#hotlinks_position_front" ).effect("slide", { direction: "right" }, 1000 );		  
			}
			else if ($(window).width() > 639)
			{
				if ($(window).width() < 801)
				{
					$( "#latest_news" ).effect("slide", { direction: "left" }, 1000 );
					$( "#welcome" ).effect("slide", { direction: "left" }, 1000 );
					$( "#whoisit_position_front" ).effect("slide", { direction: "left" }, 1000 );
					$( "#logon" ).effect("slide", { direction: "right" }, 1000 );
					$( "#datequote_position_front" ).effect("slide", { direction: "left" }, 1000 );
					$( "#didyouknow_position_front" ).effect("slide", { direction: "right" }, 1000 );
					$( "#statistics_position_front" ).effect("slide", { direction: "right" }, 1000 );
					$( "#contact_tiles" ).effect("slide", { direction: "right" }, 1000 );
					$( "#screenstar_position_front" ).effect("slide", { direction: "right" }, 1000 );
					$( "#latest_reviews" ).effect("slide", { direction: "right" }, 1000 );
					$( "#hotlinks_position_front" ).effect("slide", { direction: "right" }, 1000 );
				}
				else 
				{
					$( "#latest_news" ).effect("slide", { direction: "left" }, 1000 );
					$( "#welcome" ).effect("slide", { direction: "left" }, 1000 );
					$( "#whoisit_position_front" ).effect("slide", { direction: "left" }, 1000 );
					$( "#logon" ).effect("slide", { direction: "right" }, 1000 );
					$( "#datequote_position_front" ).effect("slide", { direction: "right" }, 1000 );
					$( "#didyouknow_position_front" ).effect("slide", { direction: "right" }, 1000 );
					$( "#statistics_position_front" ).effect("slide", { direction: "right" }, 1000 );
					$( "#contact_tiles" ).effect("slide", { direction: "right" }, 1000 );
					$( "#screenstar_position_front" ).effect("slide", { direction: "down" }, 1000 );
					$( "#latest_reviews" ).effect("slide", { direction: "down" }, 1000 );
					$( "#hotlinks_position_front" ).effect("slide", { direction: "down" }, 1000 );
				}
			}	
		};

		// set effect from select menu value
		$(document).ready(function() {
		  runEffect();
		  return false;
		});
	  });
	 <?php echo '</script'; ?>
>

	<div id="main">
	
		<!--this column is only visible with 3 and 2 columns-->
		<div class="column-wide-left">	
			<!-- Jssor Slider Begin -->
			<!-- To move inline styles to css file/block, please specify a class name for each element. --> 
			<div id="welcome">
				<!-- Slides Container -->
				<div u="slides" class="welcome_slides">
					<?php
$_from = $_smarty_tpl->tpl_vars['image']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['line'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['line']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['line']->value) {
$_smarty_tpl->tpl_vars['line']->_loop = true;
$foreach_line_Sav = $_smarty_tpl->tpl_vars['line'];
?>
						<div><img class="standard_tile_image" u="image" src="../../includes/show_image.php?file=<?php echo $_smarty_tpl->tpl_vars['line']->value['image_name'];?>
">
							<p id="welcome_text">
								<span class="trivia_title"> <!--style='font-size:19pt; color:white;'--><?php echo $_smarty_tpl->tpl_vars['trivia_quote']->value;?>
</span>
								<span class="trivia_tag"> <!--style='font-size:13pt;'--><br>Your number 1 Atari ST resource on the net!</span>
								<span class="trivia_text" > <!--style='font-size:12pt; color:white' --><br><br>Atari Legend is a living and breathing webproject, designed by sceners. 
									We like to involve as many people as possible to make it fresh and up to date. We offer a nostalgic trip down the Atari ST memory lane, focussing on exciting game related content. 
									Details on all the classics, in-depth reviews, interviews with the creators of yesterday’s gems and much more.
								</span>
							</p>
						</div>
					<?php
$_smarty_tpl->tpl_vars['line'] = $foreach_line_Sav;
}
?>
				</div>
			</div>
			<!-- Jssor Slider End -->		
		</div>	
		
		<!--this column is only visible with 3 columns-->
		<div class="column-wide-right">		
			<!--Start logon tile - will only be used on the front page so no inheritance here -->
			
	
	<?php if (!isset($_smarty_tpl->tpl_vars['user_session']->value['userid'])) {?>
		<div class="standard_tile" id="logon">
		<form action="../tiles/user_process_login.php" method="post" name="login_form">
			<h1>LOG ON</h1>
			<div class="standard_tile_line"></div>
			<div class="logon_input_usn">
				<div class="logon_left">
					<img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
logon_usn.png" alt="username" />
				</div>
				<div class="logon_right">
					<input class="standard_tile_input" type="text" name="userid" maxlength="30" />
				</div>
			</div>
			<div class="logon_input_pwd">
				<div class="logon_left">
					<img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
logon_pwd.png" alt="password" />
				</div>
				<div class="logon_right">
					<input class="standard_tile_input" type="password" name="password" maxlength="30" id="password" />
				</div>
			</div> 
			<div class="logon_signin">
			<button type="button" value="Login" class="signinbutton" onclick="formhash(this.form, this.form.password);">
				SIGN IN
			</button>
			</div>
			<br>
			<br>			
			<h3><a href="#" class="standard_tile_link">Forgot user name or password?</a></h3>
			<br>
			<div class="logon_socmed">
				<img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
login-facebook.png" alt="Facebook" />
			</div>
			<div class="logon_socmed">
				<img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
login_twitter.png" alt="Twitter" />
			</div>
			<br>
			<br>
		</form>
		</div>
	<?php } else { ?>
		<div class="standard_tile" id="logon">
			<h1>Welcome <?php echo $_smarty_tpl->tpl_vars['user_session']->value['userid'];?>
</h1>
			<div class="standard_tile_line"></div>
			<div class="logon_input_usn">
				<div class="logon_left">
					<img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
logon_usn.png" alt="username" />
				</div>
				<div class="logon_right">
					<input class="standard_tile_input" type="text" name="userid" maxlength="30" />
				</div>
			</div>
			<div class="logon_input_pwd">
				<div class="logon_left">
					<img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
logon_pwd.png" alt="password" />
				</div>
				<div class="logon_right">
					<input class="standard_tile_input" type="password" name="password" maxlength="30" id="password" />
				</div>
			</div> 
			<div class="logon_signin">
			<button type="button" value="Login" class="signinbutton">
				<a href="../includes/user_logout.php" class="standard_tile_link_button">LOG OUT</a>
			</button>
			</div>
			<br>
			
			<?php if ($_smarty_tpl->tpl_vars['user_session']->value['permission'] == 1) {?>
			<h3><a href="../../admin/" class="standard_tile_link">Go to Cpanel</a></h3>
			<br>	
			<?php }?>
			<h3><a href="#" class="standard_tile_link">Forgot user name or password?</a></h3>
			<br>
			<br>
			<h3><span class="statistics_dark">Your last visit was on Saturday, September 6, 666. Stay Atari!</span></h3>
			<h3><span class="statistics_dark">Some more lines of text have been placed here temporary so the layout is not screwed up</span></h3>
			<br>
			<br>
		</div>
	<?php }?>

		</div>		
			
		<!--this column is only visible in the 3 colum mode and 1 column mode-->				
		<div class="column-left">		
			<!--Start latest news tile-->
			
<div class="standard_tile" id="latest_news">
	<h1><a href="#" class="standard_tile_link">LATEST NEWS</a></h1>

	<?php $_smarty_tpl->tpl_vars["number"] = new Smarty_Variable(1, null, 0);?>
	<?php
$_from = $_smarty_tpl->tpl_vars['news']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['line'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['line']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['line']->value) {
$_smarty_tpl->tpl_vars['line']->_loop = true;
$foreach_line_Sav = $_smarty_tpl->tpl_vars['line'];
?>
		
		<div class="standard_tile_line"></div>
		<div <?php if (!(1 & $_smarty_tpl->tpl_vars['number']->value)) {?>class="standard_list_entry"<?php } else { ?>class="standard_list_entry_odd"<?php }?>>
			<div class="standard_list_entry_left">
				<a href="#">
				<img id="latest_news_image" src="../../includes/show_image.php?file=<?php echo $_smarty_tpl->tpl_vars['line']->value['image'];?>
&amp;resize=164,null,null,null&amp;crop=left,top,164,120" alt="latest_news">
				</a>
			</div>
			<div class="standard_list_entry_right">
				<h4 style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis">
					<a href="#" title="<?php echo $_smarty_tpl->tpl_vars['line']->value['news_headline'];?>
" class="standard_tile_link"><?php echo $_smarty_tpl->tpl_vars['line']->value['news_headline'];?>
</a>
				</h4>
				<h5 style="font-weight: bold;"><?php echo $_smarty_tpl->tpl_vars['line']->value['news_date'];?>
</h5>
				<h5 class="standard_list_entry_right_news_text" style="overflow: hidden; text-overflow: ellipsis;">
						<?php echo $_smarty_tpl->tpl_vars['line']->value['news_text'];?>

				</h5>
			</div>							
		</div>
		<?php $_smarty_tpl->tpl_vars['number'] = new Smarty_Variable($_smarty_tpl->tpl_vars['number']->value+1, null, 0);?>
	<?php
$_smarty_tpl->tpl_vars['line'] = $foreach_line_Sav;
}
?>
	<div class="standard_tile_line"></div>
</div>

			<!--Start "Who is it" tile-->
			
	<div class="standard_tile" id="whoisit_position_front">		
		<h1><a href="#" class="standard_tile_link">WHO IS IT?</a></h1>
		<div class="standard_tile_line"></div>
		<div class="standard_tile_background">
			<a href="#" class="standard_tile_link">
			<img class="standard_tile_image" src="../../includes/show_image.php?file=<?php echo $_smarty_tpl->tpl_vars['who_is_it']->value['ind_img'];?>
&amp;resize=410,null,null,null&amp;crop=left,top,410,260" alt="Interview">
			</a>
			<p class="standard_tile_title"><a href="#" class="standard_tile_link"><?php echo $_smarty_tpl->tpl_vars['who_is_it']->value['ind_name'];?>
</a>
			<br><span class="standard_tile_subtext">Interview by <?php echo $_smarty_tpl->tpl_vars['who_is_it']->value['int_userid'];?>
</span></p>
		</div>
		<div class="standard_tile_explanation">
			<br>	
			<h6><?php echo $_smarty_tpl->tpl_vars['who_is_it']->value['int_text'];?>
</h6>
			<br>
			<h2><a href="#" class="standard_tile_link">Read more ></a></h2>
		</div>
	</div>	

		</div>
		
		<!--this column is only visible in the 3 colum mode and 1 column mode-->
		<div class="column-center">			
			<!--Start screenstar tile-->
			
	<div class="standard_tile" id="screenstar_position_front">		
		<h1><a href="#" class="standard_tile_link">SCREENSTAR</a></h1>
		<div class="standard_tile_line"></div>
		<div class="standard_tile_background">
			<a href="#" class="standard_tile_link"><img class="standard_tile_image" src="../../includes/show_image.php?file=<?php echo $_smarty_tpl->tpl_vars['screenstar']->value['screenstar_img'];?>
&amp;resize=410,null,null,null&amp;crop=left,top,410,260&amp;minimum_size=410,260" alt="screenstar"></a>
			<p class="standard_tile_title"><a href="#" class="standard_tile_link"><?php echo $_smarty_tpl->tpl_vars['screenstar']->value['screenstar_game_name'];?>
</a>
			<br><span class="standard_tile_subtext">Random comment</span></p>
		</div>
		<div class="standard_tile_explanation">
			<br>	
			<h6><?php echo $_smarty_tpl->tpl_vars['screenstar']->value['screenstar_comment'];?>
</h6>
			<br>
			<h2><a href="#" class="standard_tile_link">Read more ></a></h2>
		</div>
	</div>

			
			<!--Start latest reviews tile-->
			
<div class="standard_tile" id="latest_reviews">
	<h1><a href="#" class="standard_tile_link">LATEST REVIEWS</a></h1>
	<?php $_smarty_tpl->tpl_vars["number"] = new Smarty_Variable(1, null, 0);?>
	<?php
$_from = $_smarty_tpl->tpl_vars['recent_reviews']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['line'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['line']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['line']->value) {
$_smarty_tpl->tpl_vars['line']->_loop = true;
$foreach_line_Sav = $_smarty_tpl->tpl_vars['line'];
?>
		<div class="standard_tile_line"></div>	
		<div <?php if (!(1 & $_smarty_tpl->tpl_vars['number']->value)) {?>class="standard_list_entry"<?php } else { ?>class="standard_list_entry_odd"<?php }?>>
			<div class="standard_list_entry_left">
				<a href="#"><img src="../../includes/show_image.php?file=<?php echo $_smarty_tpl->tpl_vars['line']->value['review_img'];?>
&amp;resize=164,null,null,null&amp;crop=left,top,164,120" alt="latest_review"></a>
			</div>
			<div class="standard_list_entry_right">
				<h4 style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis">
				<a href="#" title="<?php echo $_smarty_tpl->tpl_vars['line']->value['review_name'];?>
" class="standard_tile_link"><?php echo $_smarty_tpl->tpl_vars['line']->value['review_name'];?>
</a>
				</h4>
				<h5><?php echo $_smarty_tpl->tpl_vars['line']->value['review_text'];?>
</h5>
			</div>							
		</div>
		<?php $_smarty_tpl->tpl_vars['number'] = new Smarty_Variable($_smarty_tpl->tpl_vars['number']->value+1, null, 0);?>
	<?php
$_smarty_tpl->tpl_vars['line'] = $foreach_line_Sav;
}
?>
	<div class="standard_tile_line"></div>
</div>

			
			<!--Start "hotlinks" tile-->
			
	<div class="standard_tile" id="hotlinks_position_front">		
		<h1><a href="#" class="standard_tile_link">HOT LINKS</a></h1>
		<div class="standard_tile_line"></div>
		<div class="standard_tile_background">
			<a href="<?php echo $_smarty_tpl->tpl_vars['hotlinks']->value['website_url'];?>
" class="standard_tile_link"><img class="standard_tile_image" src="../../includes/show_image.php?file=<?php echo $_smarty_tpl->tpl_vars['hotlinks']->value['website_img'];?>
&amp;resize=410,null,null,null&amp;crop=left,top,410,260&amp;minimum_size=410,260" alt="hot links"></a>
			<p class="standard_tile_title" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis">
			<a href="<?php echo $_smarty_tpl->tpl_vars['hotlinks']->value['website_url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['hotlinks']->value['website_name'];?>
" class="standard_tile_link"><?php echo $_smarty_tpl->tpl_vars['hotlinks']->value['website_name'];?>
</a>
			<br><span class="standard_tile_subtext">link added by <?php echo $_smarty_tpl->tpl_vars['hotlinks']->value['userid'];?>
</span></p>
		</div>
		<div class="standard_tile_explanation">
			<br>	
			<h6><?php echo $_smarty_tpl->tpl_vars['hotlinks']->value['website_text'];?>
</h6>
			<br>
			<h2><a href="#" class="standard_tile_link">Visit ></a></h2>
		</div>
	</div>	
					
		</div>
		
		<!--this column is only visible in the 3 colum mode and 1 column mode-->
		<div class="column-right">
								
			<!--Start date quote tile-->
			
	<div class="standard_tile" id="datequote_position_front">		
		<h1>WEDNESDAY</h1>
		<div class="standard_tile_line"></div>	
		<div id="datequote_bg">
			<h3 id="datequote_day">18</h3>
			<h3 id="datequote_month">January</h3>
			<h3	id="datequote_year">2015</h3>
			<p id="datequote_text">This day, 25 years ago, French company <a href="#" class="standard_tile_link_reverse">Delphine Software</a> 
			released there classic graphic adventure <a href="#" class="standard_tile_link_reverse">‘Future Wars - Time travellers’</a> 
			on the ST. Read our in-depth review <a href="#" class="standard_tile_link_reverse">here</a>.</p>
		</div>
	</div>	
		
			
			<!--Start "Did you know" tile-->
			
	<div class="standard_tile" id="didyouknow_position_front">		
		<h1>DID YOU KNOW?</h1>
		<div class="standard_tile_line"></div>
		<div class="standard_tile_text">
			<h6><?php echo $_smarty_tpl->tpl_vars['trivia_text']->value;?>
</h6>
		</div>
	</div>	
						
		
			<!--Start "statistics" tile-->
			
	<div class="standard_tile" id="statistics_position_front">		
		<h1>STATISTICS</h1>
		<div class="standard_tile_line"></div>
		<div class="standard_tile_text">
			<h6>
				<?php echo $_smarty_tpl->tpl_vars['statistics']->value['games_number'];?>
 games in the AL database <br>
				<span class="statistics_dark"><?php echo $_smarty_tpl->tpl_vars['statistics']->value['demos_number'];?>
 demos in the AL database</span> <br>
				<?php echo $_smarty_tpl->tpl_vars['statistics']->value['games_screenshot'];?>
 screenshots in the AL database <br> 
				<span class="statistics_dark"><?php echo $_smarty_tpl->tpl_vars['statistics']->value['games_screenshot_distinct'];?>
 games have screenshots</span> <br>
				<?php echo $_smarty_tpl->tpl_vars['statistics']->value['demos_screenshot_distinct'];?>
 demos have screenshots <br>
				<span class="statistics_dark"><?php echo $_smarty_tpl->tpl_vars['statistics']->value['game_publisher'];?>
 game publishers in the AL database</span> <br> 
				<?php echo $_smarty_tpl->tpl_vars['statistics']->value['game_developer'];?>
 game developers in the AL database <br> 
				<span class="statistics_dark"><?php echo $_smarty_tpl->tpl_vars['statistics']->value['game_year'];?>
 games have a release year</span> <br> 
				<?php echo $_smarty_tpl->tpl_vars['statistics']->value['games_boxscan'];?>
 gamebox scans in the AL database <br> 
				<span class="statistics_dark"><?php echo $_smarty_tpl->tpl_vars['statistics']->value['game_category'];?>
 games are signed to a category</span> <br> 
				<?php echo $_smarty_tpl->tpl_vars['statistics']->value['game_download'];?>
 games are downloadable <br>
			</h6>
		</div>
	</div>	

		
			<!--Start contact tiles - will only be used on the front page so no inheritance here -->
			<div class="standard_tile" id="contact_tiles">
				<a href="#"><img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
email.png" alt="email"></a>
				<a href="#"><img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
facebook.png" alt="facebook"></a>
				<a href="#"><img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
jukebox.png" alt="jukebox"></a>
				<a href="#"><img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
chat.png" alt="chat"></a>
			</div>	
		</div>
		
		<!--this column is only visible in the 2 colum mode -->
		<div class="column-left-tab">
		
			<!--Start date quote tile-->
			
	<div class="standard_tile" id="datequote_position_front">		
		<h1>WEDNESDAY</h1>
		<div class="standard_tile_line"></div>	
		<div id="datequote_bg">
			<h3 id="datequote_day">18</h3>
			<h3 id="datequote_month">January</h3>
			<h3	id="datequote_year">2015</h3>
			<p id="datequote_text">This day, 25 years ago, French company <a href="#" class="standard_tile_link_reverse">Delphine Software</a> 
			released there classic graphic adventure <a href="#" class="standard_tile_link_reverse">‘Future Wars - Time travellers’</a> 
			on the ST. Read our in-depth review <a href="#" class="standard_tile_link_reverse">here</a>.</p>
		</div>
	</div>	

			
			<!--Start "Did you know" tile-->
			
	<div class="standard_tile" id="didyouknow_position_front">		
		<h1>DID YOU KNOW?</h1>
		<div class="standard_tile_line"></div>
		<div class="standard_tile_text">
			<h6><?php echo $_smarty_tpl->tpl_vars['trivia_text']->value;?>
</h6>
		</div>
	</div>	


			<!--Start contact tiles-->
			<div class="standard_tile" id="contact_tiles">
				<a href="#"><img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
jukebox.png" alt="jukebox"></a>
				<a href="#"><img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
chat.png" alt="chat"></a>
			</div>	
		</div>
		
		<!--this column is only visible in the 2 colum mode -->
		<div class="column-right-tab">
			
			<!--Start "statistics" tile-->
			
	<div class="standard_tile" id="statistics_position_front">		
		<h1>STATISTICS</h1>
		<div class="standard_tile_line"></div>
		<div class="standard_tile_text">
			<h6>
				<?php echo $_smarty_tpl->tpl_vars['statistics']->value['games_number'];?>
 games in the AL database <br>
				<span class="statistics_dark"><?php echo $_smarty_tpl->tpl_vars['statistics']->value['demos_number'];?>
 demos in the AL database</span> <br>
				<?php echo $_smarty_tpl->tpl_vars['statistics']->value['games_screenshot'];?>
 screenshots in the AL database <br> 
				<span class="statistics_dark"><?php echo $_smarty_tpl->tpl_vars['statistics']->value['games_screenshot_distinct'];?>
 games have screenshots</span> <br>
				<?php echo $_smarty_tpl->tpl_vars['statistics']->value['demos_screenshot_distinct'];?>
 demos have screenshots <br>
				<span class="statistics_dark"><?php echo $_smarty_tpl->tpl_vars['statistics']->value['game_publisher'];?>
 game publishers in the AL database</span> <br> 
				<?php echo $_smarty_tpl->tpl_vars['statistics']->value['game_developer'];?>
 game developers in the AL database <br> 
				<span class="statistics_dark"><?php echo $_smarty_tpl->tpl_vars['statistics']->value['game_year'];?>
 games have a release year</span> <br> 
				<?php echo $_smarty_tpl->tpl_vars['statistics']->value['games_boxscan'];?>
 gamebox scans in the AL database <br> 
				<span class="statistics_dark"><?php echo $_smarty_tpl->tpl_vars['statistics']->value['game_category'];?>
 games are signed to a category</span> <br> 
				<?php echo $_smarty_tpl->tpl_vars['statistics']->value['game_download'];?>
 games are downloadable <br>
			</h6>
		</div>
	</div>	

			
			<!--Start contact tiles-->
			<div class="standard_tile" id="contact_tiles">
				<a href="#"><img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
email.png" alt="email"></a>
				<a href="#"><img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
facebook.png" alt="facebook"></a>
			</div>	
		</div>
	</div>		

			<footer class="footer">
				<div class="footer_logo">
					<br><br><br>
					<img id="footer_img" src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
footer_logo.png" alt="logo">
					<h3>&copy; copyright 2004 - <?php echo date('Y');?>
</h3>
				</div>
			</footer>
		</div>
	</body>
</html>
<?php }
}
?>
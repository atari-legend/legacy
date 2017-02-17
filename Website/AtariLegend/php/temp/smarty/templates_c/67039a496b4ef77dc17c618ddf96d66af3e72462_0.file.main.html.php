<?php
/* Smarty version 3.1.29, created on 2017-01-21 14:26:46
  from "/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/main/main.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_58836fa6d66a00_65681030',
  'file_dependency' => 
  array (
    '67039a496b4ef77dc17c618ddf96d66af3e72462' => 
    array (
      0 => '/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/main/main.html',
      1 => 1484337716,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58836fa6d66a00_65681030 ($_smarty_tpl) {
if (!is_callable('smarty_function_math')) require_once '/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/php/vendor/smarty/smarty/libs/plugins/function.math.php';
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, false);
?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="description" content="Atari Legend : The number 1 Atari ST resource on the web">
		<meta name="keywords" content="atari, atari st, games, game, demo, demos, reviews, articles, interviews, st">
		<title> Atari Legend | Legends Never Die</title>
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
		<!-- start - let the site behave like a mobile app on phone -->
		<meta name="mobile-web-app-capable" content="yes"><!-- Chrome-->
		<meta name="apple-mobile-web-app-capable" content="yes"><!-- apple -->
		<!-- End - let the site behave like a mobile app on phone -->
		<link type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['style_dir']->value;?>
css/style.css" type="text/css" rel="stylesheet" id="main_stylesheet">
		<link type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['style_dir']->value;?>
css/jquery-ui.css" rel="Stylesheet">
		<link rel="icon" href="<?php echo $_smarty_tpl->tpl_vars['template_dir']->value;?>
includes/icons/favicon.png"> <!-- fav icon -->
		<!-- start - get the icons used for mobile devices -->
		<link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo $_smarty_tpl->tpl_vars['template_dir']->value;?>
includes/icons/icon-57x57.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $_smarty_tpl->tpl_vars['template_dir']->value;?>
includes/icons/icon-72x72.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $_smarty_tpl->tpl_vars['template_dir']->value;?>
includes/icons/icon-114x114.png">
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $_smarty_tpl->tpl_vars['template_dir']->value;?>
includes/icons/icon-144x144.png">
		<!-- end - get the icons used for mobile devices -->
		<?php echo '<script'; ?>
 type='text/javascript' src="<?php echo $_smarty_tpl->tpl_vars['template_dir']->value;?>
includes/js/respond.min.js"><?php echo '</script'; ?>
> <!-- script needed for the side menu -->
		<?php echo '<script'; ?>
 type='text/JavaScript' src="<?php echo $_smarty_tpl->tpl_vars['template_dir']->value;?>
includes/js/sha512.js"><?php echo '</script'; ?>
> <!-- log on security script -->
		<?php echo '<script'; ?>
 type='text/JavaScript' src="<?php echo $_smarty_tpl->tpl_vars['template_dir']->value;?>
includes/js/md5.js"><?php echo '</script'; ?>
>  <!-- log on security script -->
        <?php echo '<script'; ?>
 type='text/JavaScript' src="<?php echo $_smarty_tpl->tpl_vars['template_dir']->value;?>
includes/js/forms.js"><?php echo '</script'; ?>
> <!-- log on security script -->
		<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['template_dir']->value;?>
includes/js/jquery-1.11.3.min.js"><?php echo '</script'; ?>
> <!-- main jquery stuff -->
		<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['template_dir']->value;?>
includes/js/jquery-ui.js"><?php echo '</script'; ?>
> <!-- main jqueryUI stuff -->
		<?php echo '<script'; ?>
 type="text/javascript"> <!-- script needed for the autocompletion search engine -->
			$(document).ready(function()
			{
				$('#auto').autocomplete(
				{
					source: "../../../php/includes/autocomplete.php",
					minLength: 2
				});
				
				$('#search_text_side').autocomplete(
				{
					source: "../../../php/includes/autocomplete.php",
					position: { my : "left top", at: "right top", of: $("#skin_side"), collision: "flipfit none" }
				});
			$(window).resize(function() {
				$(".ui-autocomplete").css('display', 'none');
				});
			});
			
			$(document).ready(function() { 
					$(".clearfix li a").click(function() { 
						
						var css_path = "../../../themes/styles/" + $(this).attr('rel') + "/css/style.css";
						var logo_img_path = "../../../themes/styles/" + $(this).attr('rel') + "/images/logos/top_logo01.png";
						var logo_img_480_path = "../../../themes/styles/" + $(this).attr('rel') + "/images/logos/top_logo01_480.png";
						var logo_bee_path = "../../../themes/styles/" + $(this).attr('rel') + "/images/top_right01.png";
						var skin = $(this).attr('rel');
						
						$("link#main_stylesheet").attr("href",css_path);
						$("#logo_img").attr("src",logo_img_path);
						$("#logo_img_480").attr("src",logo_img_480_path);
						$("#img_bee").attr("src",logo_bee_path);
						$.post( "../../../php/main/front/skin_switcher.php?action=skinswitch&skin="+skin);
						return false;
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
		<?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'javascript_slider', array (
  0 => 'block_15877484158836fa6d58d13_50253893',
  1 => false,
  3 => 0,
  2 => 0,
));
?>

	</head>
	<body id="body">
		<div id="wrapper_header">
			<header>
				<div id="top_background">
					<!-- This is the side menu only visible for smartphones (max resolution 480pc)-->				
					<div class="container">
					  <div id="sidebar">
						  <ul class="side_navigation">
							<li><a href="" class="sidebutton" id="games_side">GAMES</a></li>
							<li><a href="" class="sidebutton" id="menus_side">MENUS</a></li>
							<li><a href="" class="sidebutton" id="demos_side">DEMOS</a></li>
							<li><a href="" class="sidebutton" id="music_side">MUSIC</a></li>
							<li><a href="" class="sidebutton" id="magazines_side">MAGAZINES</a></li>
							<li><a href="" class="sidebutton" id="forum_main_side">FORUM</a></li>
							<li><a href="" class="sidebutton" id="links_side">LINKS</a></li>
							<li><a href="" class="sidebutton" id="about_side">ABOUT</a></li>
						  </ul>
						  <ul id="search_ul">
							  <li id="searchbutton_side"><input id="search_text_side" type="text" name="search_text" maxlength="11"></li>
							  <li><a href="#"><div id="search_side"> </div></a></li>
						  </ul>
						  <div class="skin-wrap">
							<nav class="skin-menu">
							  <ul class="clearfix">
								<li>
									<button class="sidebutton" id="skin_side">SKIN</button>
									<ul class="sub-menu">
										<li><a href="#" rel="1" class="sidebutton_cpanel">LEGACY</a></li>
										<li><a href="#" rel="2" class="sidebutton_cpanel">TOS 2.07</a></li>
										<li><a href="#" rel="3" class="sidebutton_cpanel">PICASSO</a></li>
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
						<img id="logo_img" src="<?php echo $_smarty_tpl->tpl_vars['style_dir']->value;?>
images/logos/top_logo0<?php echo smarty_function_math(array('equation'=>'rand(1,5)'),$_smarty_tpl);?>
.png" alt="logo" />
						<img id="logo_img_480" src="<?php echo $_smarty_tpl->tpl_vars['style_dir']->value;?>
images/logos/top_logo01_480.png" alt="logo_480" />
					</div>
					<div id="right">
						<img id="img_bee" src="<?php echo $_smarty_tpl->tpl_vars['style_dir']->value;?>
images/top_right0<?php echo smarty_function_math(array('equation'=>'rand(1,2)'),$_smarty_tpl);?>
.png" alt="bee" />
					</div>
					<?php $_smarty_tpl->tpl_vars['number'] = new Smarty_Variable(rand(1,5), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'number', 0);?>
					<?php if ((1 & $_smarty_tpl->tpl_vars['number']->value)) {?>
					<img id="animation" src="<?php echo $_smarty_tpl->tpl_vars['style_dir']->value;?>
images/animations/animation0<?php echo smarty_function_math(array('equation'=>'rand(1,5)'),$_smarty_tpl);?>
.gif" alt="animation" />
					<?php } else { ?>
					<img id="animation_vert" src="<?php echo $_smarty_tpl->tpl_vars['style_dir']->value;?>
images/animations/animation_vert0<?php echo smarty_function_math(array('equation'=>'rand(1,2)'),$_smarty_tpl);?>
.gif" alt="animation" />
					<?php }?>
				</div>			
				<nav id="main_nav">
					<ul id="main_nav_ul">
						<li><a href="" id="home"></a></li>
						<li><a href="" class="topbutton" id="games">GAMES</a></li>
						<li><a href="" class="topbutton" id="menus">MENUS</a></li>
						<li><a href="" class="topbutton" id="demos">DEMOS</a></li>
						<li><a href="" class="topbutton" id="music">MUSIC</a></li>
						<li><a href="" class="topbutton" id="magazines">MAGAZINES</a></li>
						<li><a href="" class="topbutton" id="forum_top">FORUM</a></li>
						<li><a href="" class="topbutton" id="links">LINKS</a></li>
						<li><a href="" class="topbutton" id="about">ABOUT</a></li>
						<li><div class="searchbutton" id="search_text"><input type="text" id="auto"></div></li>
						<li><div id="search"></div></li>
					</ul>
				</nav>	
			</header>
		</div>
		<div id="wrapper">
			<?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'main_body', array (
  0 => 'block_207664612958836fa6d64ed9_49721362',
  1 => false,
  3 => 0,
  2 => 0,
));
?>

		</div>
		<footer class="footer">
			<div class="footer_logo">
				<br><br><br>
				<div class="footer_logo_image"></div>
				<h3>&copy; copyright 2004 - <?php echo date('Y');?>
</h3>
			</div>
		</footer>
	</body>
</html>
<?php }
/* {block 'javascript_slider'}  file:1/main/main.html */
function block_15877484158836fa6d58d13_50253893($_smarty_tpl, $_blockParentStack) {
?>
 <?php
}
/* {/block 'javascript_slider'} */
/* {block 'main_body'}  file:1/main/main.html */
function block_207664612958836fa6d64ed9_49721362($_smarty_tpl, $_blockParentStack) {
}
/* {/block 'main_body'} */
}

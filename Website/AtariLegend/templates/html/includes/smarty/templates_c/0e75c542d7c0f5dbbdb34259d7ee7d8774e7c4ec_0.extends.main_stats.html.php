<?php /* Smarty version 3.1.27, created on 2015-08-21 00:33:14
         compiled from "C:\xampp\htdocs\Website\AtariLegend\templates\html\admin\main_stats.html" */ ?>
<?php
/*%%SmartyHeaderCode:366855d655aa4be406_16872128%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '86c0b6807488c41a39e2fdea227d8e75148f421b' => 
    array (
      0 => 'C:\\xampp\\htdocs\\Website\\AtariLegend\\templates\\html\\admin\\main_stats.html',
      1 => 1440109852,
      2 => 'file',
    ),
    '2d1d577f1bd985aab965abb5d43282c9b3378e69' => 
    array (
      0 => 'C:\\xampp\\htdocs\\Website\\AtariLegend\\templates\\html\\admin\\user_stats.html',
      1 => 1440109984,
      2 => 'file',
    ),
    '1d0d62300badfff69ca53a35b0f8e06696df033f' => 
    array (
      0 => 'C:\\xampp\\htdocs\\Website\\AtariLegend\\templates\\html\\admin\\main.html',
      1 => 1440107445,
      2 => 'file',
    ),
    'e3b0c742fe27abd9934dce05372dac5adb5cfa2b' => 
    array (
      0 => 'e3b0c742fe27abd9934dce05372dac5adb5cfa2b',
      1 => 0,
      2 => 'string',
    ),
    '4cbdeeca40b535a80c53fc7838a638b6cac1b5a7' => 
    array (
      0 => '4cbdeeca40b535a80c53fc7838a638b6cac1b5a7',
      1 => 0,
      2 => 'string',
    ),
  ),
  'nocache_hash' => '366855d655aa4be406_16872128',
  'variables' => 
  array (
    'css_file' => 0,
    'skin_switch_1' => 0,
    'skin_switch_0' => 0,
    'skin_switch_2' => 0,
    'img_dir' => 0,
    'number' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_55d655aa55a806_03078148',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_55d655aa55a806_03078148')) {
function content_55d655aa55a806_03078148 ($_smarty_tpl) {
if (!is_callable('smarty_function_math')) require_once 'C:\\xampp\\htdocs\\Website\\AtariLegend\\templates\\html\\includes\\smarty\\libs\\plugins\\function.math.php';

$_smarty_tpl->properties['nocache_hash'] = '366855d655aa4be406_16872128';
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
		<?php echo '<script'; ?>
 type="text/javascript" src="../../../templates/html/includes/js/jquery-2.1.4.min.js"><?php echo '</script'; ?>
> <!-- main jquery stuff -->
		<?php echo '<script'; ?>
 type="text/javascript"> <!-- script needed for the side menu -->
			//<![CDATA[ 
			$(window).load(function(){
			  $("[data-toggle]").click(function() {
				var toggle_el = $(this).data("toggle");
				$(toggle_el).toggleClass("open-sidebar_cpanel");
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
					<div class="container_cpanel" style="position: fixed;">
					   <div id="sidebar_cpanel">
						    <div class="skin-wrap_cpanel">
								<nav class="skin-menu_cpanel">
								  <ul class="clearfix_cpanel">
									<li><a href="#" title="Games" class="top_button"><button type="button" class="topbutton_cpanel" id="games_side">GAMES</button></a>
										<ul class="sub-menu_cpanel">
											<li><a href="#" title="Game editor" class="top_button"><button type="button" class="topbutton_cpanel" id="game_editor_side">GAME EDITOR</button></a></li>
											<li><a href="#" title="Game comments" class="top_button"><button type="button" class="topbutton_cpanel" id="game_comments_side">GAME COMMENTS</button></a></li>
											<li><a href="#" title="Game series" class="top_button"><button type="button" class="topbutton_cpanel" id="game_series_side">GAME SERIES</button></a></li>
											<li><a href="#" title="Game music" class="top_button"><button type="button" class="topbutton_cpanel" id="game_music_side">GAME MUSIC</button></a></li>
											<li><a href="#" title="Game submissions" class="top_button"><button type="button" class="topbutton_cpanel" id="game_submissions_side">GAME SUBMISSIONS</button></a></li>
											<li><a href="#" title="Game_reviews" class="top_button"><button type="button" class="topbutton_cpanel" id="game_reviews_side">REVIEWS</button></a></li>
											<li><a href="#" title="submitted_reviews" class="top_button"><button type="button" class="topbutton_cpanel" id="submitted_reviews_side">REVIEW SUBMISSIONS</button></a></li>
											<li><a href="#" title="Individuals" class="top_button"><button type="button" class="topbutton_cpanel" id="individuals_side">INDIVIDIUALS</button></a></li>
											<li><a href="#" title="Author types" class="top_button"><button type="button" class="topbutton_cpanel" id="author_types_side">AUTHOR TYPES</button></a></li>
											<li><a href="#" title="Companies" class="top_button"><button type="button" class="topbutton_cpanel" id="companies_side">COMPANIES</button></a></li>
											<li><a href="#" title="Company logo" class="top_button"><button type="button" class="topbutton_cpanel" id="company_logo_side">COMPANY LOGO</button></a></li>
											<li><a href="#" title="Interviews" class="top_button"><button type="button" class="topbutton_cpanel" id="interviews_side">INTERVIEWS</button></a></li>
											<li><a href="#" title="Interviews help" class="top_button"><button type="button" class="topbutton_cpanel" id="interviews_help_side">INTERVIEWS HELP</button></a></li>
										</ul>
									</li>
								  </ul>
								</nav>
						    </div>
							 <div class="skin-wrap_cpanel">
								<nav class="skin-menu_cpanel">
								  <ul class="clearfix_cpanel">
									<li><a href="#" title="Menus" class="top_button"><button type="button" class="topbutton_cpanel" id="menus_side">MENUS</button></a>
										<ul class="sub-menu_cpanel">
											<li><a href="#" title="Menu editor" class="top_button"><button type="button" class="topbutton_cpanel" id="menu_editor_side">MENU EDITOR</button></a></li>
											<li><a href="#" title="Menu comments" class="top_button"><button type="button" class="topbutton_cpanel" id="menu_comments_side">MENU COMMENTS</button></a></li>
											<li><a href="#" title="Menu submissions" class="top_button"><button type="button" class="topbutton_cpanel" id="menu_submissions_side">MENU SUBMISSIONS</button></a></li>
											<li><a href="#" title="Individuals" class="top_button"><button type="button" class="topbutton_cpanel" id="individuals_side">INDIVIDIUALS</button></a></li>
											<li><a href="#" title="Author types" class="top_button"><button type="button" class="topbutton_cpanel" id="author_types_side">AUTHOR TYPES</button></a></li>
											<li><a href="#" title="Crew editor" class="top_button"><button type="button" class="topbutton_cpanel" id="crew_editor_side">CREW EDITOR</button></a></li>
										</ul>
									</li>
								  </ul>
								</nav>
						    </div>
							 <div class="skin-wrap_cpanel">
								<nav class="skin-menu_cpanel">
								  <ul class="clearfix_cpanel">
									<li><a href="#" title="Demos" class="top_button"><button type="button" class="topbutton_cpanel" id="demos_side">DEMOS</button></a>
										<ul class="sub-menu_cpanel">
											<li><a href="#" title="Demo editor" class="top_button"><button type="button" class="topbutton_cpanel" id="demo_editor_side">DEMO EDITOR</button></a></li>
											<li><a href="#" title="Demo comments" class="top_button"><button type="button" class="topbutton_cpanel" id="demo_comments_side">DEMO COMMENTS</button></a></li>
											<li><a href="#" title="Demo music" class="top_button"><button type="button" class="topbutton_cpanel" id="demo_music_side">DEMO MUSIC</button></a></li>
											<li><a href="#" title="Demo submissions" class="top_button"><button type="button" class="topbutton_cpanel" id="demo_submissions_side">DEMO SUBMISSIONS</button></a></li>
											<li><a href="#" title="Individuals" class="top_button"><button type="button" class="topbutton_cpanel" id="individuals_side">INDIVIDIUALS</button></a></li>
											<li><a href="#" title="Author types" class="top_button"><button type="button" class="topbutton_cpanel" id="author_types_side">AUTHOR TYPES</button></a></li>
											<li><a href="#" title="Crew editor" class="top_button"><button type="button" class="topbutton_cpanel" id="crew_editor_side">CREW EDITOR</button></a></li>
											<li><a href="#" title="Interviews" class="top_button"><button type="button" class="topbutton_cpanel" id="interviews_side">INTERVIEWS</button></a></li>
											<li><a href="#" title="Interviews help" class="top_button"><button type="button" class="topbutton_cpanel" id="interviews_help_side">INTERVIEWS HELP</button></a></li>
										</ul>
									</li>
								  </ul>
								</nav>
						    </div>
							<div class="skin-wrap_cpanel">
								<nav class="skin-menu_cpanel">
								  <ul class="clearfix_cpanel">
									<li><a href="#" title="Users" class="top_button"><button type="button" class="topbutton_cpanel" id="users_side">USERS</button></a>
										<ul class="sub-menu_cpanel">
											<li><a href="#" title="User admin" class="top_button"><button type="button" class="topbutton_cpanel" id="user_admin_side">USER ADMIN</button></a></li>
										</ul>
									</li>
								  </ul>
								</nav>
						    </div>
							<div class="skin-wrap_cpanel">
								<nav class="skin-menu_cpanel">
								  <ul class="clearfix_cpanel">
									<li><a href="#" title="Admin" class="top_button"><button type="button" class="topbutton_cpanel" id="admin_side">NEWS</button></a>
										<ul class="sub-menu_cpanel">
											<li><a href="#" title="Add news" class="top_button"><button type="button" class="topbutton_cpanel" id="add_news_side">ADD NEWS</button></a></li>
											<li><a href="#" title="Approve news" class="top_button"><button type="button" class="topbutton_cpanel" id="approve_news_side">APPROVE NEWS</button></a></li>
											<li><a href="#" title="Submitted news" class="top_button"><button type="button" class="topbutton_cpanel" id="submitted_news_side">SUBMITTED NEWS</button></a></li>
										</ul>
									</li>
								  </ul>
								</nav>
						    </div>
							<div class="skin-wrap_cpanel">
								<nav class="skin-menu_cpanel">
								  <ul class="clearfix_cpanel">
									<li><a href="#" title="Other" class="top_button"><button type="button" class="topbutton_cpanel" id="other_side">OTHER</button></a>
										<ul class="sub-menu_cpanel">
											<li><a href="#" title="Statistics" class="top_button"><button type="button" class="topbutton_cpanel" id="Statistics_side">STATISTICS</button></a></li>
											<li><a href="#" title="Did you know" class="top_button"><button type="button" class="topbutton_cpanel" id="did_you_know_side">DID YOU KNOW</button></li>
											<li><a href="#" title="Trivia screenshots" class="top_button"><button type="button" class="topbutton_cpanel" id="trivia_screenshots_side">TRIVIA SCREENSHOTS</button></a></li>
											<li><a href="#" title="Trivie quotes" class="top_button"><button type="button" class="topbutton_cpanel" id="trivia_quotes_side">TRIVIA QUOTES</button></a></li>
											<li><a href="#" title="Add links" class="top_button"><button type="button" class="topbutton_cpanel" id="add_links_side">ADD LINKS</button></a></li>
											<li><a href="#" title="Validate links" class="top_button"><button type="button" class="topbutton_cpanel" id="validate_links_side">VALIDATE LINKS</button></a></li>
											<li><a href="#" title="Modify links" class="top_button"><button type="button" class="topbutton_cpanel" id="modify_links_side">MODIFY LINKS</button></a></li>
											<li><a href="#" title="Link categories" class="top_button"><button type="button" class="topbutton_cpanel" id="link_categories_side">LINK CATEGORIES</button></a></li>
											<li><a href="#" title="Articles" class="top_button"><button type="button" class="topbutton_cpanel" id="articles_side">ARTICLES</button></a></li>
											<li><a href="#" title="Article types" class="top_button"><button type="button" class="topbutton_cpanel" id="article_types_side">ARTICLE TYPES</button></a></li>
											<li><a href="#" title="Screenshots" class="top_button"><button type="button" class="topbutton_cpanel" id="screenshots_side">SCREENSHOTS</button></a></li>
											<li><a href="#" title="Add magazines" class="top_button"><button type="button" class="topbutton_cpanel" id="add_magazines_side">ADD MAGAZINES</button></a></li>
											<li><a href="#" title="Manage issues" class="top_button"><button type="button" class="topbutton_cpanel" id="manage_issues_side">MANAGE ISSUES</button></a></li>
											<li><a href="#" title="Forum" class="top_button"><button type="button" class="topbutton_cpanel" id="forum_side">FORUM</button></a></li>
											<li><a href="#" title="Log out" class="top_button"><button type="button" class="topbutton_cpanel" id="logout_side">LOG OUT</button></a></li>
										</ul>
									</li>
								  </ul>
								</nav>
						    </div>
							<div class="skin-wrap_cpanel">
								<nav class="skin-menu_cpanel">
								  <ul class="clearfix_cpanel">
									<li>	
										<button type="button" class="topbutton_cpanel" id="skin_side">SKIN</button>
										<ul class="sub-menu_cpanel">
											<li><a href="<?php echo $_smarty_tpl->tpl_vars['skin_switch_1']->value;?>
" class="top_button"><button type="button" class="topbutton_cpanel" id="legacy">LEGACY</button></a></li>
											<li><a href="<?php echo $_smarty_tpl->tpl_vars['skin_switch_0']->value;?>
" class="top_button"><button type="button" class="topbutton_cpanel" id="tos">TOS 2.07</button></a></li>
											<li><a href="<?php echo $_smarty_tpl->tpl_vars['skin_switch_2']->value;?>
" class="top_button"><button type="button" class="topbutton_cpanel" id="picasso">PICASSO</button></a></li>
										</ul>
									</li>
								  </ul>
								</nav>
							</div>
					   </div>
					   <div class="main-content">
						    <button type="button" href="#" data-toggle=".container_cpanel" id="sidebar_cpanel-toggle" style="border:none; cursor: pointer;">
								  <span class="bar"></span>
								  <span class="bar"></span>
								  <span class="bar"></span>
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
				<nav>
					<ul class="nav">
						<li><a href="#" title="Games" class="top_button"><button type="button" class="topbutton_cpanel" id="games">GAMES</button></a>
							<ul>
								<li><a href="#" title="Game editor" class="top_button"><button type="button" class="topbutton_cpanel" id="game_editor">GAME EDITOR</button></a></li>
								<li><a href="#" title="Game comments" class="top_button"><button type="button" class="topbutton_cpanel" id="game_comments">GAME COMMENTS</button></a></li>
								<li><a href="#" title="Game series" class="top_button"><button type="button" class="topbutton_cpanel" id="game_series">GAME SERIES</button></a></li>
								<li><a href="#" title="Game music" class="top_button"><button type="button" class="topbutton_cpanel" id="game_music">GAME MUSIC</button></a></li>
								<li><a href="#" title="Game submissions" class="top_button"><button type="button" class="topbutton_cpanel" id="game_submissions">GAME SUBMISSIONS</button></a></li>
								<li><a href="#" title="Game_reviews" class="top_button"><button type="button" class="topbutton_cpanel" id="game_reviews">REVIEWS</button></a></li>
								<li><a href="#" title="submitted_reviews" class="top_button"><button type="button" class="topbutton_cpanel" id="submitted_reviews">REVIEW SUBMISSIONS</button></a></li>
								<li><a href="#" title="Individuals" class="top_button"><button type="button" class="topbutton_cpanel" id="individuals">INDIVIDIUALS</button></a></li>
								<li><a href="#" title="Author types" class="top_button"><button type="button" class="topbutton_cpanel" id="author_types">AUTHOR TYPES</button></a></li>
								<li><a href="#" title="Companies" class="top_button"><button type="button" class="topbutton_cpanel" id="companies">COMPANIES</button></a></li>
								<li><a href="#" title="Company logo" class="top_button"><button type="button" class="topbutton_cpanel" id="company_logo">COMPANY LOGO</button></a></li>
								<li><a href="#" title="Interviews" class="top_button"><button type="button" class="topbutton_cpanel" id="interviews">INTERVIEWS</button></a></li>
								<li><a href="#" title="Interviews help" class="top_button"><button type="button" class="topbutton_cpanel" id="interviews_help">INTERVIEWS HELP</button></a></li>
								
							</ul>
						</li>
						<li><a href="#" title="Menus" class="top_button"><button type="button" class="topbutton_cpanel" id="menus">MENUS</button></a>
							<ul>
								<li><a href="#" title="Menu editor" class="top_button"><button type="button" class="topbutton_cpanel" id="menu_editor">MENU EDITOR</button></a></li>
								<li><a href="#" title="Menu comments" class="top_button"><button type="button" class="topbutton_cpanel" id="menu_comments">MENU COMMENTS</button></a></li>
								<li><a href="#" title="Menu submissions" class="top_button"><button type="button" class="topbutton_cpanel" id="menu_submissions">MENU SUBMISSIONS</button></a></li>
								<li><a href="#" title="Individuals" class="top_button"><button type="button" class="topbutton_cpanel" id="individuals">INDIVIDIUALS</button></a></li>
								<li><a href="#" title="Author types" class="top_button"><button type="button" class="topbutton_cpanel" id="author_types">AUTHOR TYPES</button></a></li>
								<li><a href="#" title="Crew editor" class="top_button"><button type="button" class="topbutton_cpanel" id="crew_editor">CREW EDITOR</button></a></li>
							</ul>
						</li>
						<li><a href="#" title="Demos" class="top_button"><button type="button" class="topbutton_cpanel" id="demos">DEMOS</button></a>
							<ul>
								<li><a href="#" title="Demo editor" class="top_button"><button type="button" class="topbutton_cpanel" id="demo_editor">DEMO EDITOR</button></a></li>
								<li><a href="#" title="Demo comments" class="top_button"><button type="button" class="topbutton_cpanel" id="demo_comments">DEMO COMMENTS</button></a></li>
								<li><a href="#" title="Demo music" class="top_button"><button type="button" class="topbutton_cpanel" id="demo_music">DEMO MUSIC</button></a></li>
								<li><a href="#" title="Demo submissions" class="top_button"><button type="button" class="topbutton_cpanel" id="demo_submissions">DEMO SUBMISSIONS</button></a></li>
								<li><a href="#" title="Individuals" class="top_button"><button type="button" class="topbutton_cpanel" id="individuals">INDIVIDIUALS</button></a></li>
								<li><a href="#" title="Author types" class="top_button"><button type="button" class="topbutton_cpanel" id="author_types">AUTHOR TYPES</button></a></li>
								<li><a href="#" title="Crew editor" class="top_button"><button type="button" class="topbutton_cpanel" id="crew_editor">CREW EDITOR</button></a></li>
								<li><a href="#" title="Interviews" class="top_button"><button type="button" class="topbutton_cpanel" id="interviews">INTERVIEWS</button></a></li>
								<li><a href="#" title="Interviews help" class="top_button"><button type="button" class="topbutton_cpanel" id="interviews_help">INTERVIEWS HELP</button></a></li>
							</ul>
						</li>
						<li><a href="#" title="Users" class="top_button"><button type="button" class="topbutton_cpanel" id="users">USERS</button></a>
							<ul>
								<li><a href="#" title="User admin" class="top_button"><button type="button" class="topbutton_cpanel" id="user_admin">USER ADMIN</button></a></li>
							</ul>
						</li>
						<li><a href="#" title="Admin" class="top_button"><button type="button" class="topbutton_cpanel" id="admin">NEWS</button></a>
							<ul>	
								<li><a href="#" title="Add news" class="top_button"><button type="button" class="topbutton_cpanel" id="add_news">ADD NEWS</button></a></li>
								<li><a href="#" title="Approve news" class="top_button"><button type="button" class="topbutton_cpanel" id="approve_news">APPROVE NEWS</button></a></li>
								<li><a href="#" title="Submitted news" class="top_button"><button type="button" class="topbutton_cpanel" id="submitted_news">SUBMITTED NEWS</button></a></li>
							</ul>
						</li>
						<li><a href="#" title="Other" class="top_button"><button type="button" class="topbutton_cpanel" id="other">OTHER</button></a>
							<ul>
								<li><a href="#" title="Statistics" class="top_button"><button type="button" class="topbutton_cpanel" id="Statistics">STATISTICS</button></a></li>
								<li><a href="#" title="Did you know" class="top_button"><button type="button" class="topbutton_cpanel" id="did_you_know">DID YOU KNOW</button></a></li>
								<li><a href="#" title="Trivia screenshots" class="top_button"><button type="button" class="topbutton_cpanel" id="trivia_screenshots">TRIVIA SCREENSHOTS</button></a></li>
								<li><a href="#" title="Trivie quotes" class="top_button"><button type="button" class="topbutton_cpanel" id="trivia_quotes">TRIVIA QUOTES</button></a></li>
								<li><a href="#" title="Add links" class="top_button"><button type="button" class="topbutton_cpanel" id="add_links">ADD LINKS</button></a></li>
								<li><a href="#" title="Validate links" class="top_button"><button type="button" class="topbutton_cpanel" id="validate_links">VALIDATE LINKS</button></a></li>
								<li><a href="#" title="Modify links" class="top_button"><button type="button" class="topbutton_cpanel" id="modify_links">MODIFY LINKS</button></a></li>
								<li><a href="#" title="Link categories" class="top_button"><button type="button" class="topbutton_cpanel" id="link_categories">LINK CATEGORIES</button></a></li>
								<li><a href="#" title="Articles" class="top_button"><button type="button" class="topbutton_cpanel" id="articles">ARTICLES</button></a></li>
								<li><a href="#" title="Article types" class="top_button"><button type="button" class="topbutton_cpanel" id="article_types">ARTICLE TYPES</button></a></li>
								<li><a href="#" title="Screenshots" class="top_button"><button type="button" class="topbutton_cpanel" id="screenshots">SCREENSHOTS</button></a></li>
								<li><a href="#" title="Add magazines" class="top_button"><button type="button" class="topbutton_cpanel" id="add_magazines">ADD MAGAZINES</button></a></li>
								<li><a href="#" title="Manage issues" class="top_button"><button type="button" class="topbutton_cpanel" id="manage_issues">MANAGE ISSUES</button></a></li>
								<li><a href="#" title="Forum" class="top_button"><button type="button" class="topbutton_cpanel" id="forum">FORUM</button></a></li>
								<li><a href="#" title="Log out" class="top_button"><button type="button" class="topbutton_cpanel" id="logout">LOG OUT</button></a></li>
							</ul>
						</li>
					</ul>
				</nav>	
			</header>	
			<div class="column-left-cpanel">		
				<?php
$_smarty_tpl->properties['nocache_hash'] = '366855d655aa4be406_16872128';
?>

<div class="standard_tile" id="user_stats">
	<h1>ADMIN STATS</h1>
		<div class="standard_tile_line"></div>
		<div class="standard_list_entry">
			<div class="standard_tile_text">
				<table width="100%">
				<tr>
					<td><img class="user_stats_img" src="../../includes/show_image.php?file=<?php echo $_smarty_tpl->tpl_vars['users']->value['image'];?>
&crop=164,null,null,null&crop=left,top,164,120" alt="avatar"></td>
				</tr>
				<tr>
					<td align="center"><h3>Welcome <?php echo $_smarty_tpl->tpl_vars['users']->value['user_name'];?>
</h3></td>
				</tr>
				<tr>
					<td align="center"><h3>Your <a href="../user/user_detail.php?user_id_selected=<?php echo $_smarty_tpl->tpl_vars['users']->value['user_id'];?>
" class="standard_tile_link_reverse">detail page</a></h3></td>
				</tr>
				</table>
				<br>
			</div>			
		</div>
	<div class="standard_tile_line"></div>
</div>

			</div>
			<div class="column-right-cpanel">
				<?php
$_smarty_tpl->properties['nocache_hash'] = '366855d655aa4be406_16872128';
?>
	
<div class="standard_tile" id="main_stats">
	<h1>MAIN STATS</h1>
	<div class="standard_tile_line"></div>
	<div class="standard_tile_text">
		<br>
		<table cellspacing="2" cellpadding="2" border="0" width="100%">
		<tr>
			<td width="50%" valign="top">
				<table class="standard_table_list">
				<tr>
					<th width="90%"><span style="color:black;"><h7>Some Stats</h7></span></th>
				</tr>
					<?php
$_from = $_smarty_tpl->tpl_vars['statistics']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['line'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['line']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['line']->value) {
$_smarty_tpl->tpl_vars['line']->_loop = true;
$foreach_line_Sav = $_smarty_tpl->tpl_vars['line'];
?>
				<tr>
					<td width="90%"><h3><?php if ($_smarty_tpl->tpl_vars['line']->value['value'] != '') {
echo $_smarty_tpl->tpl_vars['line']->value['value'];
}?></h3></td>
				</tr>
					<?php
$_smarty_tpl->tpl_vars['line'] = $foreach_line_Sav;
}
?>
				</table>	
			</td>
			<td width="25%" valign="top">
				<table class="standard_table_list">
				<tr>
					<th width="100%" colspan="2"><span style="color:green;"><h7>Good Karma</h7></span></th>
				</tr>
					<?php
$_from = $_smarty_tpl->tpl_vars['karma_good']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['line'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['line']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['line']->value) {
$_smarty_tpl->tpl_vars['line']->_loop = true;
$foreach_line_Sav = $_smarty_tpl->tpl_vars['line'];
?>
				<tr>
					<td width="75%"><a href="../user/user_detail.php?user_id_selected=<?php echo $_smarty_tpl->tpl_vars['line']->value['user_id'];?>
" class="MAINNAV"><h3><?php echo $_smarty_tpl->tpl_vars['line']->value['user_name'];?>
</h3></a></td>
					<td width="25%"><h3><?php echo $_smarty_tpl->tpl_vars['line']->value['karma'];?>
</h3></td>
				</tr>
					<?php
$_smarty_tpl->tpl_vars['line'] = $foreach_line_Sav;
}
?>
				</table>						
			</td>
			<td width="25%" valign="top">
				<table class="standard_table_list">
				<tr>
					<th width="100%" colspan="2"><span style="color:red;"><h7>Bad Voodoo</h7></span></th>
				</tr>
					<?php
$_from = $_smarty_tpl->tpl_vars['karma_bad']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['line'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['line']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['line']->value) {
$_smarty_tpl->tpl_vars['line']->_loop = true;
$foreach_line_Sav = $_smarty_tpl->tpl_vars['line'];
?>
				<tr>
					<td width="75%"><a href="../user/user_detail.php?user_id_selected=<?php echo $_smarty_tpl->tpl_vars['line']->value['user_id'];?>
" class="MAINNAV"><h3><?php echo $_smarty_tpl->tpl_vars['line']->value['user_name'];?>
</h3></a></td>
					<td width="25%"><h3><?php echo $_smarty_tpl->tpl_vars['line']->value['karma'];?>
</h3></td>
				</tr>
					<?php
$_smarty_tpl->tpl_vars['line'] = $foreach_line_Sav;
}
?>
				</table>	
			</td>
			</tr>
		</table>
		<br>
	</div>
</div>

			</div>
			<footer class="footer">
				<div class="footer_logo">
					<br><br><br>				
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
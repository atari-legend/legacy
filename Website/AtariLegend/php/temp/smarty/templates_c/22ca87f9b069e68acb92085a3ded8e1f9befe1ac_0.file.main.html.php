<?php
/* Smarty version 3.1.29, created on 2017-01-21 14:26:50
  from "/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/admin/main.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_58836faaef8467_79289613',
  'file_dependency' => 
  array (
    '22ca87f9b069e68acb92085a3ded8e1f9befe1ac' => 
    array (
      0 => '/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/admin/main.html',
      1 => 1484337716,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58836faaef8467_79289613 ($_smarty_tpl) {
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
css/style.css" rel="stylesheet" id="main_stylesheet">
        <link type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['style_dir']->value;?>
css/jquery-ui.css" rel="Stylesheet">
        <link type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['style_dir']->value;?>
css/jquery.fancybox.css" rel="Stylesheet">
        <link type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['style_dir']->value;?>
css/notify-osd.css" hreflang="en" rel="stylesheet">
        <!-- start - get the icons used for mobile devices -->
        <link rel="icon" href="<?php echo $_smarty_tpl->tpl_vars['template_dir']->value;?>
includes/icons/favicon.png"> <!-- fav icon & Chrome mobile icon-->
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
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['template_dir']->value;?>
includes/js/jquery-2.1.4.min.js"><?php echo '</script'; ?>
> <!-- main jquery stuff -->
        <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['template_dir']->value;?>
includes/js/jquery-ui.js"><?php echo '</script'; ?>
> <!-- main jqueryUI stuff -->
        <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['template_dir']->value;?>
includes/js/jquery.fancybox.pack.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['template_dir']->value;?>
includes/js/notify-osd.js"><?php echo '</script'; ?>
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


            <?php if (isset($_smarty_tpl->tpl_vars['edit_message']->value)) {?>
                $( document ).ready(function() {
                    $.notify_osd.create({
                        'text'        : '<?php echo $_smarty_tpl->tpl_vars['edit_message']->value;?>
',             // notification message
                        'icon'        : '<?php echo $_smarty_tpl->tpl_vars['style_dir']->value;?>
/images/osd_icons/star.png', // icon path, 48x48
                        'sticky'      : false,             // if true, timeout is ignored
                        'timeout'     : 4,                 // disappears after 6 seconds
                        'dismissable' : true               // can be dismissed manually
                        });
                });
            <?php }?>
        <?php echo '</script'; ?>
>
        <?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'java_script', array (
  0 => 'block_155611752758836faaeebe03_19832311',
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
                            <div class="skin-wrap" id="no-wrap">
                                <nav class="skin-menu">
                                  <ul class="side_navigation">
                                    <li><button class="sidebutton" id="games_side">GAMES</button>
                                        <ul class="sub-menu">
                                            <li><a href="../games/games_main.php" title="Game editor" class="sidebutton_cpanel">GAME EDITOR</a></li>
                                            <li><a href="../games/games_comment.php" title="Game comments" class="sidebutton_cpanel">GAME COMMENTS</a></li>
                                            <li><a href="../games/games_series_main.php" title="Game series" class="sidebutton_cpanel">GAME SERIES</a></li>
                                            <li><a href="../games/games_music.php" title="Game music" class="sidebutton_cpanel">GAME MUSIC</a></li>
                                            <li><a href="../games/submission_games.php" title="Game submissions" class="sidebutton_cpanel">GAME SUBMISSIONS</a></li>
                                            <li><a href="../games/games_review.php" title="Game_reviews" class="sidebutton_cpanel">REVIEWS</a></li>
                                            <li><a href="../games/games_review_submitted.php" title="submitted_reviews" class="sidebutton_cpanel">REVIEW SUBMISSIONS</a></li>
                                            <li><a href="../individuals/individuals_main.php" title="Individuals" class="sidebutton_cpanel">INDIVIDIUALS</a></li>
                                            <li><a href="../individuals/individuals_author.php" title="Author types" class="sidebutton_cpanel">AUTHOR TYPES</a></li>
                                            <li><a href="../company/company_main.php" title="Companies" class="sidebutton_cpanel">COMPANIES</a></li>
                                            <li><a href="../company/company_logos.php" title="Company logo" class="sidebutton_cpanel">COMPANY LOGO</a></li>
                                            <li><a href="../interviews/interviews_main.php" title="Interviews" class="sidebutton_cpanel">INTERVIEWS</a></li>
                                            <li><a href="../interviews/interviews_help.php" title="Interviews help" class="sidebutton_cpanel">INTERVIEWS HELP</a></li>
                                        </ul>
                                    </li>
                                  </ul>
                                </nav>
                            </div>
                             <div class="skin-wrap" id="no-wrap">
                                <nav class="skin-menu">
                                  <ul class="side_navigation">
                                    <li><button class="sidebutton" id="menus_side">MENUS</button>
                                        <ul class="sub-menu">
                                            <li><a href="../menus/menus_list.php" title="Menu editor" class="sidebutton_cpanel">MENU EDITOR</a></li>
                                            <li><a href="../menus/menus_type.php" title="Menu type" class="sidebutton_cpanel">MENU TYPE</a></li>
                                            <li><a href="../docs/doc_type.php" title="Doc type" class="sidebutton_cpanel">DOC TYPE</a></li>
                                            <li><a href="../docs/doc_category.php" title="Doc category" class="sidebutton_cpanel">DOC CATEGORY</a></li>
                                            <li><a href="../administration/construction.php" title="Menu comments" class="sidebutton_cpanel">MENU COMMENTS</a></li>
                                            <li><a href="../administration/construction.php" title="Menu submissions" class="sidebutton_cpanel">MENU SUBMISSIONS</a></li>
                                            <li><a href="../individuals/individuals_main.php" title="Individuals" class="sidebutton_cpanel">INDIVIDIUALS</a></li>
                                            <li><a href="../individuals/individuals_author.php" title="Author types" class="sidebutton_cpanel">AUTHOR TYPES</a></li>
                                            <li><a href="../crew/crew_main.php" title="Crew editor" class="sidebutton_cpanel">CREW EDITOR</a></li>
                                        </ul>
                                    </li>
                                  </ul>
                                </nav>
                            </div>
                            <div class="skin-wrap" id="no-wrap">
                                <nav class="skin-menu">
                                  <ul class="side_navigation">
                                    <li><button class="sidebutton" id="demos_side">DEMOS</button>
                                        <ul class="sub-menu">
                                            <li><a href="../administration/construction.php" title="Demo editor" class="sidebutton_cpanel">DEMO EDITOR</a></li>
                                            <li><a href="../administration/construction.php" title="Demo comments" class="sidebutton_cpanel">DEMO COMMENTS</a></li>
                                            <li><a href="../administration/construction.php" title="Demo music" class="sidebutton_cpanel">DEMO MUSIC</a></li>
                                            <li><a href="../administration/construction.php" title="Demo submissions" class="sidebutton_cpanel">DEMO SUBMISSIONS</a></li>
                                            <li><a href="../administration/construction.php" title="Individuals" class="sidebutton_cpanel">INDIVIDIUALS</a></li>
                                            <li><a href="../administration/construction.php" title="Author types" class="sidebutton_cpanel">AUTHOR TYPES</a></li>
                                            <li><a href="../administration/construction.php" title="Crew editor" class="sidebutton_cpanel">CREW EDITOR</a></li>
                                            <li><a href="../administration/construction.php" title="Interviews" class="sidebutton_cpanel">INTERVIEWS</a></li>
                                            <li><a href="../administration/construction.php" title="Interviews help" class="sidebutton_cpanel">INTERVIEWS HELP</a></li>
                                        </ul>
                                    </li>
                                  </ul>
                                </nav>
                            </div>
                            <div class="skin-wrap" id="no-wrap">
                                <nav class="skin-menu">
                                  <ul class="side_navigation">
                                    <li><button class="sidebutton" id="users_side">USERS</button>
                                        <ul class="sub-menu">
                                            <li><a href="../administration/user_management.php" class="sidebutton_cpanel">USER MANAGEMENT</a></li>
                                            <li><a href="../user/user_main.php" class="sidebutton_cpanel">USER SEARCH</a></li>
                                        </ul>
                                    </li>
                                  </ul>
                                </nav>
                            </div>
                            <div class="skin-wrap" id="no-wrap">
                                <nav class="skin-menu">
                                  <ul class="side_navigation">
                                    <li><button class="sidebutton" id="admin_side">NEWS</button>
                                        <ul class="sub-menu">
                                            <li><a href="../news/news_add.php" title="Add news" class="sidebutton_cpanel">ADD NEWS</a></li>
                                            <li><a href="../news/news_approve.php" title="Approve news" class="sidebutton_cpanel">APPROVE NEWS</a></li>
                                            <li><a href="../news/news_edit_all.php" title="Edit news" class="sidebutton_cpanel">EDIT NEWS</a></li>
                                            <li><a href="../news_add_images.php" title="Add news image" class="sidebutton_cpanel">ADD NEWS IMAGE</a></li>
                                        </ul>
                                    </li>
                                  </ul>
                                </nav>
                            </div>
                            <div class="skin-wrap" id="no-wrap">
                                <nav class="skin-menu">
                                  <ul class="side_navigation">
                                    <li><button class="sidebutton" id="other_side">OTHER</button>
                                        <ul class="sub-menu">
                                            <li><a href="../index.php" title="Statistics" class="sidebutton_cpanel">STATISTICS</a></li>
                                            <li><a href="../administration/database_update.php" title="Administration" class="sidebutton_cpanel">DB UPDATES</a></li>
                                            <li><a href="../administration/change_log.php" title="Change log" class="sidebutton_cpanel">CHANGE LOG</a></li>
                                            <li><a href="../trivia/did_you_know.php" title="Did you know" class="sidebutton_cpanel">DID YOU KNOW</a></li>
                                            <li><a href="../trivia/manage_trivia_quotes.php" title="Trivia quotes" class="sidebutton_cpanel">TRIVIA QUOTES</a></li>
                                            <li><a href="../links/link_addnew.php" title="Add links" class="sidebutton_cpanel">ADD LINKS</a></li>
                                            <li><a href="../links/link_modlist.php" title="Modify links" class="sidebutton_cpanel">MODIFY LINKS</a></li>
                                            <li><a href="../links/link_cat.php" title="Link categories" class="sidebutton_cpanel">LINK CATEGORIES</a></li>
                                            <li><a href="../articles/articles_main.php" title="Articles" class="sidebutton_cpanel">ARTICLES</a></li>
                                            <li><a href="../articles/article_type.php" title="Article types" class="sidebutton_cpanel">ARTICLE TYPES</a></li>
                                            <li><a href="../administration/construction.php" title="Add magazines" class="sidebutton_cpanel">ADD MAGAZINES</a></li>
                                            <li><a href="../administration/construction.php" title="Manage issues" class="sidebutton_cpanel">MANAGE ISSUES</a></li>
                                            <li><a href="http://www.atari-forum.com" title="Forum" class="sidebutton_cpanel">FORUM</a></li>
                                            <li><a href="../administration/construction.php" title="Log out" class="sidebutton_cpanel">LOG OUT</a></li>
                                        </ul>
                                    </li>
                                  </ul>
                                </nav>
                            </div>
                            <div class="skin-wrap" id="no-wrap">
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
                        <li><button type="button" class="topbutton" id="games">GAMES</button>
                            <ul>
                                <li><a href="../games/games_main.php" title="Game editor" class="subbutton">GAME EDITOR</a></li>
                                <li><a href="../games/games_comment.php" title="Game comments" class="subbutton">GAME COMMENTS</a></li>
                                <li><a href="../games/games_series_main.php" title="Game series" class="subbutton">GAME SERIES</a></li>
                                <li><a href="../games/games_music.php" title="Game music" class="subbutton">GAME MUSIC</a></li>
                                <li><a href="../games/submission_games.php" title="Game submissions" class="subbutton">GAME SUBMISSIONS</a></li>
                                <li><a href="../games/games_review.php" title="Game_reviews" class="subbutton">REVIEWS</a></li>
                                <li><a href="../games/games_review_submitted.php" title="submitted_reviews" class="subbutton">REVIEW SUBMISSIONS</a></li>
                                <li><a href="../individuals/individuals_main.php" title="Individuals" class="subbutton">INDIVIDIUALS</a></li>
                                <li><a href="../individuals/individuals_author.php" title="Author types" class="subbutton">AUTHOR TYPES</a></li>
                                <li><a href="../company/company_main.php" title="Companies" class="subbutton">COMPANIES</a></li>
                                <li><a href="../company/company_logos.php" title="Company logo" class="subbutton">COMPANY LOGO</a></li>
                                <li><a href="../interviews/interviews_main.php" title="Interviews" class="subbutton">INTERVIEWS</a></li>
                                <li><a href="../interviews/interviews_help.php" title="Interviews help" class="subbutton">INTERVIEWS HELP</a></li>
                            </ul>
                        </li>
                        <li><button type="button" class="topbutton" id="menus">MENUS</button>
                            <ul>
                                <li><a href="../menus/menus_list.php" title="Menu editor" class="subbutton">MENU EDITOR</a></li>
                                <li><a href="../menus/menus_type.php" title="Menu type" class="subbutton">MENU TYPE</a></li>
                                <li><a href="../docs/doc_type.php" title="doc type" class="subbutton">DOC TYPE</a></li>
                                <li><a href="../docs/doc_category.php" title="doc category" class="subbutton">DOC CATEGORY</a></li>
                                <li><a href="../administration/construction.php" title="Menu comments" class="subbutton">MENU COMMENTS</a></li>
                                <li><a href="../administration/construction.php" title="Menu submissions" class="subbutton">MENU SUBMISSIONS</a></li>
                                <li><a href="../individuals/individuals_main.php" title="Individuals" class="subbutton">INDIVIDIUALS</a></li>
                                <li><a href="../individuals/individuals_author.php" title="Author types" class="subbutton">AUTHOR TYPES</a></li>
                                <li><a href="../crew/crew_main.php" title="Crew editor" class="subbutton">CREW EDITOR</a></li>
                            </ul>
                        </li>
                        <li><button type="button" class="topbutton" id="demos">DEMOS</button>
                            <ul>
                                <li><a href="../administration/construction.php" title="Demo editor" class="subbutton">DEMO EDITOR</a></li>
                                <li><a href="../administration/construction.php" title="Demo comments" class="subbutton">DEMO COMMENTS</a></li>
                                <li><a href="../administration/construction.php" title="Demo music" class="subbutton">DEMO MUSIC</a></li>
                                <li><a href="../administration/construction.php" title="Demo submissions" class="subbutton">DEMO SUBMISSIONS</a></li>
                                <li><a href="../administration/construction.php" title="Individuals" class="subbutton">INDIVIDIUALS</a></li>
                                <li><a href="../administration/construction.php" title="Author types" class="subbutton">AUTHOR TYPES</a></li>
                                <li><a href="../administration/construction.php" title="Crew editor" class="subbutton">CREW EDITOR</a></li>
                                <li><a href="../administration/construction.php" title="Interviews" class="subbutton">INTERVIEWS</a></li>
                                <li><a href="../administration/construction.php" title="Interviews help" class="subbutton">INTERVIEWS HELP</a></li>
                            </ul>
                        </li>
                        <li><button type="button" class="topbutton" id="users">USERS</button>
                            <ul>
                                <li><a href="../administration/user_management.php" class="subbutton">USER MANAGEMENT</a></li>
                                <li><a href="../user/user_main.php"  class="subbutton">USER SEARCH</a></li>
                            </ul>
                        </li>
                        <li><button type="button" class="topbutton" id="admin">NEWS</button>
                            <ul>
                                <li><a href="../news/news_add.php" title="Add news" class="subbutton">ADD NEWS</a></li>
                                <li><a href="../news/news_approve.php" title="Approve news" class="subbutton">APPROVE NEWS</a></li>
                                <li><a href="../news/news_edit_all.php" title="Adit news" class="subbutton">EDIT NEWS</a></li>
                                <li><a href="../news/news_add_images.php" title="Add news image" class="subbutton">ADD NEWS IMAGE</a></li>
                            </ul>
                        </li>
                        <li><button type="button" class="topbutton" id="other">OTHER</button>
                            <ul>
                                <li><a href="../index.php" title="Statistics" class="subbutton">MAIN/STATS</a></li>
                                <li><a href="../administration/database_update.php" title="Administration" class="subbutton">DB UPDATES</a></li>
                                <li><a href="../administration/change_log.php" title="Change log" class="subbutton">CHANGE LOG</a></li>
                                <li><a href="../trivia/did_you_know.php" title="Did you know" class="subbutton">DID YOU KNOW</a></li>
                                <li><a href="../trivia/manage_trivia_quotes.php" title="Trivia quotes" class="subbutton">TRIVIA QUOTES</a></li>
                                <li><a href="../links/link_addnew.php" title="Add links" class="subbutton">ADD LINKS</a></li>
                                <li><a href="../links/link_modlist.php" title="Modify links" class="subbutton">MODIFY LINKS</a></li>
                                <li><a href="../links/link_cat.php" title="Link categories" class="subbutton">LINK CATEGORIES</a></li>
                                <li><a href="../articles/articles_main.php" title="Articles" class="subbutton">ARTICLES</a></li>
                                <li><a href="../articles/article_type.php" title="Article types" class="subbutton">ARTICLE TYPES</a></li>
                                <li><a href="../administration/construction.php" title="Add magazines" class="subbutton">ADD MAGAZINES</a></li>
                                <li><a href="../administration/construction.php" title="Manage issues" class="subbutton">MANAGE ISSUES</a></li>
                                <li><a href="http://www.atari-forum.com" title="Forum" class="subbutton">FORUM</a></li>
                                <li><a href="../administration/construction.php" title="Log out" class="subbutton">LOG OUT</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </header>
        </div>
        <div id="wrapper">
            <?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'main_body', array (
  0 => 'block_52405134058836faaef6615_49023860',
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
/* {block 'java_script'}  file:1/admin/main.html */
function block_155611752758836faaeebe03_19832311($_smarty_tpl, $_blockParentStack) {
}
/* {/block 'java_script'} */
/* {block 'main_body'}  file:1/admin/main.html */
function block_52405134058836faaef6615_49023860($_smarty_tpl, $_blockParentStack) {
}
/* {/block 'main_body'} */
}

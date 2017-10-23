<?php
/* Smarty version 3.1.29, created on 2017-01-21 14:26:46
  from "/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/main/frontpage.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_58836fa6d4bbc6_15301634',
  'file_dependency' => 
  array (
    'd7aad42f5c62a1e624a87947f8633143b0341ba4' => 
    array (
      0 => '/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/main/frontpage.html',
      1 => 1484337716,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:1/main/main.html' => 1,
    'file:1/main/screenstar_tile.html' => 2,
    'file:1/main/date_quote_tile.html' => 3,
    'file:1/main/hotlinks_tile.html' => 2,
    'file:1/main/latest_news_tile.html' => 2,
    'file:1/main/latest_reviews_tile.html' => 2,
    'file:1/main/user_login_tile.html' => 2,
    'file:1/main/who_is_it_tile.html' => 2,
    'file:1/main/did_you_know_tile.html' => 3,
    'file:1/main/statistics_tile.html' => 3,
  ),
),false)) {
function content_58836fa6d4bbc6_15301634 ($_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, true);
?>



<?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'javascript_slider', array (
  0 => 'block_11515102658836fa6d16ea5_90803720',
  1 => false,
  3 => 0,
  2 => 0,
));
?>


<?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'main_body', array (
  0 => 'block_114545270958836fa6d22267_03717193',
  1 => false,
  3 => 0,
  2 => 0,
));
?>

<?php $_smarty_tpl->ext->_inheritance->endChild($_smarty_tpl);
$_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:1/main/main.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block 'javascript_slider'}  file:../../../themes/templates/1/main/frontpage.html */
function block_11515102658836fa6d16ea5_90803720($_smarty_tpl, $_blockParentStack) {
?>

    <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['template_dir']->value;?>
includes/js/jssor.slider.mini.js"><?php echo '</script'; ?>
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

                $ArrowKeyNavigation: true,                          //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                $SlideDuration: 500,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide , default value is 20
                //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                //$SlideHeight: 400,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                $SlideSpacing: 0,                                   //[Optional] Space between each slide in pixels, default value is 0
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

                if ($(window).width() < 1495)
                {
                    var paddingWidth = -20;
                }
                else
                {
                    //reserve blank width for margin+padding: margin+padding-left (10) + margin+padding-right (10)
                    var paddingWidth = -0;
                }

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
 type="text/javascript"><!-- This script is needed for the animation of all the tiles - slide effect -->
      $(function() {

        // run the currently selected effect
        function runEffect() {

            if ($(window).width() > 1494)
            {
                $( ".latest_news" ).effect("slide", { direction: "down" }, 1000 );
                $( "#welcome" ).effect("slide", { direction: "up" }, 1000 );
                $( ".whoisit_position_front" ).effect("slide", { direction: "right" }, 1000 );
                $( ".logon" ).effect("slide", { direction: "right" }, 1000 );
                $( ".datequote_position_front" ).effect("slide", { direction: "left" }, 1000 );
                $( ".didyouknow_position_front" ).effect("slide", { direction: "right" }, 1000 );
                $( ".statistics_position_front" ).effect("slide", { direction: "right" }, 1000 );
                $( ".contact_tiles" ).effect("slide", { direction: "down" }, 1000 );
                $( ".screenstar_position_front" ).effect("slide", { direction: "left" }, 1000 );
                $( ".latest_reviews" ).effect("slide", { direction: "down" }, 1000 );
                $( ".hotlinks_position_front" ).effect("slide", { direction: "left" }, 1000 );
            }
            else if ($(window).width() > 800)
            {
                $( ".latest_news" ).effect("slide", { direction: "left" }, 1000 );
                $( "#welcome" ).effect("slide", { direction: "left" }, 1000 );
                $( ".whoisit_position_front" ).effect("slide", { direction: "left" }, 1000 );
                $( ".logon" ).effect("slide", { direction: "right" }, 1000 );
                $( ".datequote_position_front" ).effect("slide", { direction: "right" }, 1000 );
                $( ".didyouknow_position_front" ).effect("slide", { direction: "right" }, 1000 );
                $( ".statistics_position_front" ).effect("slide", { direction: "right" }, 1000 );
                $( ".contact_tiles" ).effect("slide", { direction: "right" }, 1000 );
                $( ".screenstar_position_front" ).effect("slide", { direction: "down" }, 1000 );
                $( ".latest_reviews" ).effect("slide", { direction: "down" }, 1000 );
                $( ".hotlinks_position_front" ).effect("slide", { direction: "down" }, 1000 );
            }
            else if ($(window).width() > 640)
            {
                $( ".latest_news" ).effect("slide", { direction: "left" }, 1000 );
                $( "#welcome" ).effect("slide", { direction: "left" }, 1000 );
                $( ".whoisit_position_front" ).effect("slide", { direction: "left" }, 1000 );
                $( ".logon" ).effect("slide", { direction: "right" }, 1000 );
                $( ".datequote_position_front" ).effect("slide", { direction: "left" }, 1000 );
                $( ".didyouknow_position_front" ).effect("slide", { direction: "right" }, 1000 );
                $( ".statistics_position_front" ).effect("slide", { direction: "right" }, 1000 );
                $( ".contact_tiles" ).effect("slide", { direction: "right" }, 1000 );
                $( ".screenstar_position_front" ).effect("slide", { direction: "right" }, 1000 );
                $( ".latest_reviews" ).effect("slide", { direction: "right" }, 1000 );
                $( ".hotlinks_position_front" ).effect("slide", { direction: "right" }, 1000 );
            }
            else
            {
                $( ".latest_news" ).effect("slide", { direction: "right" }, 1000 );
                $( "#welcome" ).effect("slide", { direction: "left" }, 1000 );
                $( ".whoisit_position_front" ).effect("slide", { direction: "left" }, 1000 );
                $( ".logon" ).effect("slide", { direction: "left" }, 1000 );
                $( ".datequote_position_front" ).effect("slide", { direction: "left" }, 1000 );
                $( ".didyouknow_position_front" ).effect("slide", { direction: "right" }, 1000 );
                $( ".statistics_position_front" ).effect("slide", { direction: "left" }, 1000 );
                $( ".contact_tiles" ).effect("slide", { direction: "right" }, 1000 );
                $( ".screenstar_position_front" ).effect("slide", { direction: "right" }, 1000 );
                $( ".latest_reviews" ).effect("slide", { direction: "left" }, 1000 );
                $( ".hotlinks_position_front" ).effect("slide", { direction: "right" }, 1000 );
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
<?php
}
/* {/block 'javascript_slider'} */
/* {block 'screenstar_tile'}  file:../../../themes/templates/1/main/frontpage.html */
function block_125879372158836fa6d22dd8_30366967($_smarty_tpl, $_blockParentStack) {
?>

            <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:1/main/screenstar_tile.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

            <?php
}
/* {/block 'screenstar_tile'} */
/* {block 'date_quote_tile'}  file:../../../themes/templates/1/main/frontpage.html */
function block_93259621558836fa6d24db9_90101567($_smarty_tpl, $_blockParentStack) {
?>

            <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:1/main/date_quote_tile.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

            <?php
}
/* {/block 'date_quote_tile'} */
/* {block 'hotlinks_tile'}  file:../../../themes/templates/1/main/frontpage.html */
function block_169922232358836fa6d26c35_32741856($_smarty_tpl, $_blockParentStack) {
?>

            <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:1/main/hotlinks_tile.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

            <?php
}
/* {/block 'hotlinks_tile'} */
/* {block 'latest_news_tile'}  file:../../../themes/templates/1/main/frontpage.html */
function block_133101242258836fa6d2e906_77405143($_smarty_tpl, $_blockParentStack) {
?>

                <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:1/main/latest_news_tile.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

                <?php
}
/* {/block 'latest_news_tile'} */
/* {block 'latest_reviews_tile'}  file:../../../themes/templates/1/main/frontpage.html */
function block_184144367758836fa6d307d9_53967537($_smarty_tpl, $_blockParentStack) {
?>

                <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:1/main/latest_reviews_tile.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

                <?php
}
/* {/block 'latest_reviews_tile'} */
/* {block 'user_login_tile'}  file:../../../themes/templates/1/main/frontpage.html */
function block_182265040158836fa6d32684_14003620($_smarty_tpl, $_blockParentStack) {
?>

            <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:1/main/user_login_tile.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

            <?php
}
/* {/block 'user_login_tile'} */
/* {block 'who_is_it_tile'}  file:../../../themes/templates/1/main/frontpage.html */
function block_146585145858836fa6d34355_91016635($_smarty_tpl, $_blockParentStack) {
?>

            <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:1/main/who_is_it_tile.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

            <?php
}
/* {/block 'who_is_it_tile'} */
/* {block 'did_you_know_tile'}  file:../../../themes/templates/1/main/frontpage.html */
function block_195320417758836fa6d35ca5_15613895($_smarty_tpl, $_blockParentStack) {
?>

            <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:1/main/did_you_know_tile.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

            <?php
}
/* {/block 'did_you_know_tile'} */
/* {block 'statistics_tile'}  file:../../../themes/templates/1/main/frontpage.html */
function block_90262759258836fa6d37583_83479324($_smarty_tpl, $_blockParentStack) {
?>

            <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:1/main/statistics_tile.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

            <?php
}
/* {/block 'statistics_tile'} */
/* {block 'user_login_tile'}  file:../../../themes/templates/1/main/frontpage.html */
function block_155708482858836fa6d38ea8_98334643($_smarty_tpl, $_blockParentStack) {
?>

            <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:1/main/user_login_tile.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

            <?php
}
/* {/block 'user_login_tile'} */
/* {block 'latest_news_tile'}  file:../../../themes/templates/1/main/frontpage.html */
function block_120081752458836fa6d3a720_42865907($_smarty_tpl, $_blockParentStack) {
?>

                <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:1/main/latest_news_tile.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

            <?php
}
/* {/block 'latest_news_tile'} */
/* {block 'who_is_it_tile'}  file:../../../themes/templates/1/main/frontpage.html */
function block_174012302558836fa6d3bed5_31685457($_smarty_tpl, $_blockParentStack) {
?>

            <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:1/main/who_is_it_tile.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

            <?php
}
/* {/block 'who_is_it_tile'} */
/* {block 'screenstar_tile'}  file:../../../themes/templates/1/main/frontpage.html */
function block_129466349258836fa6d3d6b8_86491356($_smarty_tpl, $_blockParentStack) {
?>

            <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:1/main/screenstar_tile.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

            <?php
}
/* {/block 'screenstar_tile'} */
/* {block 'latest_reviews_tile'}  file:../../../themes/templates/1/main/frontpage.html */
function block_136359114258836fa6d3eed7_31723692($_smarty_tpl, $_blockParentStack) {
?>

            <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:1/main/latest_reviews_tile.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

            <?php
}
/* {/block 'latest_reviews_tile'} */
/* {block 'hotlinks_tile'}  file:../../../themes/templates/1/main/frontpage.html */
function block_80898668558836fa6d40835_41458679($_smarty_tpl, $_blockParentStack) {
?>

            <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:1/main/hotlinks_tile.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

            <?php
}
/* {/block 'hotlinks_tile'} */
/* {block 'date_quote_tile'}  file:../../../themes/templates/1/main/frontpage.html */
function block_63604644858836fa6d42119_05026702($_smarty_tpl, $_blockParentStack) {
?>

            <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:1/main/date_quote_tile.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

            <?php
}
/* {/block 'date_quote_tile'} */
/* {block 'did_you_know_tile'}  file:../../../themes/templates/1/main/frontpage.html */
function block_1178093458836fa6d43a35_02724757($_smarty_tpl, $_blockParentStack) {
?>

            <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:1/main/did_you_know_tile.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

            <?php
}
/* {/block 'did_you_know_tile'} */
/* {block 'statistics_tile'}  file:../../../themes/templates/1/main/frontpage.html */
function block_36145155758836fa6d452e2_89625956($_smarty_tpl, $_blockParentStack) {
?>

            <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:1/main/statistics_tile.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

            <?php
}
/* {/block 'statistics_tile'} */
/* {block 'date_quote_tile'}  file:../../../themes/templates/1/main/frontpage.html */
function block_112782549858836fa6d46b85_61333656($_smarty_tpl, $_blockParentStack) {
?>

            <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:1/main/date_quote_tile.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

            <?php
}
/* {/block 'date_quote_tile'} */
/* {block 'did_you_know_tile'}  file:../../../themes/templates/1/main/frontpage.html */
function block_98044873858836fa6d48310_34169624($_smarty_tpl, $_blockParentStack) {
?>

            <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:1/main/did_you_know_tile.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

            <?php
}
/* {/block 'did_you_know_tile'} */
/* {block 'statistics_tile'}  file:../../../themes/templates/1/main/frontpage.html */
function block_39506791958836fa6d49aa4_34293533($_smarty_tpl, $_blockParentStack) {
?>

            <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:1/main/statistics_tile.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

            <?php
}
/* {/block 'statistics_tile'} */
/* {block 'main_body'}  file:../../../themes/templates/1/main/frontpage.html */
function block_114545270958836fa6d22267_03717193($_smarty_tpl, $_blockParentStack) {
?>



    <div id="main">

        <!--this column is only visible with 4 columns-->
        <div class="column_wide_left_1920">
            <!--Start logon tile - will only be used on the front page so no inheritance here -->
            <?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'screenstar_tile', array (
  0 => 'block_125879372158836fa6d22dd8_30366967',
  1 => false,
  3 => 0,
  2 => 0,
), $_blockParentStack);
?>


            <!--Start date quote tile-->
            <?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'date_quote_tile', array (
  0 => 'block_93259621558836fa6d24db9_90101567',
  1 => false,
  3 => 0,
  2 => 0,
), $_blockParentStack);
?>


            <!--Start "hotlinks" tile-->
            <?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'hotlinks_tile', array (
  0 => 'block_169922232358836fa6d26c35_32741856',
  1 => false,
  3 => 0,
  2 => 0,
), $_blockParentStack);
?>

        </div>

        <!--this column is only visible with 3 and 2 columns-->
        <div class="column_wide_left">
            <!-- Jssor Slider Begin -->
            <!-- To move inline styles to css file/block, please specify a class name for each element. -->
            <div id="welcome">
                <!-- Slides Container -->
                <div data-u="slides" class="welcome_slides">
                    <?php
$_from = $_smarty_tpl->tpl_vars['image']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_line_0_saved_item = isset($_smarty_tpl->tpl_vars['line']) ? $_smarty_tpl->tpl_vars['line'] : false;
$_smarty_tpl->tpl_vars['line'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['line']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['line']->value) {
$_smarty_tpl->tpl_vars['line']->_loop = true;
$__foreach_line_0_saved_local_item = $_smarty_tpl->tpl_vars['line'];
?>
                        <div><img class="standard_tile_image" data-u="image" src="../../includes/show_image.php?file=<?php echo $_smarty_tpl->tpl_vars['line']->value['image_name'];?>
" alt="">
                            <p class="welcome_text">
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
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_0_saved_local_item;
}
if ($__foreach_line_0_saved_item) {
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_0_saved_item;
}
?>
                </div>
            </div>
            <!-- Jssor Slider End -->

            <!--this column is only visible with 4 columns-->
            <div class="column_wide_center_1920">
                <!--Start latest news tile-->
                <?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'latest_news_tile', array (
  0 => 'block_133101242258836fa6d2e906_77405143',
  1 => false,
  3 => 0,
  2 => 0,
), $_blockParentStack);
?>


                <!--Start latest reviews tile-->
                <?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'latest_reviews_tile', array (
  0 => 'block_184144367758836fa6d307d9_53967537',
  1 => false,
  3 => 0,
  2 => 0,
), $_blockParentStack);
?>


                <div class="contact_tiles">
                    <div class="contact_email_button"><a href="#"> </a></div>
                    <div class="contact_facebook_button"><a href="#"> </a></div>
                    <div class="contact_jukebox_button"><a href="#"> </a></div>
                    <div class="contact_chat_button"><a href="#"> </a></div>
                </div>
            </div>
        </div>

        <!--this column is only visible with 4 columns-->
        <div class="column_wide_right_1920">
            <!--Start logon tile - will only be used on the front page so no inheritance here -->
            <?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'user_login_tile', array (
  0 => 'block_182265040158836fa6d32684_14003620',
  1 => false,
  3 => 0,
  2 => 0,
), $_blockParentStack);
?>


            <!--Start "Who is it" tile-->
            <?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'who_is_it_tile', array (
  0 => 'block_146585145858836fa6d34355_91016635',
  1 => false,
  3 => 0,
  2 => 0,
), $_blockParentStack);
?>


            <!--Start "Did you know" tile-->
            <?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'did_you_know_tile', array (
  0 => 'block_195320417758836fa6d35ca5_15613895',
  1 => false,
  3 => 0,
  2 => 0,
), $_blockParentStack);
?>


            <!--Start "statistics" tile-->
            <?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'statistics_tile', array (
  0 => 'block_90262759258836fa6d37583_83479324',
  1 => false,
  3 => 0,
  2 => 0,
), $_blockParentStack);
?>

        </div>

        <!--this column is only visible with 3 columns-->
        <div class="column_wide_right">
            <!--Start logon tile - will only be used on the front page so no inheritance here -->
            <?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'user_login_tile', array (
  0 => 'block_155708482858836fa6d38ea8_98334643',
  1 => false,
  3 => 0,
  2 => 0,
), $_blockParentStack);
?>

        </div>

        <!--this column is only visible in the 3 colum mode and 1 column mode-->
        <div class="column_left">
            <!--Start latest news tile-->
            <?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'latest_news_tile', array (
  0 => 'block_120081752458836fa6d3a720_42865907',
  1 => false,
  3 => 0,
  2 => 0,
), $_blockParentStack);
?>

            <!--Start "Who is it" tile-->
            <?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'who_is_it_tile', array (
  0 => 'block_174012302558836fa6d3bed5_31685457',
  1 => false,
  3 => 0,
  2 => 0,
), $_blockParentStack);
?>

        </div>

        <!--this column is only visible in the 3 colum mode and 1 column mode-->
        <div class="column_center">
            <!--Start screenstar tile-->
            <?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'screenstar_tile', array (
  0 => 'block_129466349258836fa6d3d6b8_86491356',
  1 => false,
  3 => 0,
  2 => 0,
), $_blockParentStack);
?>


            <!--Start latest reviews tile-->
            <?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'latest_reviews_tile', array (
  0 => 'block_136359114258836fa6d3eed7_31723692',
  1 => false,
  3 => 0,
  2 => 0,
), $_blockParentStack);
?>


            <!--Start "hotlinks" tile-->
            <?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'hotlinks_tile', array (
  0 => 'block_80898668558836fa6d40835_41458679',
  1 => false,
  3 => 0,
  2 => 0,
), $_blockParentStack);
?>

        </div>

        <!--this column is only visible in the 3 colum mode and 1 column mode-->
        <div class="column_right">

            <!--Start date quote tile-->
            <?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'date_quote_tile', array (
  0 => 'block_63604644858836fa6d42119_05026702',
  1 => false,
  3 => 0,
  2 => 0,
), $_blockParentStack);
?>


            <!--Start "Did you know" tile-->
            <?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'did_you_know_tile', array (
  0 => 'block_1178093458836fa6d43a35_02724757',
  1 => false,
  3 => 0,
  2 => 0,
), $_blockParentStack);
?>


            <!--Start "statistics" tile-->
            <?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'statistics_tile', array (
  0 => 'block_36145155758836fa6d452e2_89625956',
  1 => false,
  3 => 0,
  2 => 0,
), $_blockParentStack);
?>


            <!--Start contact tiles - will only be used on the front page so no inheritance here -->
            <div class="contact_tiles">
                    <div class="contact_email_button"><a href="#"> </a></div>
                    <div class="contact_facebook_button"><a href="#"> </a></div>
                    <div class="contact_jukebox_button"><a href="#"> </a></div>
                    <div class="contact_chat_button"><a href="#"> </a></div>
                </div>
        </div>

        <!--this column is only visible in the 2 colum mode -->
        <div class="column_left_tab">

            <!--Start date quote tile-->
            <?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'date_quote_tile', array (
  0 => 'block_112782549858836fa6d46b85_61333656',
  1 => false,
  3 => 0,
  2 => 0,
), $_blockParentStack);
?>


            <!--Start "Did you know" tile-->
            <?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'did_you_know_tile', array (
  0 => 'block_98044873858836fa6d48310_34169624',
  1 => false,
  3 => 0,
  2 => 0,
), $_blockParentStack);
?>


            <!--Start contact tiles-->
            <div class="contact_tiles">
                <div class="contact_jukebox_button"><a href="#"> </a></div>
                    <div class="contact_chat_button"><a href="#"> </a></div>
            </div>
        </div>

        <!--this column is only visible in the 2 colum mode -->
        <div class="column_right_tab">

            <!--Start "statistics" tile-->
            <?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'statistics_tile', array (
  0 => 'block_39506791958836fa6d49aa4_34293533',
  1 => false,
  3 => 0,
  2 => 0,
), $_blockParentStack);
?>


            <!--Start contact tiles-->
            <div class="contact_tiles">
                <div class="contact_email_button"><a href="#"> </a></div>
                    <div class="contact_facebook_button"><a href="#"> </a></div>
            </div>
        </div>
    </div>
<?php
}
/* {/block 'main_body'} */
}

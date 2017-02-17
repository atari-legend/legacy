<?php
/* Smarty version 3.1.29, created on 2017-01-21 14:26:50
  from "/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/admin/frontpage.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_58836faaee39d3_47838513',
  'file_dependency' => 
  array (
    'c7676813815db36d25904e4e9605a899dde96e0e' => 
    array (
      0 => '/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/admin/frontpage.html',
      1 => 1484337716,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:1/admin/main.html' => 1,
    'file:1/admin/left_nav.html' => 1,
    'file:1/admin/quick_search_games.html' => 1,
  ),
),false)) {
function content_58836faaee39d3_47838513 ($_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'main_body', array (
  0 => 'block_120808076758836faaedecc7_96293859',
  1 => false,
  3 => 0,
  2 => 0,
));
?>

<?php $_smarty_tpl->ext->_inheritance->endChild($_smarty_tpl);
$_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:1/admin/main.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block 'left_tile'}  file:1/admin/frontpage.html */
function block_73639867858836faaedf621_04787675($_smarty_tpl, $_blockParentStack) {
?>

                <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:1/admin/left_nav.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

            <?php
}
/* {/block 'left_tile'} */
/* {block 'main_tile'}  file:1/admin/frontpage.html */
function block_8021577158836faaee0f76_15664463($_smarty_tpl, $_blockParentStack) {
}
/* {/block 'main_tile'} */
/* {block 'right_tile'}  file:1/admin/frontpage.html */
function block_124717225758836faaee1db6_57464307($_smarty_tpl, $_blockParentStack) {
?>

                <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:1/admin/quick_search_games.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

            <?php
}
/* {/block 'right_tile'} */
/* {block 'main_body'}  file:1/admin/frontpage.html */
function block_120808076758836faaedecc7_96293859($_smarty_tpl, $_blockParentStack) {
?>

    <div id="main" class="main_container_cpanel">
        <div class="content_box_cpanel" id="column_left_cpanel">
            <br>
            <?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'left_tile', array (
  0 => 'block_73639867858836faaedf621_04787675',
  1 => false,
  3 => 0,
  2 => 0,
), $_blockParentStack);
?>

        </div>
        <div class="content_box_cpanel" id="column_center_cpanel">
            <br>
            <?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'main_tile', array (
  0 => 'block_8021577158836faaee0f76_15664463',
  1 => false,
  3 => 0,
  2 => 0,
), $_blockParentStack);
?>

        </div>
        <div class="content_box_cpanel" id="column_right_cpanel">
            <br>
            <?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'right_tile', array (
  0 => 'block_124717225758836faaee1db6_57464307',
  1 => false,
  3 => 0,
  2 => 0,
), $_blockParentStack);
?>

        </div>
    </div>
<?php
}
/* {/block 'main_body'} */
}

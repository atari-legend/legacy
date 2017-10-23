<?php
/* Smarty version 3.1.29, created on 2017-01-21 14:26:55
  from "/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/admin/menus_list.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_58836fafb0a910_82061395',
  'file_dependency' => 
  array (
    'eb9d17897d37be407cfcdd90e3329e76ec279c92' => 
    array (
      0 => '/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/admin/menus_list.html',
      1 => 1484337716,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:1/admin/frontpage.html' => 1,
    'file:1/admin/left_nav.html' => 1,
  ),
),false)) {
function content_58836fafb0a910_82061395 ($_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, true);
?>



<?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'title', array (
  0 => 'block_128960519558836fafaf0bf9_13472918',
  1 => false,
  3 => 0,
  2 => 0,
));
?>


<?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'left_tile', array (
  0 => 'block_183601701358836fafaf2258_18430128',
  1 => false,
  3 => 0,
  2 => 0,
));
?>


<?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'main_tile', array (
  0 => 'block_17722559458836fafaf40e0_48065434',
  1 => false,
  3 => 0,
  2 => 0,
));
?>

<?php $_smarty_tpl->ext->_inheritance->endChild($_smarty_tpl);
$_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:1/admin/frontpage.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block 'title'}  file:../../../themes/templates/1/admin/menus_list.html */
function block_128960519558836fafaf0bf9_13472918($_smarty_tpl, $_blockParentStack) {
?>
Menus Search results<?php
}
/* {/block 'title'} */
/* {block 'left_tile'}  file:../../../themes/templates/1/admin/menus_list.html */
function block_183601701358836fafaf2258_18430128($_smarty_tpl, $_blockParentStack) {
?>

<div class="standard_tile">
    <h1>MENU SET</h1>
    <div class="standard_tile_line"></div>
    <div class="standard_list_entry">
        <div class="standard_table_center">
            <form action="../menus/db_menu_disk.php" method="post" name="post" id="menu_edit">
                <br>
                Add new Menu Set:
                <br>
                <input type="text" name="menu_sets_name" value="" class="standard_tile_input_small">
                <br>
                <br>
                <input type="hidden" name="action" value="menu_set_new">
                <input type="submit" value="Add New" class="quick_search_games_button">
            </form>
        </div>
    </div>
</div>
<br>
<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:1/admin/left_nav.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php
}
/* {/block 'left_tile'} */
/* {block 'main_tile'}  file:../../../themes/templates/1/admin/menus_list.html */
function block_17722559458836fafaf40e0_48065434($_smarty_tpl, $_blockParentStack) {
?>

<div class="standard_tile">
    <div class="help-tip">
        <p>We start with a menu set. A menu set contains different menu disks. These menu disks contain menu titles - the games, tools, docs ...</p>
    </div>
    <div style="margin-left:20px;"><h1>MENU SEARCH</h1></div>
    <div class="standard_tile_line"></div>
    <div class="standard_tile_text">
        <?php if ((isset($_smarty_tpl->tpl_vars['nr_of_entries']->value))) {?>
            <div class="left_nav_section">
                This is the Menus search page. Select a menu set to browse its menu disks or start adding them.
            </div>
            <br>
            <br>
            <table class="standard_table_list" id="game_list_table">
                <tr>
                    <th id="menu_disk_set_th">Menu Disk Set</th>
                    <th id="menu_crew_th">Crew</th>
                    <th id="menu_individual_th">Indvidual</th>
                    <th id="menu_type_th">type</th>
                    <th id="nr_menus_th">Nr</th>
                </tr>
                <?php
$_from = $_smarty_tpl->tpl_vars['menus']->value;
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
                    <tr>
                        <td class="menu_disk_set_td"><?php if ($_smarty_tpl->tpl_vars['line']->value['menu_sets_name'] != '') {?><a href="../menus/menus_disk_list.php?menu_sets_id=<?php echo $_smarty_tpl->tpl_vars['line']->value['menu_sets_id'];?>
" class="standard_table_left"><?php echo $_smarty_tpl->tpl_vars['line']->value['menu_sets_name'];?>
</a><?php } else { ?><i>n/a</i><?php }?></td>
                        <td class="menu_crew_td"><?php if ($_smarty_tpl->tpl_vars['line']->value['crew_name'] != '') {
echo $_smarty_tpl->tpl_vars['line']->value['crew_name'];
} else { ?><i>n/a</i><?php }?></td>
                        <td class="menu_individual_td"><?php if ($_smarty_tpl->tpl_vars['line']->value['ind_name'] != '') {
echo $_smarty_tpl->tpl_vars['line']->value['ind_name'];
} else { ?><i>n/a</i><?php }?></td>
                        <td class="menu_type_td"><?php if ($_smarty_tpl->tpl_vars['line']->value['menu_type'] != '') {
echo $_smarty_tpl->tpl_vars['line']->value['menu_type'];
} else { ?><i>n/a</i><?php }?></td>
                        <td class="nr_menus_td"><?php if ($_smarty_tpl->tpl_vars['line']->value['numbermenus'] != '') {
echo $_smarty_tpl->tpl_vars['line']->value['numbermenus'];
} else { ?><i>0</i><?php }?></td>
                    </tr>
                <?php
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_0_saved_local_item;
}
if ($__foreach_line_0_saved_item) {
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_0_saved_item;
}
?>
                <tr>
                    <td class="standard_table_left" colspan="5">
                        <br><b><?php if ($_smarty_tpl->tpl_vars['nr_of_entries']->value == 1) {?>1 menus set found <?php } else { ?> <?php echo $_smarty_tpl->tpl_vars['nr_of_entries']->value;?>
 menus sets found<?php }?> in <?php echo $_smarty_tpl->tpl_vars['querytime']->value;?>
 sec</b>
                    </td>
                </tr>
            </table>
        <?php } else { ?>
            <div class="left_nav_section">
                There are no menu sets in the DB. Please create one.
            </div>
        <?php }?>
    </div>
</div>
<?php
}
/* {/block 'main_tile'} */
}

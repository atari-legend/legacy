<?php
/* Smarty version 3.1.29, created on 2017-01-21 14:26:50
  from "/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/admin/start_page.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_58836faaed8b33_69908455',
  'file_dependency' => 
  array (
    'bf360609d453e3613c4684f77dd02a764f199d7b' => 
    array (
      0 => '/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/admin/start_page.html',
      1 => 1484337716,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:1/admin/frontpage.html' => 1,
  ),
),false)) {
function content_58836faaed8b33_69908455 ($_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'main_tile', array (
  0 => 'block_58432842558836faaec55d5_05686475',
  1 => false,
  3 => 0,
  2 => 0,
));
?>

<?php $_smarty_tpl->ext->_inheritance->endChild($_smarty_tpl);
$_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:1/admin/frontpage.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block 'main_stats'}  file:../../../themes/templates/1/admin/start_page.html */
function block_63081826858836faaec6135_57258132($_smarty_tpl, $_blockParentStack) {
?>
	
<div class="standard_tile">
	<h1>MAIN STATS</h1>
	<div class="standard_tile_line"></div>
	<div class="standard_tile_text">
		<div class="main_stats_container">
			<div class="main_stats_child" id="child_some_stats">
						<table class="standard_table_list">
						<tr>
							<th>Some Stats</th>
						</tr>
							<?php
$_from = $_smarty_tpl->tpl_vars['statistics']->value;
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
							<td class="standard_table_center"><?php if ($_smarty_tpl->tpl_vars['line']->value['value'] != '') {
echo $_smarty_tpl->tpl_vars['line']->value['value'];
}?></td>
						</tr>
							<?php
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_0_saved_local_item;
}
if ($__foreach_line_0_saved_item) {
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_0_saved_item;
}
?>
						</table>	
			</div>
			<div class="main_stats_child" id="child_good_karma">
						<table class="standard_table_list">
						<tr>
							<th colspan="2" id="good_karma">Good Karma</th>
						</tr>
							<?php
$_from = $_smarty_tpl->tpl_vars['karma_good']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_line_1_saved_item = isset($_smarty_tpl->tpl_vars['line']) ? $_smarty_tpl->tpl_vars['line'] : false;
$_smarty_tpl->tpl_vars['line'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['line']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['line']->value) {
$_smarty_tpl->tpl_vars['line']->_loop = true;
$__foreach_line_1_saved_local_item = $_smarty_tpl->tpl_vars['line'];
?>
						<tr>
							<td><a href="../user/user_detail.php?user_id_selected=<?php echo $_smarty_tpl->tpl_vars['line']->value['user_id'];?>
" class="standard_table_left"><?php echo $_smarty_tpl->tpl_vars['line']->value['user_name'];?>
</a></td>
							<td class="standard_table_right"><?php echo $_smarty_tpl->tpl_vars['line']->value['karma'];?>
</td>
						</tr>
							<?php
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_1_saved_local_item;
}
if ($__foreach_line_1_saved_item) {
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_1_saved_item;
}
?>
						</table>						
			</div>
			<div class="main_stats_child" id="child_bad_karma">

						<table class="standard_table_list">
						<tr>
							<th colspan="2" id="bad_voodoo">Bad Voodoo</th>
						</tr>
							<?php
$_from = $_smarty_tpl->tpl_vars['karma_bad']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_line_2_saved_item = isset($_smarty_tpl->tpl_vars['line']) ? $_smarty_tpl->tpl_vars['line'] : false;
$_smarty_tpl->tpl_vars['line'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['line']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['line']->value) {
$_smarty_tpl->tpl_vars['line']->_loop = true;
$__foreach_line_2_saved_local_item = $_smarty_tpl->tpl_vars['line'];
?>
						<tr>
							<td><a href="../user/user_detail.php?user_id_selected=<?php echo $_smarty_tpl->tpl_vars['line']->value['user_id'];?>
" class="standard_table_left"><?php echo $_smarty_tpl->tpl_vars['line']->value['user_name'];?>
</a></td>
							<td class="standard_table_right"><?php echo $_smarty_tpl->tpl_vars['line']->value['karma'];?>
</td>
						</tr>
							<?php
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_2_saved_local_item;
}
if ($__foreach_line_2_saved_item) {
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_2_saved_item;
}
?>
						</table>	
			</div>
		</div>
	</div>
</div>
<br>
<?php
}
/* {/block 'main_stats'} */
/* {block 'welcome'}  file:../../../themes/templates/1/admin/start_page.html */
function block_115670230258836faaed4a21_76684036($_smarty_tpl, $_blockParentStack) {
?>

<div class="standard_tile" id="welcome_cpanel">
	<h1>WELCOME</h1>
		<div class="standard_tile_line"></div>
		<div class="standard_list_entry">
			<div class="standard_tile_text">
				<table>
				<tr>
					<td class="standard_table_center">This screen will give you a quick overview of all the various statistics of the atarilegend website. 
						The links on the left hand side of this screen allow you to control every aspect of your cpanel experience. 
						Each page will have instructions on how to use the tools. Is you have remarks or questions, please use the private 
						<a href="http://www.atari-forum.com/viewforum.php?f=36" class="standard_tile_link_cpanel">AtariLegend</a> forum over at 
						<a href="http://www.atari-forum.com/" class="standard_tile_link_cpanel">Atari-Forum.</a></td>
				</tr>
				</table>
				<br>
			</div>			
		</div>
	<div class="standard_tile_line"></div>
</div>
<?php
}
/* {/block 'welcome'} */
/* {block 'user_stats'}  file:../../../themes/templates/1/admin/start_page.html */
function block_137867855858836faaed5ae6_35894338($_smarty_tpl, $_blockParentStack) {
?>

<div class="standard_tile" id="user_stats">
	<h1>ADMIN STATS</h1>
		<div class="standard_tile_line"></div>
		<div class="standard_list_entry">
			<div class="standard_tile_text">
				<table>
				<tr>
					<td class="standard_table_center"><img class="user_stats_img" src="../../includes/show_image.php?file=<?php echo $_smarty_tpl->tpl_vars['users']->value['image'];?>
&amp;crop=164,null,null,null&amp;crop=left,top,164,120" alt="avatar"><br></td>
				</tr>
				<tr>
					<td class="standard_table_center">Welcome <?php echo $_smarty_tpl->tpl_vars['users']->value['user_name'];?>
</td>
				</tr>
				<tr>
					<td class="standard_table_center">Your <a href="../../admin/user/user_detail.php?user_id_selected=<?php echo $_smarty_tpl->tpl_vars['users']->value['user_id'];?>
" class="standard_tile_link_cpanel">detail page</a></td>
				</tr>
				</table>
			</div>			
		</div>
	<div class="standard_tile_line"></div>
</div>
<?php
}
/* {/block 'user_stats'} */
/* {block 'main_tile'}  file:../../../themes/templates/1/admin/start_page.html */
function block_58432842558836faaec55d5_05686475($_smarty_tpl, $_blockParentStack) {
?>

<?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'main_stats', array (
  0 => 'block_63081826858836faaec6135_57258132',
  1 => false,
  3 => 0,
  2 => 0,
), $_blockParentStack);
?>


<?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'welcome', array (
  0 => 'block_115670230258836faaed4a21_76684036',
  1 => false,
  3 => 0,
  2 => 0,
), $_blockParentStack);
?>


<?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'user_stats', array (
  0 => 'block_137867855858836faaed5ae6_35894338',
  1 => false,
  3 => 0,
  2 => 0,
), $_blockParentStack);
?>

<?php
}
/* {/block 'main_tile'} */
}

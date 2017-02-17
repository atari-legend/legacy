<?php
/* Smarty version 3.1.29, created on 2017-01-21 14:27:04
  from "/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/admin/database_update.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_58836fb8b06e21_74621240',
  'file_dependency' => 
  array (
    'f2550025c89d3040182a9a17539f3f82811c672d' => 
    array (
      0 => '/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/admin/database_update.html',
      1 => 1484337716,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:1/admin/frontpage.html' => 1,
  ),
),false)) {
function content_58836fb8b06e21_74621240 ($_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, true);
?>





<!-- <div class="standard_tile" id="<?php echo $_smarty_tpl->tpl_vars['left_nav']->value;?>
">
	<h1>ADMIN</h1>
		<div class="standard_tile_line"></div>
		<div class="standard_list_entry">
			<div class="standard_tile_text">
				<ul class="standard_table_list">
					<li class="left_nav_section">Sections</li>
					<li><a href="../administration/database_update.php" class="left_nav_link">Database Update</a></li>
					<li><a href="../administration/construction.php" class="left_nav_link">Website Settings</a></li>
					<li><a href="../administration/construction.php" class="left_nav_link">Website Themes</a></li>
				</ul>
			</div>			
		</div>
	<div class="standard_tile_line"></div>
</div> -->



<?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'java_script', array (
  0 => 'block_170433330658836fb8af9534_59884577',
  1 => false,
  3 => 0,
  2 => 0,
));
?>

<?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'main_tile', array (
  0 => 'block_136011800158836fb8afb538_66960856',
  1 => false,
  3 => 0,
  2 => 0,
));
?>

<?php $_smarty_tpl->ext->_inheritance->endChild($_smarty_tpl);
$_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:1/admin/frontpage.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block 'java_script'}  file:../../../themes/templates/1/admin/database_update.html */
function block_170433330658836fb8af9534_59884577($_smarty_tpl, $_blockParentStack) {
?>

<?php echo '<script'; ?>
 type="text/javascript">
function UpdateDatabase(database_update_id) 
{ 
            // CONFIRM REQUIRES ONE ARGUMENT 
         var message = "Are you sure? There is no going back from this..."; 
         // CONFIRM IS BOOLEAN. THAT MEANS THAT 
         // IT RETURNS TRUE IF 'OK' IS CLICKED 
         // OTHERWISE IT RETURN FALSE 
         var return_value = confirm(message); 
 
         if (return_value !="0") 
         { 
              url="db_database_update.php?action=update_database&update_script_id="+database_update_id; 
               location.href=url; 
         }  
} 
<?php echo '</script'; ?>
>
<?php
}
/* {/block 'java_script'} */
/* {block 'main_tile'}  file:../../../themes/templates/1/admin/database_update.html */
function block_136011800158836fb8afb538_66960856($_smarty_tpl, $_blockParentStack) {
?>

<div class="standard_tile">
	<h1>DATABASE UPDATES</h1>
	<div class="standard_tile_line"></div>
	<div class="standard_tile_text">
		<div class="main_stats_container">
			<table class="standard_table_list">
			<tr>
				<th id="th_db_id">ID</th>
				<th id="th_db_description">Description</th>
				<th id="th_db_result">Test</th>
				<th id="th_db_state">Status</th>
				<th id="th_db_exe">Action</th>
			</tr>
			<?php
$_from = $_smarty_tpl->tpl_vars['database_update']->value;
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
				<td class="standard_table_center" id="td_db_id"><?php echo $_smarty_tpl->tpl_vars['line']->value['database_update_id'];?>
</td>
				<td class="standard_table_center" id="td_db_description"><?php echo $_smarty_tpl->tpl_vars['line']->value['update_description'];?>
</td>
				<td class="standard_table_center" id="td_db_result"><?php echo $_smarty_tpl->tpl_vars['line']->value['test_result'];?>
</td>
				<td class="standard_table_center" id="td_db_state"><?php echo $_smarty_tpl->tpl_vars['line']->value['implementation_state'];?>
</td>
				<td class="standard_table_center" id="td_db_exe">
					<?php if ($_smarty_tpl->tpl_vars['line']->value['allow_execute'] == 'yes') {?>
						<button class="quick_search_games_button" onclick="UpdateDatabase(<?php echo $_smarty_tpl->tpl_vars['line']->value['database_update_id'];?>
);">Execute</button>
					<?php }?>
				</td>
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
	</div>
</div>
<?php
}
/* {/block 'main_tile'} */
}

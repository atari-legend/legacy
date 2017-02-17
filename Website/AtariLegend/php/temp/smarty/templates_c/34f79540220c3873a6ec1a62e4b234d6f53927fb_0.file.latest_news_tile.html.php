<?php
/* Smarty version 3.1.29, created on 2017-01-21 14:26:46
  from "/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/main/latest_news_tile.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_58836fa6d81551_93569117',
  'file_dependency' => 
  array (
    '34f79540220c3873a6ec1a62e4b234d6f53927fb' => 
    array (
      0 => '/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/main/latest_news_tile.html',
      1 => 1484337716,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58836fa6d81551_93569117 ($_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, false);
?>

<?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'latest_news_tile', array (
  0 => 'block_93278798558836fa6d78218_04689019',
  1 => false,
  3 => 0,
  2 => 0,
));
?>

<?php }
/* {block 'latest_news_tile'}  file:1/main/latest_news_tile.html */
function block_93278798558836fa6d78218_04689019($_smarty_tpl, $_blockParentStack) {
?>

<div class="latest_news">
	<div class="standard_tile" >
		<h1><a href="#" class="standard_tile_link">LATEST NEWS</a></h1>

		<?php $_smarty_tpl->tpl_vars["number"] = new Smarty_Variable(1, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "number", 0);?>
		<?php
$_from = $_smarty_tpl->tpl_vars['news']->value;
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
			
			<div class="standard_tile_line"></div>
			<div <?php if (!(1 & $_smarty_tpl->tpl_vars['number']->value)) {?>class="standard_list_entry"<?php } else { ?>class="standard_list_entry_odd"<?php }?>>
				<div class="standard_list_entry_left">
					<a href="#">
					<img src="../../includes/show_image.php?file=<?php echo $_smarty_tpl->tpl_vars['line']->value['image'];?>
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
					<h5 class="standard_list_entry_right_news_text">
							<?php echo $_smarty_tpl->tpl_vars['line']->value['news_text'];?>

					</h5>
				</div>							
			</div>
			<?php $_smarty_tpl->tpl_vars['number'] = new Smarty_Variable($_smarty_tpl->tpl_vars['number']->value+1, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'number', 0);?>
		<?php
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_0_saved_local_item;
}
if ($__foreach_line_0_saved_item) {
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_0_saved_item;
}
?>
		<div class="standard_tile_line"></div>
	</div>
</div>	
<?php
}
/* {/block 'latest_news_tile'} */
}

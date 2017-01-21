<?php
/* Smarty version 3.1.29, created on 2017-01-21 14:26:46
  from "/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/main/latest_reviews_tile.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_58836fa6d8a711_88241390',
  'file_dependency' => 
  array (
    '4f88b4469ab68d2a1b7c0a6c032f066578895332' => 
    array (
      0 => '/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/main/latest_reviews_tile.html',
      1 => 1484337716,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58836fa6d8a711_88241390 ($_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, false);
?>


<?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'latest_reviews_tile', array (
  0 => 'block_168208907558836fa6d835f7_40070641',
  1 => false,
  3 => 0,
  2 => 0,
));
?>

<?php }
/* {block 'latest_reviews_tile'}  file:1/main/latest_reviews_tile.html */
function block_168208907558836fa6d835f7_40070641($_smarty_tpl, $_blockParentStack) {
?>

<div class="latest_reviews">
	<div class="standard_tile">
		<h1><a href="#" class="standard_tile_link">LATEST REVIEWS</a></h1>
		<?php $_smarty_tpl->tpl_vars["number"] = new Smarty_Variable(1, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "number", 0);?>
		<?php
$_from = $_smarty_tpl->tpl_vars['recent_reviews']->value;
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
/* {/block 'latest_reviews_tile'} */
}

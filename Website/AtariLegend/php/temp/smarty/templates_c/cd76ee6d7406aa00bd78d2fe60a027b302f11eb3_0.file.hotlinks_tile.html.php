<?php
/* Smarty version 3.1.29, created on 2017-01-21 14:26:46
  from "/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/main/hotlinks_tile.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_58836fa6d766f2_52400232',
  'file_dependency' => 
  array (
    'cd76ee6d7406aa00bd78d2fe60a027b302f11eb3' => 
    array (
      0 => '/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/main/hotlinks_tile.html',
      1 => 1484337716,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58836fa6d766f2_52400232 ($_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, false);
?>

<?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'hotlinks_tile', array (
  0 => 'block_128560410558836fa6d711c9_35346815',
  1 => false,
  3 => 0,
  2 => 0,
));
?>
	
<?php }
/* {block 'hotlinks_tile'}  file:1/main/hotlinks_tile.html */
function block_128560410558836fa6d711c9_35346815($_smarty_tpl, $_blockParentStack) {
?>

	<div class="<?php echo $_smarty_tpl->tpl_vars['hotlinks_tile']->value;?>
">
		<div class="standard_tile">		
			<h1><a href="#" class="standard_tile_link">HOT LINKS</a></h1>
			<div class="standard_tile_line"></div>
			<div class="standard_tile_background">
				<a href="<?php echo $_smarty_tpl->tpl_vars['hotlinks']->value['website_url'];?>
" class="standard_tile_link"><img class="standard_tile_image" src="../../includes/show_image.php?file=<?php echo $_smarty_tpl->tpl_vars['hotlinks']->value['website_img'];?>
&amp;resize=410,null,null,null&amp;crop=left,top,410,260&amp;minimum_size=410,260" alt="hot links"></a>
				<p class="standard_tile_title" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis">
				<a href="<?php echo $_smarty_tpl->tpl_vars['hotlinks']->value['website_url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['hotlinks']->value['website_name'];?>
" class="standard_tile_link"><?php echo $_smarty_tpl->tpl_vars['hotlinks']->value['website_name'];?>
</a>
				<br><span class="standard_tile_subtext">link added by <?php echo $_smarty_tpl->tpl_vars['hotlinks']->value['userid'];?>
</span></p>
			</div>
			<div class="standard_tile_explanation">
				<br>	
				<h6><?php echo $_smarty_tpl->tpl_vars['hotlinks']->value['website_text'];?>
</h6>
				<br>
				<h2><a href="#" class="standard_tile_link">Visit ></a></h2>
			</div>
		</div>	
	</div>
<?php
}
/* {/block 'hotlinks_tile'} */
}

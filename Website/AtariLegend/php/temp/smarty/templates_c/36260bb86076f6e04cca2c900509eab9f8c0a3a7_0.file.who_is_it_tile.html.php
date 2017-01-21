<?php
/* Smarty version 3.1.29, created on 2017-01-21 14:26:46
  from "/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/main/who_is_it_tile.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_58836fa6d96925_91045934',
  'file_dependency' => 
  array (
    '36260bb86076f6e04cca2c900509eab9f8c0a3a7' => 
    array (
      0 => '/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/main/who_is_it_tile.html',
      1 => 1484337716,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58836fa6d96925_91045934 ($_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, false);
?>

<?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'who_is_it_tile', array (
  0 => 'block_193932603958836fa6d93076_65805219',
  1 => false,
  3 => 0,
  2 => 0,
));
?>

<?php }
/* {block 'who_is_it_tile'}  file:1/main/who_is_it_tile.html */
function block_193932603958836fa6d93076_65805219($_smarty_tpl, $_blockParentStack) {
?>

	<div class="<?php echo $_smarty_tpl->tpl_vars['who_is_it_tile']->value;?>
">
		<div class="standard_tile">		
			<h1><a href="#" class="standard_tile_link">WHO IS IT?</a></h1>
			<div class="standard_tile_line"></div>
			<div class="standard_tile_background">
				<a href="#" class="standard_tile_link">
				<img class="standard_tile_image" src="../../includes/show_image.php?file=<?php echo $_smarty_tpl->tpl_vars['who_is_it']->value['ind_img'];?>
&amp;resize=410,null,null,null&amp;crop=left,top,410,260" alt="Interview">
				</a>
				<p class="standard_tile_title"><a href="#" class="standard_tile_link"><?php echo $_smarty_tpl->tpl_vars['who_is_it']->value['ind_name'];?>
</a>
				<br><span class="standard_tile_subtext">Interview by <?php echo $_smarty_tpl->tpl_vars['who_is_it']->value['int_userid'];?>
</span></p>
			</div>
			<div class="standard_tile_explanation">
				<br>	
				<h6><?php echo $_smarty_tpl->tpl_vars['who_is_it']->value['int_text'];?>
</h6>
				<br>
				<h2><a href="#" class="standard_tile_link">Read more ></a></h2>
			</div>
		</div>	
	</div>
<?php
}
/* {/block 'who_is_it_tile'} */
}

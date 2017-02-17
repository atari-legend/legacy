<?php
/* Smarty version 3.1.29, created on 2017-01-21 14:26:46
  from "/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/main/screenstar_tile.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_58836fa6d6ccd5_60110087',
  'file_dependency' => 
  array (
    'b299e082a668e1eee90d96a1b844d646a356dbe9' => 
    array (
      0 => '/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/main/screenstar_tile.html',
      1 => 1484337716,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58836fa6d6ccd5_60110087 ($_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, false);
?>

<?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'screenstar_tile', array (
  0 => 'block_30623174158836fa6d69cd4_83497738',
  1 => false,
  3 => 0,
  2 => 0,
));
?>

<?php }
/* {block 'screenstar_tile'}  file:1/main/screenstar_tile.html */
function block_30623174158836fa6d69cd4_83497738($_smarty_tpl, $_blockParentStack) {
?>

	<div class="<?php echo $_smarty_tpl->tpl_vars['screenstar_tile']->value;?>
">
		<div class="standard_tile">		
			<h1><a href="#" class="standard_tile_link">SCREENSTAR</a></h1>
			<div class="standard_tile_line"></div>
			<div class="standard_tile_background">
				<a href="#" class="standard_tile_link"><img class="standard_tile_image" src="../../includes/show_image.php?file=<?php echo $_smarty_tpl->tpl_vars['screenstar']->value['screenstar_img'];?>
&amp;resize=410,null,null,null&amp;crop=left,top,410,260&amp;minimum_size=410,260" alt="screenstar"></a>
				<p class="standard_tile_title"><a href="#" class="standard_tile_link"><?php echo $_smarty_tpl->tpl_vars['screenstar']->value['screenstar_game_name'];?>
</a>
				<br><span class="standard_tile_subtext">Random comment</span></p>
			</div>
			<div class="standard_tile_explanation">
				<br>	
				<h6><?php echo $_smarty_tpl->tpl_vars['screenstar']->value['screenstar_comment'];?>
</h6>
				<br>
				<h2><a href="#" class="standard_tile_link">Read more ></a></h2>
			</div>
		</div>
	</div>
<?php
}
/* {/block 'screenstar_tile'} */
}

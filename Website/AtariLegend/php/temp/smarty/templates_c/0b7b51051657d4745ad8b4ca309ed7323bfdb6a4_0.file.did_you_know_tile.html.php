<?php
/* Smarty version 3.1.29, created on 2017-01-21 14:26:46
  from "/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/main/did_you_know_tile.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_58836fa6d99a04_38197085',
  'file_dependency' => 
  array (
    '0b7b51051657d4745ad8b4ca309ed7323bfdb6a4' => 
    array (
      0 => '/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/main/did_you_know_tile.html',
      1 => 1484337716,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58836fa6d99a04_38197085 ($_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, false);
?>

<?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'did_you_know_tile', array (
  0 => 'block_23887010058836fa6d983d8_28678307',
  1 => false,
  3 => 0,
  2 => 0,
));
?>
	<?php }
/* {block 'did_you_know_tile'}  file:1/main/did_you_know_tile.html */
function block_23887010058836fa6d983d8_28678307($_smarty_tpl, $_blockParentStack) {
?>

<div class="<?php echo $_smarty_tpl->tpl_vars['did_you_know_tile']->value;?>
">
	<div class="standard_tile">		
		<h1>DID YOU KNOW?</h1>
		<div class="standard_tile_line"></div>
		<div class="standard_tile_text">
			<h6><?php echo $_smarty_tpl->tpl_vars['trivia_text']->value;?>
</h6>
		</div>
	</div>	
</div>	
<?php
}
/* {/block 'did_you_know_tile'} */
}

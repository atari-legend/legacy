<?php
/* Smarty version 3.1.29, created on 2017-01-21 14:26:46
  from "/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/main/statistics_tile.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_58836fa6da2f48_71098581',
  'file_dependency' => 
  array (
    '0e7eeb3652360f5abcdfe01d1da1a5f7a032dc8a' => 
    array (
      0 => '/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/main/statistics_tile.html',
      1 => 1484337716,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58836fa6da2f48_71098581 ($_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, false);
?>

<?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'statistics_tile', array (
  0 => 'block_11754086558836fa6d9b2b2_65537046',
  1 => false,
  3 => 0,
  2 => 0,
));
?>

<?php }
/* {block 'statistics_tile'}  file:1/main/statistics_tile.html */
function block_11754086558836fa6d9b2b2_65537046($_smarty_tpl, $_blockParentStack) {
?>

<div class="<?php echo $_smarty_tpl->tpl_vars['statistics_tile']->value;?>
">	
	<div class="standard_tile">
		<h1>STATISTICS</h1>
		<div class="standard_tile_line"></div>
		<div class="standard_tile_text">
			<h6>
				<?php echo $_smarty_tpl->tpl_vars['statistics']->value['games_number'];?>
 games in the AL database <br>
				<span class="statistics_dark"><?php echo $_smarty_tpl->tpl_vars['statistics']->value['demos_number'];?>
 demos in the AL database</span> <br>
				<?php echo $_smarty_tpl->tpl_vars['statistics']->value['games_screenshot'];?>
 screenshots in the AL database <br> 
				<span class="statistics_dark"><?php echo $_smarty_tpl->tpl_vars['statistics']->value['games_screenshot_distinct'];?>
 games have screenshots</span> <br>
				<?php echo $_smarty_tpl->tpl_vars['statistics']->value['demos_screenshot_distinct'];?>
 demos have screenshots <br>
				<span class="statistics_dark"><?php echo $_smarty_tpl->tpl_vars['statistics']->value['game_publisher'];?>
 game publishers in the AL database</span> <br> 
				<?php echo $_smarty_tpl->tpl_vars['statistics']->value['game_developer'];?>
 game developers in the AL database <br> 
				<span class="statistics_dark"><?php echo $_smarty_tpl->tpl_vars['statistics']->value['game_year'];?>
 games have a release year</span> <br> 
				<?php echo $_smarty_tpl->tpl_vars['statistics']->value['games_boxscan'];?>
 gamebox scans in the AL database <br> 
				<span class="statistics_dark"><?php echo $_smarty_tpl->tpl_vars['statistics']->value['game_category'];?>
 games are signed to a category</span> <br> 
				<?php echo $_smarty_tpl->tpl_vars['statistics']->value['game_download'];?>
 games are downloadable <br>
			</h6>
		</div>
	</div>	
</div>
<?php
}
/* {/block 'statistics_tile'} */
}

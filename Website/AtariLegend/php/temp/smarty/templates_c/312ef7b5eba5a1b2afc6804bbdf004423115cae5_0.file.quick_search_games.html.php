<?php
/* Smarty version 3.1.29, created on 2017-01-21 14:26:50
  from "/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/admin/quick_search_games.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_58836faaf06103_79201766',
  'file_dependency' => 
  array (
    '312ef7b5eba5a1b2afc6804bbdf004423115cae5' => 
    array (
      0 => '/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/admin/quick_search_games.html',
      1 => 1484514352,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58836faaf06103_79201766 ($_smarty_tpl) {
if (!is_callable('smarty_function_html_options')) require_once '/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/php/vendor/smarty/smarty/libs/plugins/function.html_options.php';
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, false);
?>


<?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'quick_search_games', array (
  0 => 'block_159890093358836faaefe426_25323748',
  1 => false,
  3 => 0,
  2 => 0,
));
?>

<?php }
/* {block 'quick_search_games'}  file:1/admin/quick_search_games.html */
function block_159890093358836faaefe426_25323748($_smarty_tpl, $_blockParentStack) {
?>

<?php echo '<script'; ?>
 type="text/javascript">
function gameinsert()
{
    JSnewgame=document.getElementById("qs_newgame").value;
	
	if (JSnewgame=='')
	{
		alert('Please fill in a game name');
	}
	else
	{
    	// CONFIRM REQUIRES ONE ARGUMENT
    	var message = "Are you sure you want to insert this game into the database?";
    	// CONFIRM IS BOOLEAN. THAT MEANS THAT
    	// IT RETURNS TRUE IF 'OK' IS CLICKED
    	// OTHERWISE IT RETURN FALSE
    	var return_value = confirm(message);
		
    	if (return_value !="0")
    	{
    		url="../games/db_games_detail.php?newgame="+JSnewgame+"&action=insert_game";
			location.href=url;
    	} 
	}
}
<?php echo '</script'; ?>
>

<div class="standard_tile">
	<h1>QUICKSEARCH</h1>
	<div class="standard_tile_line"></div>
		<div class="standard_list_entry">
			<div class="standard_table_center">
				<form method="post" name="insertgame">
					<br>Add new Game:<br>	
					<input type="text" name="newgame" id="qs_newgame" value="" class="standard_tile_input_small"><br><br>	
					<input type="submit" value="Insert" onClick="gameinsert(); return false;" class="quick_search_games_button">	
				</form>
			</div>
			<br>
			<div class="standard_tile_line"></div>
			<br>
			<form action="../games/games_list.php" method="get" name="game_search" id="game_search">
				<div class="standard_table_center">
					<h3>Search for Game:</h3>	<br> 			
					<div class="standard_table_center">
						By name :<br>	
						<select name="gamebrowse" id="quick_search_small_select">
							<option value="" SELECTED>-</option>
							<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['az_value']->value,'output'=>$_smarty_tpl->tpl_vars['az_output']->value),$_smarty_tpl);?>

						</select>
						<input type="text" name="gamesearch" value="" class="standard_tile_input_small">
					</div>
					<br>
					<div class="standard_table_center">
						By Publisher : <br>
						<select name="publisher" id="quick_search_pub_select">
							<option value="-" SELECTED>-</option>
							<?php
$_from = $_smarty_tpl->tpl_vars['company_publisher']->value;
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
								<option value="<?php echo $_smarty_tpl->tpl_vars['line']->value['comp_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['line']->value['comp_name'];?>
</option>
							<?php
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_0_saved_local_item;
}
if ($__foreach_line_0_saved_item) {
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_0_saved_item;
}
?>
						</select>		
					</div>
					<br>
					<div class="standard_table_center">
						By Developer : <br>
						<select name="developer" id="quick_search_dev_select">
							<option value="-" SELECTED>-</option>
							<?php
$_from = $_smarty_tpl->tpl_vars['company_developer']->value;
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
								<option value="<?php echo $_smarty_tpl->tpl_vars['line']->value['comp_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['line']->value['comp_name'];?>
</option>
							<?php
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_1_saved_local_item;
}
if ($__foreach_line_1_saved_item) {
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_1_saved_item;
}
?>
						</select>
					</div>
					<br>
					<br>
					<div id="quick_search_options" class="standard_table_left">
						<div style="display:table-row;">
							<div style="display:table-cell;font-weight:bold;vertical-align:middle;"><input type="checkbox" name="falcon_only" value="1" class="quick_search_check">
								Falcon only&nbsp;
							</div>
						</div>
						<div style="display:table-row;">	
							<div style="display:table-cell;font-weight:bold;vertical-align:middle;"><input type="checkbox" name="falcon_enhanced" value="1" class="quick_search_check">
								Falcon Enhanced&nbsp;
							</div>
						</div>
                        <div style="display:table-row;">
							<div style="display:table-cell;font-weight:bold;vertical-align:middle;"><input type="checkbox" name="falcon_rgb" value="1" class="quick_search_check">
								Falcon RGB&nbsp;
							</div>
						</div>
						<div style="display:table-row;">	
							<div style="display:table-cell;font-weight:bold;vertical-align:middle;"><input type="checkbox" name="falcon_vga" value="1" class="quick_search_check">
								Falcon VGA&nbsp;
							</div>
						</div>
						<div style="display:table-row;">
							<div style="display:table-cell;font-weight:bold;vertical-align:middle;"><input type="checkbox" name="ste_only" value="1" class="quick_search_check">
								STE only
							</div>
						</div>
						<div style="display:table-row;">	
							<div style="display:table-cell;font-weight:bold;vertical-align:middle;"><input type="checkbox" name="ste_enhanced" value="1" class="quick_search_check">
								STE Enhanced&nbsp;
							</div>
						</div>	
						<div style="display:table-row;">
							<div style="display:table-cell;font-weight:bold;vertical-align:middle;"><input type="checkbox" name="free" value="1" class="quick_search_check">
								Non-Commercial&nbsp;
							</div>
						</div>
						<div style="display:table-row;">	
							<div style="display:table-cell;font-weight:bold;vertical-align:middle;"><input type="checkbox" name="arcade" value="1" class="quick_search_check">
								Arcade Conversion&nbsp;
							</div>
						</div>		
						<div style="display:table-row;">
							<div style="display:table-cell;font-weight:bold;vertical-align:middle;"><input type="checkbox" name="development" value="1" class="quick_search_check">
								In development&nbsp;
							</div>
						</div>
						<div style="display:table-row;">	
							<div style="display:table-cell;font-weight:bold;vertical-align:middle;"><input type="checkbox" name="wanted" value="1" class="quick_search_check">
								Wanted&nbsp;
							</div>
						</div>			
						<div style="display:table-row;">
							<div style="display:table-cell;font-weight:bold;vertical-align:middle;"><input type="checkbox" name="unreleased" value="1" class="quick_search_check">
								Unreleased&nbsp;
							</div>
						</div>
						<div style="display:table-row;">	
							<div style="display:table-cell;font-weight:bold;vertical-align:middle;"><input type="checkbox" name="unfinished" value="1" class="quick_search_check">
								Unfinished/Rumour&nbsp;
							</div>
						</div>				
						<div style="display:table-row;">
							<div style="display:table-cell;font-weight:bold;vertical-align:middle;"><input type="checkbox" name="monochrome" value="1" class="quick_search_check">
								Monochrome&nbsp;
							</div>
						</div>
						<div style="display:table-row;">	
							<div style="display:table-cell;font-weight:bold;vertical-align:middle;"><input type="checkbox" name="seuck" value="1" class="quick_search_check">
								SEUCK&nbsp;
							</div>
						</div>					
						<div style="display:table-row;">
							<div style="display:table-cell;font-weight:bold;vertical-align:middle;"><input type="checkbox" name="stos" value="1" class="quick_search_check">
								STOS&nbsp;
							</div>
						</div>
						<div style="display:table-row;">	
							<div style="display:table-cell;font-weight:bold;vertical-align:middle;"><input type="checkbox" name="stac" value="1" class="quick_search_check">
								STAC&nbsp;
							</div>
						</div>						
					</div>
					<br>
					<input type="hidden" name="action" id="action_quick_search" value="search">
					<input type="submit" value="Search" class="quick_search_games_button">
					<br><br>
					<hr>
				</div>
			</form>	
		</div>
</div>
<?php
}
/* {/block 'quick_search_games'} */
}

<?php
/* Smarty version 3.1.29, created on 2017-01-21 14:29:34
  from "/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/admin/games_main.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_5883704eba9d00_37817468',
  'file_dependency' => 
  array (
    'c9be9d09814b7a508784df22620010b48228e508' => 
    array (
      0 => '/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/admin/games_main.html',
      1 => 1484514352,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:1/admin/frontpage.html' => 1,
    'file:1/admin/quick_search_users.html' => 1,
  ),
),false)) {
function content_5883704eba9d00_37817468 ($_smarty_tpl) {
if (!is_callable('smarty_function_html_options')) require_once '/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/php/vendor/smarty/smarty/libs/plugins/function.html_options.php';
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'java_script', array (
  0 => 'block_18041268865883704eb99db6_72701434',
  1 => false,
  3 => 0,
  2 => 0,
));
?>


<?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'right_tile', array (
  0 => 'block_15283510585883704eb9bc35_25457928',
  1 => false,
  3 => 0,
  2 => 0,
));
?>


<?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'main_tile', array (
  0 => 'block_17040468755883704eb9d670_61471849',
  1 => false,
  3 => 0,
  2 => 0,
));
?>

<?php $_smarty_tpl->ext->_inheritance->endChild($_smarty_tpl);
$_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:1/admin/frontpage.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block 'java_script'}  file:../../../themes/templates/1/admin/games_main.html */
function block_18041268865883704eb99db6_72701434($_smarty_tpl, $_blockParentStack) {
?>

<?php echo '<script'; ?>
 type="text/javascript">
function gameinsert_gm()
{
    JSnewgame=document.getElementById("gm_newgame").value;

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
    		url="db_games_detail.php?newgame="+JSnewgame+"&action=insert_game";
			location.href=url;
    	}
	}
}
<?php echo '</script'; ?>
>
<?php
}
/* {/block 'java_script'} */
/* {block 'right_tile'}  file:../../../themes/templates/1/admin/games_main.html */
function block_15283510585883704eb9bc35_25457928($_smarty_tpl, $_blockParentStack) {
?>

	<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:1/admin/quick_search_users.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php
}
/* {/block 'right_tile'} */
/* {block 'main_tile'}  file:../../../themes/templates/1/admin/games_main.html */
function block_17040468755883704eb9d670_61471849($_smarty_tpl, $_blockParentStack) {
?>

<div class="standard_tile" id="games_main">
	<h1>ADD/EDIT A GAME</h1>
	<div class="standard_tile_line"></div>
	<div class="standard_tile_text">
		<div class="left_nav_section">
			In this section you can add or edit a game. Search for a game by using any of the
			functionalities below. Combinations are allowed. There are currently <b><?php echo $_smarty_tpl->tpl_vars['games_nr']->value;?>
</b> games
			in the DB.
		</div>
		<br>
		<br>
		<form action="../games/games_list.php" method="get" name="game_search">
		<div id="games_main_parent">
			<fieldset>
			<legend>Search games</legend>
			<br>
			<div class="games_main_row">
				<div class="games_main_text">By Name :</div>
				<div class="games_main_input">
					<select name="gamebrowse" id="games_main_small_select">
						<option value="" SELECTED>-</option>
						<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['az_value']->value,'output'=>$_smarty_tpl->tpl_vars['az_output']->value),$_smarty_tpl);?>

					</select>
					<input type="text" name="gamesearch" value="" class="standard_tile_input_small">
				</div>
			</div>
			<div class="games_main_row">
				<div class="games_main_text">By Publisher :</div>
				<div class="games_main_input">
					<select name="publisher" id="games_main_pub_select">
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
			</div>
			<div class="games_main_row">
				<div class="games_main_text">By Developer :</div>
				<div class="games_main_input">
					<select name="developer" id="games_main_dev_select">
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
			</div>
			<br>
			<br>
			<div class="games_check_container">
				<div class="games_check_child" id="child_1">
					<div class="games_check_row">
						<div class="games_check_box"><input type="checkbox" name="falcon_only" value="1" class="quick_search_check"></div>
						<div class="games_check_text">Falcon only</div>
					</div>
                    <div class="games_check_row">
						<div class="games_check_box"><input type="checkbox" name="falcon_rgb" value="1" class="quick_search_check"></div>
						<div class="games_check_text">Falcon RGB</div>
					</div>
					<div class="games_check_row">
						<div class="games_check_box"><input type="checkbox" name="ste_only" value="1" class="quick_search_check"></div>
						<div class="games_check_text">STE only</div>
					</div>
					<div class="games_check_row">
						<div class="games_check_box"><input type="checkbox" name="free" value="1" class="quick_search_check"></div>
						<div class="games_check_text">Non-Commercial</div>
					</div>
					<div class="games_check_row">
						<div class="games_check_box"><input type="checkbox" name="development" value="1" class="quick_search_check"></div>
						<div class="games_check_text">In development</div>
					</div>
					<div class="games_check_row">
						<div class="games_check_box"><input type="checkbox" name="unreleased" value="1" class="quick_search_check"></div>
						<div class="games_check_text">Unreleased</div>
					</div>
					<div class="games_check_row">
						<div class="games_check_box"><input type="checkbox" name="monochrome" value="1" class="quick_search_check"></div>
						<div class="games_check_text">Monochrome</div>
					</div>
					<div class="games_check_row">
						<div class="games_check_box"><input type="checkbox" name="stos" value="1" class="quick_search_check"></div>
						<div class="games_check_text">STOS</div>
					</div>
				</div>
				<div class="games_check_child" id="child_2">
					<div class="games_check_row">
						<div class="games_check_box"><input type="checkbox" name="falcon_enhanced" value="1" class="quick_search_check"></div>
						<div class="games_check_text">Falcon Enhanced</div>
					</div>
                    <div class="games_check_row">
						<div class="games_check_box"><input type="checkbox" name="falcon_vga" value="1" class="quick_search_check"></div>
						<div class="games_check_text">Falcon VGA</div>
					</div>
					<div class="games_check_row">
						<div class="games_check_box"><input type="checkbox" name="ste_enhanced" value="1" class="quick_search_check"></div>
						<div class="games_check_text">STE Enhanced</div>
					</div>
					<div class="games_check_row">
						<div class="games_check_box"><input type="checkbox" name="arcade" value="1" class="quick_search_check"></div>
						<div class="games_check_text">Arcade Conversion</div>
					</div>
					<div class="games_check_row">
						<div class="games_check_box"><input type="checkbox" name="wanted" value="1" class="quick_search_check"></div>
						<div class="games_check_text">Wanted</div>
					</div>
					<div class="games_check_row">
						<div class="games_check_box"><input type="checkbox" name="unfinished" value="1" class="quick_search_check"></div>
						<div class="games_check_text">Unfinished/Rumoured</div>
					</div>
					<div class="games_check_row">
						<div class="games_check_box"><input type="checkbox" name="seuck" value="1" class="quick_search_check"></div>
						<div class="games_check_text">SEUCK</div>
					</div>
					<div class="games_check_row">
						<div class="games_check_box"><input type="checkbox" name="stac" value="1" class="quick_search_check"></div>
						<div class="games_check_text">STAC</div>
					</div>
				</div>
			</div>
			<br>
			<br>
			<div class="standard_table_center">
				<input type="submit" value="Search" class="topbutton_cpanel_small">
			</div>
			<br>
			<br>
			</fieldset>
			<input type="hidden" name="action" id="action" value="search">
			<input type="hidden" name="user_id" id="user_id" value="<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
">
		</div>
		</form>
		<br>
		<br>
		<form method="post" name="insertgame">
		<fieldset>
		<legend>Add games</legend>
			<div class="standard_table_center">
				<input type="text" name="newgame" id="gm_newgame" value="" class="standard_tile_input_small">
				<input type="submit" value="Insert" onClick="gameinsert_gm(); return false;" class="topbutton_cpanel_small">
			</div>
		</fieldset>
		</form>
	</div>
</div>
<?php
}
/* {/block 'main_tile'} */
}

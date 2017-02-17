<?php
/* Smarty version 3.1.29, created on 2017-01-21 14:26:59
  from "/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/admin/ajax_menus_detail.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_58836fb3ed30e3_10371213',
  'file_dependency' => 
  array (
    'e462a5a0a572d9952b084b5f494de775d532933a' => 
    array (
      0 => '/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/admin/ajax_menus_detail.html',
      1 => 1484514352,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58836fb3ed30e3_10371213 ($_smarty_tpl) {
if (!is_callable('smarty_function_html_options')) require_once '/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/php/vendor/smarty/smarty/libs/plugins/function.html_options.php';
if (!is_callable('smarty_function_html_select_date')) require_once '/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/php/vendor/smarty/smarty/libs/plugins/function.html_select_date.php';
?>



<?php if (isset($_smarty_tpl->tpl_vars['smarty_action']->value) && $_smarty_tpl->tpl_vars['smarty_action']->value == "edit_disk_box") {?>	
	<td colspan="4" style="width:100%;margin:0px;padding:0px;">
		<table class="standard_table_list" id="menu_list_table">
			<tr>
				<td class="menu_disk_list_td"><a onclick="CloseeditDisk(<?php echo $_smarty_tpl->tpl_vars['menus']->value['menu_disk_id'];?>
)" style="cursor: pointer;"><?php echo $_smarty_tpl->tpl_vars['menus']->value['menu_disk_name'];?>
</a></td>
				<td class="menu_list_crew_td"><?php if (isset($_smarty_tpl->tpl_vars['menus']->value['crew_id'])) {
echo $_smarty_tpl->tpl_vars['menus']->value['crew_name'];
} else { ?><i>n/a</i><?php }?></td>
				<td class="menu_list_ind_td"><?php if (isset($_smarty_tpl->tpl_vars['menus']->value['ind_id'])) {
echo $_smarty_tpl->tpl_vars['menus']->value['ind_name'];
} else { ?><i>n/a</i><?php }?></td>						
				<td class="menu_state_td"><?php if (isset($_smarty_tpl->tpl_vars['menus']->value['menu_state'])) {
echo $_smarty_tpl->tpl_vars['menus']->value['menu_state'];
} else { ?><i>n/a</i><?php }?></td>
			</tr>
			<tr>
				<td colspan="4" style="border-top: solid 1px #b2b2b2;width:100%;">	
					<div class="help-tip">
						<p style="width:250px;right:243px;">
						<b>Set State</b> : The current state of the menu disk. Is this menu disk fully functional, missing ...<br><br>
						<b>Set parent menu</b> : It sometimes happens that a menu can be a sub menu of a completely different menu/menu set. Overhere you select to which menu the active menu belongs.<br><br>
						<b>Delete menu disk</b> : Completely delete the menu disk from the DB. You can only do this when all atachements like screenshots, files...have been removed.<br><br>
						<b>Add Intro Credits</b> : Apart from the crew or individual who released the menu set/disk, lots of menu disk have seperate coders and artists for the intro screen ... this is where you hook these individuals with the menu disk.<br><br>
						<b>Add game/tool/demo</b> : Add the actual menu disk titles (the software) to the menu disk.<br><br>
						<b>Add doc</b> : Are we dealing with a doc disk? Or does this menu disk contain docs? Add them using this link. All games and tools in the AL DB can be turned into a doc using this option.<br><br>
						<b>Add screenshot</b> : Add screenshots to the menu disk entry<br><br>
						<b>Add file</b> : Add the actual menudisk file (for download) to this menu disk entry<br><br>
                        <b>Release Year</b> : If it says 'not set', this means this menudisk is not yet linked to a release year!<br><br>
						</p>
					</div>
					<br>
					<div style="margin-left:20px;">					
						<div class="main_company_container">
							<div class="main_company_child" id="child_edit_company">
								<b>Set state:</b><br>
								<select name="state_id" id="quick_search_pub_select" onchange="ChangeState(this.value,<?php echo $_smarty_tpl->tpl_vars['menus']->value['menu_disk_id'];?>
)">
									<option value="">Set State</option>
									<?php if (isset($_smarty_tpl->tpl_vars['state_id']->value)) {?>
										<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['state_id']->value,'output'=>$_smarty_tpl->tpl_vars['menu_state']->value,'selected'=>$_smarty_tpl->tpl_vars['menu_state_id']->value),$_smarty_tpl);?>

									<?php }?>
								</select>
								<br>
								<br>
								<b>Set parent menu:</b><br>
								<select name="parent_id" id="quick_search_pub_select" onchange="ChangeParent(this.value,<?php echo $_smarty_tpl->tpl_vars['menus']->value['menu_disk_id'];?>
)">
									<option value="">Set parent</option>
									<?php
$_from = $_smarty_tpl->tpl_vars['parent']->value;
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
										<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['line']->value['parent_id'],'output'=>$_smarty_tpl->tpl_vars['line']->value['parent_name'],'selected'=>$_smarty_tpl->tpl_vars['menu_parent_id']->value),$_smarty_tpl);?>

									<?php
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_0_saved_local_item;
}
if ($__foreach_line_0_saved_item) {
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_0_saved_item;
}
?>
								</select>
								<br>
								<br>
								<b>Menu disk options :</b><br>
								<a onclick="DeleteMenuDisk(<?php echo $_smarty_tpl->tpl_vars['menus']->value['menu_disk_id'];?>
)" style="cursor: pointer;" class="standard_tile_link">Delete menu disk</a><br>
								<div id="intro_credit_link"><a onclick="popAddIntroCred(<?php echo $_smarty_tpl->tpl_vars['menus']->value['menu_disk_id'];?>
)" style="cursor: pointer;" class="standard_tile_link">Add intro credits</a><br></div>
								<div id="gameto_menu_link"><a onclick="popAddGames(<?php echo $_smarty_tpl->tpl_vars['menus']->value['menu_disk_id'];?>
)" style="cursor: pointer;" class="standard_tile_link">Add Game/Tool/Demo to menu</a><br></div>
								<div id="docto_menu_link"><a onclick="popAddDocs(<?php echo $_smarty_tpl->tpl_vars['menus']->value['menu_disk_id'];?>
)" style="cursor: pointer;" class="standard_tile_link">Add Doc to menu</a><br></div>
								<div id="screenshot_link"><a onclick="popAddScreenshots(<?php echo $_smarty_tpl->tpl_vars['menus']->value['menu_disk_id'];?>
)" style="cursor: pointer;" class="standard_tile_link">Add Screenshots to menu</a><br></div>
								<div id="file_link"><a onclick="popAddFile(<?php echo $_smarty_tpl->tpl_vars['menus']->value['menu_disk_id'];?>
)" style="cursor: pointer;" class="standard_tile_link">Add File to menu</a><br></div>						
							</div>
							<div class="main_company_child" id="child_add_company">
								<b>Release Year:</b><br>
								<?php echo smarty_function_html_select_date(array('start_year'=>"1984",'end_year'=>"+1",'display_days'=>false,'display_months'=>false,'prefix'=>'','field_name'=>'','style'=>"width:100px;height:25px;",'name'=>"year_id",'time'=>((string)$_smarty_tpl->tpl_vars['menus']->value['menu_year'])."-01-01",'onchange'=>"ChangeYear(this.value,".((string)$_smarty_tpl->tpl_vars['menu_disk_id']->value).")"),$_smarty_tpl);?>

                                <br><img src="../../../themes/templates/1/includes/img/arrow_ltr.gif" alt="" width="38" height="22" style="display:inline;">		
                                <h3 style="text-align:center;display:inline;"><?php if ((isset($_smarty_tpl->tpl_vars['menus']->value['menu_year']))) {?> <?php echo $_smarty_tpl->tpl_vars['menus']->value['menu_year'];?>
 set <?php } else { ?> Not set<?php }?></h3>
								<br>
								<br>
								<div id="menu_detail_expand"></div>
							</div>
						</div>
					</div>
					
					<div id="menu_credit_list">	
						<?php if (isset($_smarty_tpl->tpl_vars['individuals']->value)) {?>
                            <br>
                            <br>	
							<table class="table_game_list" id="game_list_table" style="width:95%;border: solid 1px black;margin:auto;">
							<tr>
								<th id="menu_cred_th">Credits</th>
								<th id="menu_scene_th">"Sceners"</th>
								<th id="menu_nick_th">Nick</th>
								<th id="menu_delete_th">
									<div class="help-tip">
										<p style="right:260px;">The intro of a menu disk was a lot of times coded by different people than the actual menu itself. You can add them by pressing the 'add intro credits' above. Once an individual is added, you can select his/her nickname. As some people used different nicks for different menu's.</p>
									</div>
								</th>
							</tr>	
							<?php
$_from = $_smarty_tpl->tpl_vars['individuals']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_outer_1_saved_item = isset($_smarty_tpl->tpl_vars['individual']) ? $_smarty_tpl->tpl_vars['individual'] : false;
$_smarty_tpl->tpl_vars['individual'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['individual']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['individual']->value) {
$_smarty_tpl->tpl_vars['individual']->_loop = true;
$__foreach_outer_1_saved_local_item = $_smarty_tpl->tpl_vars['individual'];
?>	
								<tr>
									<td class="menu_cred_td"><?php echo $_smarty_tpl->tpl_vars['individual']->value['author_type_info'];?>
</td>
									<td class="menu_scene_td"><a href="../individuals/individuals_edit.php?ind_id=<?php echo $_smarty_tpl->tpl_vars['individual']->value['ind_id'];?>
" class="standard_table_left"><?php echo $_smarty_tpl->tpl_vars['individual']->value['ind_name'];?>
</a></td>
									<form action="#" method="post" name="nick_edit<?php echo $_smarty_tpl->tpl_vars['individual']->value['ind_id'];?>
" id="nick_edit<?php echo $_smarty_tpl->tpl_vars['individual']->value['ind_id'];?>
">
										<td class="menu_nick_td">
											<select name="individual_nicks_id" id="quick_search_small_select" style="width:125px;" onchange="ChangeNick(this.value,<?php echo $_smarty_tpl->tpl_vars['individual']->value['menu_disk_credits_id'];?>
,<?php echo $_smarty_tpl->tpl_vars['individual']->value['menu_disk_id'];?>
)">
											<option value="" selected>-</option>
												<?php
$_from = $_smarty_tpl->tpl_vars['ind_nick']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_line_2_saved_item = isset($_smarty_tpl->tpl_vars['line']) ? $_smarty_tpl->tpl_vars['line'] : false;
$_smarty_tpl->tpl_vars['line'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['line']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['line']->value) {
$_smarty_tpl->tpl_vars['line']->_loop = true;
$__foreach_line_2_saved_local_item = $_smarty_tpl->tpl_vars['line'];
?>	
													<?php if ($_smarty_tpl->tpl_vars['line']->value['ind_id'] == $_smarty_tpl->tpl_vars['individual']->value['ind_id']) {?>
														<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['line']->value['individual_nicks_id'],'output'=>$_smarty_tpl->tpl_vars['line']->value['nick'],'selected'=>$_smarty_tpl->tpl_vars['individual']->value['individual_nicks_id']),$_smarty_tpl);?>

													<?php }?>
												<?php
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_2_saved_local_item;
}
if ($__foreach_line_2_saved_item) {
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_2_saved_item;
}
?>
											</select>
										</td>
									</form>				
									<td class="menu_delete_td" style="text-align:right;">
										<input type="button" onclick="DeleteCredits(<?php echo $_smarty_tpl->tpl_vars['individual']->value['menu_disk_credits_id'];?>
,<?php echo $_smarty_tpl->tpl_vars['individual']->value['menu_disk_id'];?>
)" class="quick_search_games_button" value="delete" style="margin-right:5px;">
									</td>
								</tr>
							<?php
$_smarty_tpl->tpl_vars['individual'] = $__foreach_outer_1_saved_local_item;
}
if ($__foreach_outer_1_saved_item) {
$_smarty_tpl->tpl_vars['individual'] = $__foreach_outer_1_saved_item;
}
?>
							</table>
						<?php }?>
					</div>			
					<div id="menu_software_list">
						<?php if (isset($_smarty_tpl->tpl_vars['game']->value)) {?>
                            <br>
                            <br>
							<table class="table_game_list" style="width:95%;border: solid 1px black;margin:auto;">
							<tr>
								<th id="menu_mark_th"></th>
								<th id="menu_gamename_th">Software Name</th>
								<th id="menu_gamedev_th">Developer</th>
								<th id="menu_gameyear_th">Year</th>
								<th id="menu_gameinfo_th">Info</th>
								<th id="menu_gameset_th">Set</th>
							</tr>
							<?php
$_from = $_smarty_tpl->tpl_vars['game']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_line_3_saved_item = isset($_smarty_tpl->tpl_vars['line']) ? $_smarty_tpl->tpl_vars['line'] : false;
$_smarty_tpl->tpl_vars['line'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['line']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['line']->value) {
$_smarty_tpl->tpl_vars['line']->_loop = true;
$__foreach_line_3_saved_local_item = $_smarty_tpl->tpl_vars['line'];
?>
								<tr class="table_game_list">
									<td class="menu_mark_td">
										<form name="MenuDiskContent" id="MenuDiskContent">
										<input type="checkbox" id="menu_disk_title_id<?php echo $_smarty_tpl->tpl_vars['line']->value['menu_disk_title_id'];?>
" name="menu_disk_title_id[]" value="<?php echo $_smarty_tpl->tpl_vars['line']->value['menu_disk_title_id'];?>
" onchange="deleteGamefromMenu(<?php echo $_smarty_tpl->tpl_vars['line']->value['menu_disk_title_id'];?>
,<?php echo $_smarty_tpl->tpl_vars['menu_disk_id']->value;?>
)">
									</td>
									<td class="menu_gamename_td">
										<?php if ($_smarty_tpl->tpl_vars['line']->value['game_name'] != '') {?>
											<?php if ($_smarty_tpl->tpl_vars['line']->value['menu_types_text'] == 'Game') {?><a href="../games/games_detail.php?game_id=<?php echo $_smarty_tpl->tpl_vars['line']->value['game_id'];?>
" class="standard_table_left"><?php echo $_smarty_tpl->tpl_vars['line']->value['game_name'];
if ($_smarty_tpl->tpl_vars['line']->value['set_chain'] != '') {?> - <a onclick="popAddSet(<?php echo $_smarty_tpl->tpl_vars['line']->value['menu_disk_title_id'];?>
,<?php echo $_smarty_tpl->tpl_vars['menus']->value['menu_disk_id'];?>
,'<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['line']->value['game_name']);?>
')" style="cursor: pointer;" class="standard_tile_link"><i>Part <?php echo $_smarty_tpl->tpl_vars['line']->value['set_chain'];?>
</i></a><?php }?></a><?php } else { ?><a href="../administration/construction.php" class="standard_table_left"><?php echo $_smarty_tpl->tpl_vars['line']->value['game_name'];?>
</a><?php }?>
										<?php } else { ?>
											<i>n/a</i>
										<?php }?>
									</td>
									<td class="menu_gamedev_td">
										<?php if ($_smarty_tpl->tpl_vars['line']->value['developer_name'] != '') {?>
											<?php if ($_smarty_tpl->tpl_vars['line']->value['menu_types_text'] == 'Game') {?>					
												<a href="../company/company_edit.php?comp_id=<?php echo $_smarty_tpl->tpl_vars['line']->value['developer_id'];?>
" class="standard_table_left"><?php echo $_smarty_tpl->tpl_vars['line']->value['developer_name'];?>
</a>
											<?php } else { ?>
												<a href="../administration/construction.php" class="standard_table_left"><?php echo $_smarty_tpl->tpl_vars['line']->value['developer_name'];?>
</a>
											<?php }?>
										<?php } else { ?>
											<i>n/a</i>	
										<?php }?>
									</td>				
									<td class="menu_gameyear_td">
										<?php if ($_smarty_tpl->tpl_vars['line']->value['year'] != '') {?>
											<?php if ($_smarty_tpl->tpl_vars['line']->value['menu_types_text'] == 'Game') {?>
												<a href="../games/games_list.php?year=<?php echo $_smarty_tpl->tpl_vars['line']->value['year'];?>
&amp;action=search" class="standard_table_left">
													<?php echo $_smarty_tpl->tpl_vars['line']->value['year'];?>

												</a>
											<?php } else { ?>
												<a href="../administration/construction.php" class="standard_table_left">
													<?php echo $_smarty_tpl->tpl_vars['line']->value['year'];?>

												</a>
											<?php }?>
										<?php } else { ?>
											<i>n/a</i>
										<?php }?>
									</td>
									<td class="menu_gameinfo_td">
										<?php echo $_smarty_tpl->tpl_vars['line']->value['menu_types_text'];?>

									</td>
									<td class="menu_gameset_td">
										<div id="<?php echo $_smarty_tpl->tpl_vars['line']->value['menu_disk_title_id'];?>
"><a onclick="popAddSet(<?php echo $_smarty_tpl->tpl_vars['line']->value['menu_disk_title_id'];?>
,<?php echo $_smarty_tpl->tpl_vars['menus']->value['menu_disk_id'];?>
,'<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['line']->value['game_name']);?>
')" style="cursor: pointer;" class="standard_tile_link">Add</a></div>
									</td>
								</tr>
							<?php
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_3_saved_local_item;
}
if ($__foreach_line_3_saved_item) {
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_3_saved_item;
}
?>
							<tr class="table_game_list">
								<td class="game_list_footer" colspan="6">
									<img src="../../../themes/templates/1/includes/img/arrow_ltr.gif" alt="" width="38" height="22" style="display:inline;">		
									<input type="button" value="Delete" class="quick_search_games_button" style="display:inline;">
                                    <input type="hidden" name="action" value="delete_from_menu_disk">
									<div class="help-tip" style="margin-bottom:2px;">
										<p style="right:260px;">Overhere you have an overview of the software titles on the menu disk. When pressing the 'add game/tool/demo' button above, a 
										list with search options will appear. Use this list to add titles to the menu. With the 'add' link in the 'set' column, you can CHAIN titles.</p>
									</div>
									</form>
								</td>
							</tr>
							</table>
						<?php }?>								
					</div>
					<br>
					<div id="menu_detail_expand_set"></div>	
					<div id="menu_detail_expand_games"></div>
					<div id="menu_doc_list">
						<?php if (isset($_smarty_tpl->tpl_vars['doc_game']->value)) {?>
                            <br>
							<table class="table_game_list" style="width:95%;border: solid 1px black;margin:auto;">
							<tr>
								<th id="menu_mark_th"></th>
								<th id="menu_docname_th">Doc Name</th>
								<th id="menu_doctype_th">Doc Type</th>
								<th id="menu_docinfo_th">Info</th>
							</tr>
							<?php
$_from = $_smarty_tpl->tpl_vars['doc_game']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_line_4_saved_item = isset($_smarty_tpl->tpl_vars['line']) ? $_smarty_tpl->tpl_vars['line'] : false;
$_smarty_tpl->tpl_vars['line'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['line']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['line']->value) {
$_smarty_tpl->tpl_vars['line']->_loop = true;
$__foreach_line_4_saved_local_item = $_smarty_tpl->tpl_vars['line'];
?>
								<tr class="table_game_list">
									<td class="menu_mark_td">
										<form name="MenuDiskContent" id="MenuDiskContent">
										<input type="checkbox" id="menu_disk_title_id<?php echo $_smarty_tpl->tpl_vars['line']->value['menu_disk_title_id'];?>
" name="menu_disk_title_id[]" value="<?php echo $_smarty_tpl->tpl_vars['line']->value['menu_disk_title_id'];?>
" onchange="deleteDocfromMenu(<?php echo $_smarty_tpl->tpl_vars['line']->value['menu_disk_title_id'];?>
,<?php echo $_smarty_tpl->tpl_vars['menu_disk_id']->value;?>
)">
									</td>
									<td class="menu_docname_td">
										<?php if ($_smarty_tpl->tpl_vars['line']->value['game_name'] != '') {?>
											<a href="../administration/construction.php" class="standard_table_left"><?php echo $_smarty_tpl->tpl_vars['line']->value['game_name'];?>
</a>
										<?php } else { ?>
											<i>n/a</i>
										<?php }?>
									</td>
									<td class="menu_doctype_td">
										<form action="#" method="post" name="doc_type_edit<?php echo $_smarty_tpl->tpl_vars['line']->value['doc_id'];?>
" id="doc_type_edit<?php echo $_smarty_tpl->tpl_vars['line']->value['doc_id'];?>
">
											<select name="doc_type_id" id="quick_search_small_select" style="width:125px;" onchange="ChangeDoctype(this.value,<?php echo $_smarty_tpl->tpl_vars['line']->value['doc_id'];?>
,<?php echo $_smarty_tpl->tpl_vars['menus']->value['menu_disk_id'];?>
)">
											<option value="" selected>-</option>
												<?php
$_from = $_smarty_tpl->tpl_vars['doc_type']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_doc_types_5_saved_item = isset($_smarty_tpl->tpl_vars['doc_types']) ? $_smarty_tpl->tpl_vars['doc_types'] : false;
$_smarty_tpl->tpl_vars['doc_types'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['doc_types']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['doc_types']->value) {
$_smarty_tpl->tpl_vars['doc_types']->_loop = true;
$__foreach_doc_types_5_saved_local_item = $_smarty_tpl->tpl_vars['doc_types'];
?>	
													<?php if ($_smarty_tpl->tpl_vars['doc_types']->value['doc_type_id'] == $_smarty_tpl->tpl_vars['line']->value['doc_type_id']) {?>
														<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['doc_types']->value['doc_type_id'],'output'=>$_smarty_tpl->tpl_vars['doc_types']->value['doc_type_name'],'selected'=>$_smarty_tpl->tpl_vars['line']->value['doc_type_id']),$_smarty_tpl);?>

													<?php } else { ?>
														<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['doc_types']->value['doc_type_id'],'output'=>$_smarty_tpl->tpl_vars['doc_types']->value['doc_type_name']),$_smarty_tpl);?>

													<?php }?>
												<?php
$_smarty_tpl->tpl_vars['doc_types'] = $__foreach_doc_types_5_saved_local_item;
}
if ($__foreach_doc_types_5_saved_item) {
$_smarty_tpl->tpl_vars['doc_types'] = $__foreach_doc_types_5_saved_item;
}
?>
											</select>
										</form>				
									</td>				
									<td class="menu_docinfo_td">
										<?php echo $_smarty_tpl->tpl_vars['line']->value['menu_types_text'];?>

									</td>
								</tr>
							<?php
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_4_saved_local_item;
}
if ($__foreach_line_4_saved_item) {
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_4_saved_item;
}
?>
							<tr class="table_game_list">
								<td class="game_list_footer" colspan="4">
									<img src="../../../themes/templates/1/includes/img/arrow_ltr.gif" alt="" width="38" height="22" style="display:inline;">		
									<input type="hidden" name="action" value="delete_from_menu_disk">
									<input type="button" value="Delete" class="quick_search_games_button" style="display:inline;">
									<div class="help-tip" style="margin-bottom:2px;">
										<p style="right:260px;">Overhere you have an overview of the docs on the menu disk. When pressing the 'add doc' button above, a list with search options will appear. 
										Use this list to add docs to the menu. Make sure to save the doc type as well!</p>
									</div>
									</form>
								</td>
							</tr>
							</table>
						<?php }?>								
					</div>
					<br>
					<div id="menu_detail_expand_docs"></div>
					<div id="menu_screenshot_list">
						<?php if (isset($_smarty_tpl->tpl_vars['screenshots']->value)) {?>
						<div class="standard_tile_text">
							<fieldset class="centered_fieldset">
								<legend>screenshots</legend>
								<?php if ($_smarty_tpl->tpl_vars['screenshots_nr']->value <> '') {?>
									<?php
$_from = $_smarty_tpl->tpl_vars['screenshots']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_screen_6_saved_item = isset($_smarty_tpl->tpl_vars['line']) ? $_smarty_tpl->tpl_vars['line'] : false;
$_smarty_tpl->tpl_vars['line'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['line']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['line']->value) {
$_smarty_tpl->tpl_vars['line']->_loop = true;
$__foreach_screen_6_saved_local_item = $_smarty_tpl->tpl_vars['line'];
?>
										<div style="display:inline-block;text-align:center;">
											Image <?php echo $_smarty_tpl->tpl_vars['line']->value['count'];?>
<br>
											<a href="../../includes/show_image.php?file=<?php echo $_smarty_tpl->tpl_vars['line']->value['screenshot_image'];?>
&amp;resize=410,null,null,null" data-lightbox="image-1" data-title="image - <?php echo $_smarty_tpl->tpl_vars['line']->value['count'];?>
">
											<img src="../../includes/show_image.php?file=<?php echo $_smarty_tpl->tpl_vars['line']->value['screenshot_image'];?>
&amp;resize=75,null,null,null" width="75" alt="Click to enlarge!" class="user_stats_img" id="user_details_img_dark"></a>
											<a href="javascript:deleteScreenshotfromMenu(<?php echo $_smarty_tpl->tpl_vars['line']->value['id'];?>
,<?php echo $_smarty_tpl->tpl_vars['menu_disk_id']->value;?>
)" class="standard_tile_link_black">Delete</a>  
											<br>
											<br>
										</div>
									<?php
$_smarty_tpl->tpl_vars['line'] = $__foreach_screen_6_saved_local_item;
}
if ($__foreach_screen_6_saved_item) {
$_smarty_tpl->tpl_vars['line'] = $__foreach_screen_6_saved_item;
}
?>
								<?php } else { ?>
									No screenshots attached to this menu
								<?php }?>
							</fieldset>
						</div>
						<?php }?>
					</div>
					<div id="menu_detail_expand_screenshots"></div>
					<div id="menu_file_list">
						<?php if (isset($_smarty_tpl->tpl_vars['downloads']->value)) {?>
						<div class="standard_tile_text">
							<fieldset class="centered_fieldset">
								<legend>File</legend>
								<?php if ($_smarty_tpl->tpl_vars['download_nr']->value <> '') {?>
									<?php
$_from = $_smarty_tpl->tpl_vars['downloads']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_line_7_saved_item = isset($_smarty_tpl->tpl_vars['line']) ? $_smarty_tpl->tpl_vars['line'] : false;
$_smarty_tpl->tpl_vars['line'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['line']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['line']->value) {
$_smarty_tpl->tpl_vars['line']->_loop = true;
$__foreach_line_7_saved_local_item = $_smarty_tpl->tpl_vars['line'];
?>
										<a href="<?php echo $_smarty_tpl->tpl_vars['line']->value['filepath'];
echo $_smarty_tpl->tpl_vars['line']->value['filename'];?>
.zip" class="left_nav_link"><b><?php echo $_smarty_tpl->tpl_vars['menu_disk_name']->value;?>
</b></a> - 
										<a href="javascript:deleteDownload(<?php echo $_smarty_tpl->tpl_vars['line']->value['menu_disk_download_id'];?>
,<?php echo $_smarty_tpl->tpl_vars['menu_disk_id']->value;?>
);" class="standard_tile_link_black">Delete</a>
										<br>
									<?php
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_7_saved_local_item;
}
if ($__foreach_line_7_saved_item) {
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_7_saved_item;
}
?>
								<?php } else { ?>
									No downloads attached to this menu
								<?php }?>
							</fieldset>
						</div>
						<?php }?>
					</div>
					<div id="menu_detail_expand_file"></div>
				</td>
			</tr>
		</table>
	</td>
	
	<?php if (isset($_smarty_tpl->tpl_vars['osd_message']->value)) {?>
		[BRK]<?php echo $_smarty_tpl->tpl_vars['osd_message']->value;?>

	<?php }?>
	
<?php }?>


<?php if (isset($_smarty_tpl->tpl_vars['smarty_action']->value) && $_smarty_tpl->tpl_vars['smarty_action']->value == "close_edit_disk_box") {?>
	<td class="menu_disk_list_td"><a onclick="editDisk(<?php echo $_smarty_tpl->tpl_vars['menus']->value['menu_disk_id'];?>
)" style="cursor: pointer;"><?php echo $_smarty_tpl->tpl_vars['menus']->value['menu_disk_name'];?>
</a></td>
	<td class="menu_list_crew_td"><?php if (isset($_smarty_tpl->tpl_vars['menus']->value['crew_id'])) {
echo $_smarty_tpl->tpl_vars['menus']->value['crew_name'];
} else { ?><i>n/a</i><?php }?></td>
	<td class="menu_list_ind_td"><?php if (isset($_smarty_tpl->tpl_vars['menus']->value['ind_id'])) {
echo $_smarty_tpl->tpl_vars['menus']->value['ind_name'];
} else { ?><i>n/a</i><?php }?></td>				
	<td class="menu_state_td"><?php if (isset($_smarty_tpl->tpl_vars['menus']->value['menu_state'])) {
echo $_smarty_tpl->tpl_vars['menus']->value['menu_state'];
} else { ?><i>n/a</i><?php }?></td>
<?php }?>


<?php if (isset($_smarty_tpl->tpl_vars['smarty_action']->value) && $_smarty_tpl->tpl_vars['smarty_action']->value == "add_intro_credit") {?>
	
	<br>
	<br>
	<form action="" method="post" id="menu_credits_form">
		<b>Add intro credits:</b><br>
		<Select class="saveHistory" id="m1" name="m1" onchange="browseInd(this.value)" style="width:70px;height:25px;display:inline;">
			<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['az_value']->value,'output'=>$_smarty_tpl->tpl_vars['az_output']->value),$_smarty_tpl);?>

		</select>
		<div id="ind_member" style="display:inline;">   
			<select id="ind_id" name="ind_id">
				<?php
$_from = $_smarty_tpl->tpl_vars['ind']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_line_8_saved_item = isset($_smarty_tpl->tpl_vars['line']) ? $_smarty_tpl->tpl_vars['line'] : false;
$_smarty_tpl->tpl_vars['line'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['line']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['line']->value) {
$_smarty_tpl->tpl_vars['line']->_loop = true;
$__foreach_line_8_saved_local_item = $_smarty_tpl->tpl_vars['line'];
?>
					<option value="<?php echo $_smarty_tpl->tpl_vars['line']->value['ind_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['line']->value['ind_name'];?>
</option>
				<?php
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_8_saved_local_item;
}
if ($__foreach_line_8_saved_item) {
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_8_saved_item;
}
?>	
			</select>
		</div>
        <br>
		<input type="text" onkeyup="searchInd(this.value)" class="standard_tile_input_small" value="search">
		<select id="author_type_id" name="author_type_id" size="1" style="margin:5px;margin-top:0px;width:200px;">
		<option value="">-</option>	
			<?php
$_from = $_smarty_tpl->tpl_vars['author_type']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_line_9_saved_item = isset($_smarty_tpl->tpl_vars['line']) ? $_smarty_tpl->tpl_vars['line'] : false;
$_smarty_tpl->tpl_vars['line'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['line']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['line']->value) {
$_smarty_tpl->tpl_vars['line']->_loop = true;
$__foreach_line_9_saved_local_item = $_smarty_tpl->tpl_vars['line'];
?>
				<option value="<?php echo $_smarty_tpl->tpl_vars['line']->value['author_type_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['line']->value['author_type_info'];?>
</option>
			<?php
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_9_saved_local_item;
}
if ($__foreach_line_9_saved_item) {
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_9_saved_item;
}
?>	
		</select>
		<br>
		<input type="hidden" name="action" value="add_intro_credits">
		<input type="hidden" name="menu_disk_id" value="<?php echo $_smarty_tpl->tpl_vars['menu_disk_id']->value;?>
">
		<input type="button" value="Add" onclick="addCreditstoMenu(<?php echo $_smarty_tpl->tpl_vars['menu_disk_id']->value;?>
)" class="topbutton_cpanel_small">
	</form>
	
<?php }?>


<?php if (isset($_smarty_tpl->tpl_vars['smarty_action']->value) && $_smarty_tpl->tpl_vars['smarty_action']->value == "add_game_to_menu_return") {?>
	<?php if (isset($_smarty_tpl->tpl_vars['game']->value)) {?>
        <br>
        <br>
		<table class="table_game_list" style="width:95%;border: solid 1px black;margin:auto;">
		<tr>
			<th id="menu_mark_th"></th>
			<th id="menu_gamename_th">Software Name</th>
			<th id="menu_gamedev_th">Developer</th>
			<th id="menu_gameyear_th">Year</th>
			<th id="menu_gameinfo_th">Info</th>
			<th id="menu_gameset_th">Set</th>
		</tr>
		<?php
$_from = $_smarty_tpl->tpl_vars['game']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_line_10_saved_item = isset($_smarty_tpl->tpl_vars['line']) ? $_smarty_tpl->tpl_vars['line'] : false;
$_smarty_tpl->tpl_vars['line'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['line']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['line']->value) {
$_smarty_tpl->tpl_vars['line']->_loop = true;
$__foreach_line_10_saved_local_item = $_smarty_tpl->tpl_vars['line'];
?>
			<tr class="table_game_list">
				<td class="menu_mark_td">
					<form name="MenuDiskContent" id="MenuDiskContent">
					<input type="checkbox" id="menu_disk_title_id<?php echo $_smarty_tpl->tpl_vars['line']->value['menu_disk_title_id'];?>
" name="menu_disk_title_id[]" value="<?php echo $_smarty_tpl->tpl_vars['line']->value['menu_disk_title_id'];?>
" onchange="deleteGamefromMenu(<?php echo $_smarty_tpl->tpl_vars['line']->value['menu_disk_title_id'];?>
,<?php echo $_smarty_tpl->tpl_vars['menu_disk_id']->value;?>
)">
				</td>
				<td class="menu_gamename_td">
					<?php if ($_smarty_tpl->tpl_vars['line']->value['game_name'] != '') {?>
						<?php if ($_smarty_tpl->tpl_vars['line']->value['menu_types_text'] == 'Game') {?><a href="../games/games_detail.php?game_id=<?php echo $_smarty_tpl->tpl_vars['line']->value['game_id'];?>
" class="standard_table_left"><?php echo $_smarty_tpl->tpl_vars['line']->value['game_name'];
if ($_smarty_tpl->tpl_vars['line']->value['set_chain'] != '') {?> - <a onclick="popAddSet(<?php echo $_smarty_tpl->tpl_vars['line']->value['menu_disk_title_id'];?>
,<?php echo $_smarty_tpl->tpl_vars['menu_disk_id']->value;?>
)" style="cursor: pointer;" class="standard_tile_link"><i>Part <?php echo $_smarty_tpl->tpl_vars['line']->value['set_chain'];?>
</i></a><?php }?></a><?php } else { ?><a href="../administration/construction.php" class="standard_table_left"><?php echo $_smarty_tpl->tpl_vars['line']->value['game_name'];?>
</a><?php }?>
					<?php } else { ?>
						<i>n/a</i>
					<?php }?>
				</td>
				<td class="menu_gamedev_td">
					<?php if ($_smarty_tpl->tpl_vars['line']->value['developer_name'] != '') {?>	
						<?php if ($_smarty_tpl->tpl_vars['line']->value['menu_types_text'] == 'Game') {?>					
							<a href="../company/company_edit.php?comp_id=<?php echo $_smarty_tpl->tpl_vars['line']->value['developer_id'];?>
" class="standard_table_left"><?php echo $_smarty_tpl->tpl_vars['line']->value['developer_name'];?>
</a>
						<?php } else { ?>
							<a href="../administration/construction.php" class="standard_table_left"><?php echo $_smarty_tpl->tpl_vars['line']->value['developer_name'];?>
</a>
						<?php }?>
					<?php } else { ?>
						<i>n/a</i>
					<?php }?></td>				
				<td class="menu_gameyear_td">
					<?php if ($_smarty_tpl->tpl_vars['line']->value['year'] != '') {?>
						<?php if ($_smarty_tpl->tpl_vars['line']->value['menu_types_text'] == 'Game') {?>
							<a href="../games/games_list.php?year=<?php echo $_smarty_tpl->tpl_vars['line']->value['year'];?>
&amp;action=search" class="standard_table_left">
								<?php echo $_smarty_tpl->tpl_vars['line']->value['year'];?>

							</a>
						<?php } else { ?>
							<a href="../administration/construction.php" class="standard_table_left">
								<?php echo $_smarty_tpl->tpl_vars['line']->value['year'];?>

							</a>
						<?php }?>
					<?php } else { ?>
						<i>n/a</i>
					<?php }?>
				</td>
				<td class="menu_gameinfo_td">
					<?php echo $_smarty_tpl->tpl_vars['line']->value['menu_types_text'];?>

				</td>
				<td class="menu_gameset_td">
					<div id="set_link"><a onclick="popAddSet(<?php echo $_smarty_tpl->tpl_vars['line']->value['menu_disk_title_id'];?>
,<?php echo $_smarty_tpl->tpl_vars['menu_disk_id']->value;?>
,'<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['line']->value['game_name']);?>
')" style="cursor: pointer;" class="standard_tile_link">Add</a></div>
				</td>
			</tr>
		<?php
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_10_saved_local_item;
}
if ($__foreach_line_10_saved_item) {
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_10_saved_item;
}
?>
		<tr>
			<td class="game_list_footer" colspan="6">
				<img src="../../../themes/templates/1/includes/img/arrow_ltr.gif" alt="" width="38" height="22" style="display:inline;">	
				<input type="hidden" name="action" value="delete_from_menu_disk">
				<input type="button" value="Delete" class="quick_search_games_button" style="display:inline;">
				<div class="help-tip" style="margin-bottom:2px;">
					<p style="right:260px;">Overhere you have an overview of the software titles on the menu disk. When pressing the 'add game/tool/demo' button above, a 
					list with search options will appear. Use this list to add titles to the menu. With the 'add' link in the 'set' column, you can CHAIN titles.</p>
				</div>
				</form>
			</td>
		</tr>
		</table>
	<?php }?>

	<?php if (isset($_smarty_tpl->tpl_vars['osd_message']->value)) {?>
		[BRK]<?php echo $_smarty_tpl->tpl_vars['osd_message']->value;?>

	<?php }?>
			
<?php }?>


<?php if (isset($_smarty_tpl->tpl_vars['smarty_action']->value) && $_smarty_tpl->tpl_vars['smarty_action']->value == "add_doc_to_menu_return") {?>
	<?php if (isset($_smarty_tpl->tpl_vars['doc_game']->value)) {?>		
        <br>
		<table class="table_game_list" style="width:95%;border: solid 1px black;margin:auto;">
		<tr>
			<th id="menu_mark_th"></th>
			<th id="menu_docname_th">Doc Name</th>
			<th id="menu_doctype_th">Doc Type</th>
			<th id="menu_docinfo_th">Info</th>
		</tr>
		<?php
$_from = $_smarty_tpl->tpl_vars['doc_game']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_line_11_saved_item = isset($_smarty_tpl->tpl_vars['line']) ? $_smarty_tpl->tpl_vars['line'] : false;
$_smarty_tpl->tpl_vars['line'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['line']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['line']->value) {
$_smarty_tpl->tpl_vars['line']->_loop = true;
$__foreach_line_11_saved_local_item = $_smarty_tpl->tpl_vars['line'];
?>
			<tr class="table_game_list">
				<td class="menu_mark_td">
					<form name="MenuDiskContent" id="MenuDiskContent">
					<input type="checkbox" id="menu_disk_title_id<?php echo $_smarty_tpl->tpl_vars['line']->value['menu_disk_title_id'];?>
" name="menu_disk_title_id[]" value="<?php echo $_smarty_tpl->tpl_vars['line']->value['menu_disk_title_id'];?>
" onchange="deleteDocfromMenu(<?php echo $_smarty_tpl->tpl_vars['line']->value['menu_disk_title_id'];?>
,<?php echo $_smarty_tpl->tpl_vars['menu_disk_id']->value;?>
)">
				</td>
				<td class="menu_docname_td">
					<?php if ($_smarty_tpl->tpl_vars['line']->value['game_name'] != '') {?>
						<a href="../administration/construction.php" class="standard_table_left"><?php echo $_smarty_tpl->tpl_vars['line']->value['game_name'];?>
</a>
					<?php } else { ?>
						<i>n/a</i>
					<?php }?>
				</td>
				<td class="menu_doctype_td">
					<form action="#" method="post" name="doc_type_edit<?php echo $_smarty_tpl->tpl_vars['line']->value['doc_id'];?>
" id="doc_type_edit<?php echo $_smarty_tpl->tpl_vars['line']->value['doc_id'];?>
">
						<select name="doc_type_id" id="quick_search_small_select" style="width:125px;" onchange="ChangeDoctype(this.value,<?php echo $_smarty_tpl->tpl_vars['line']->value['doc_id'];?>
,<?php echo $_smarty_tpl->tpl_vars['menu_disk_id']->value;?>
)">
						<option value="" selected>-</option>
							<?php
$_from = $_smarty_tpl->tpl_vars['doc_type']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_doc_types_12_saved_item = isset($_smarty_tpl->tpl_vars['doc_types']) ? $_smarty_tpl->tpl_vars['doc_types'] : false;
$_smarty_tpl->tpl_vars['doc_types'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['doc_types']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['doc_types']->value) {
$_smarty_tpl->tpl_vars['doc_types']->_loop = true;
$__foreach_doc_types_12_saved_local_item = $_smarty_tpl->tpl_vars['doc_types'];
?>	
								<?php if ($_smarty_tpl->tpl_vars['doc_types']->value['doc_type_id'] == $_smarty_tpl->tpl_vars['line']->value['doc_type_id']) {?>
									<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['doc_types']->value['doc_type_id'],'output'=>$_smarty_tpl->tpl_vars['doc_types']->value['doc_type_name'],'selected'=>$_smarty_tpl->tpl_vars['line']->value['doc_type_id']),$_smarty_tpl);?>

								<?php } else { ?>
									<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['doc_types']->value['doc_type_id'],'output'=>$_smarty_tpl->tpl_vars['doc_types']->value['doc_type_name']),$_smarty_tpl);?>

								<?php }?>
							<?php
$_smarty_tpl->tpl_vars['doc_types'] = $__foreach_doc_types_12_saved_local_item;
}
if ($__foreach_doc_types_12_saved_item) {
$_smarty_tpl->tpl_vars['doc_types'] = $__foreach_doc_types_12_saved_item;
}
?>
						</select>
					</form>				
				</td>				
				<td class="menu_docinfo_td">
					<?php echo $_smarty_tpl->tpl_vars['line']->value['menu_types_text'];?>

				</td>
			</tr>
		<?php
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_11_saved_local_item;
}
if ($__foreach_line_11_saved_item) {
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_11_saved_item;
}
?>
		<tr class="table_game_list">
			<td class="game_list_footer" colspan="4">
				<img src="../../../themes/templates/1/includes/img/arrow_ltr.gif" alt="" width="38" height="22"  style="display:inline;">		
				<input type="hidden" name="action" value="delete_from_menu_disk">
				<input type="button" value="Delete" class="quick_search_games_button" style="display:inline;">
				<div class="help-tip" style="margin-bottom:2px;">
					<p style="right:260px;">Overhere you have an overview of the docs on the menu disk. When pressing the 'add doc' button above, a list with search options will appear. 
					Use this list to add docs to the menu. Make sure to save the doc type as well!</p>
				</div>
				</form>
			</td>
		</tr>
		</table>
	<?php }?>

	<?php if (isset($_smarty_tpl->tpl_vars['osd_message']->value)) {?>
		[BRK]<?php echo $_smarty_tpl->tpl_vars['osd_message']->value;?>

	<?php }?>
			
<?php }?>


<?php if (isset($_smarty_tpl->tpl_vars['smarty_action']->value) && $_smarty_tpl->tpl_vars['smarty_action']->value == "add_screen_to_menu_return") {?>
	<div class="standard_tile_text">
		<fieldset class="centered_fieldset">
			<legend>screenshots</legend>
			<?php if ($_smarty_tpl->tpl_vars['screenshots_nr']->value <> '') {?>
				<?php
$_from = $_smarty_tpl->tpl_vars['screenshots']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_screen_13_saved_item = isset($_smarty_tpl->tpl_vars['line']) ? $_smarty_tpl->tpl_vars['line'] : false;
$_smarty_tpl->tpl_vars['line'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['line']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['line']->value) {
$_smarty_tpl->tpl_vars['line']->_loop = true;
$__foreach_screen_13_saved_local_item = $_smarty_tpl->tpl_vars['line'];
?>
					<div style="display:inline-block;text-align:center;">
						Image <?php echo $_smarty_tpl->tpl_vars['line']->value['count'];?>
<br>
						<a href="../../includes/show_image.php?file=<?php echo $_smarty_tpl->tpl_vars['line']->value['screenshot_image'];?>
&amp;resize=410,null,null,null" data-lightbox="image-1" data-title="image - <?php echo $_smarty_tpl->tpl_vars['line']->value['count'];?>
">
						<img src="../../includes/show_image.php?file=<?php echo $_smarty_tpl->tpl_vars['line']->value['screenshot_image'];?>
&amp;resize=75,null,null,null" width="75" alt="Click to enlarge!" class="user_stats_img" id="user_details_img_dark"></a>
						<a href="javascript:deleteScreenshotfromMenu(<?php echo $_smarty_tpl->tpl_vars['line']->value['id'];?>
,<?php echo $_smarty_tpl->tpl_vars['menu_disk_id']->value;?>
)" class="standard_tile_link_black">Delete</a>  
						<br>
						<br>
					</div>
				<?php
$_smarty_tpl->tpl_vars['line'] = $__foreach_screen_13_saved_local_item;
}
if ($__foreach_screen_13_saved_item) {
$_smarty_tpl->tpl_vars['line'] = $__foreach_screen_13_saved_item;
}
?>
			<?php } else { ?>
				No screenshots attached to this menu
			<?php }?>
		</fieldset>
	</div>
	
   <?php if (isset($_smarty_tpl->tpl_vars['osd_message']->value)) {?>
		[BRK]<?php echo $_smarty_tpl->tpl_vars['osd_message']->value;?>

	<?php }?>
	
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['smarty_action']->value) && $_smarty_tpl->tpl_vars['smarty_action']->value == "add_file_to_menu_return") {?>
	<div class="standard_tile_text">
		<fieldset class="centered_fieldset">
			<legend>File</legend>
			<?php if ($_smarty_tpl->tpl_vars['download_nr']->value <> '') {?>
				<?php
$_from = $_smarty_tpl->tpl_vars['downloads']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_line_14_saved_item = isset($_smarty_tpl->tpl_vars['line']) ? $_smarty_tpl->tpl_vars['line'] : false;
$_smarty_tpl->tpl_vars['line'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['line']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['line']->value) {
$_smarty_tpl->tpl_vars['line']->_loop = true;
$__foreach_line_14_saved_local_item = $_smarty_tpl->tpl_vars['line'];
?>
					<a href="<?php echo $_smarty_tpl->tpl_vars['line']->value['filepath'];
echo $_smarty_tpl->tpl_vars['line']->value['filename'];?>
.zip" class="left_nav_link"><b><?php echo $_smarty_tpl->tpl_vars['menu_disk_name']->value;?>
</b></a> - 
					<a href="javascript:deleteDownload(<?php echo $_smarty_tpl->tpl_vars['line']->value['menu_disk_download_id'];?>
,<?php echo $_smarty_tpl->tpl_vars['menu_disk_id']->value;?>
);" class="standard_tile_link_black">Delete</a>
					<br>
				<?php
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_14_saved_local_item;
}
if ($__foreach_line_14_saved_item) {
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_14_saved_item;
}
?>
			<?php } else { ?>
				No downloads attached to this menu
			<?php }?>
		</fieldset>
	</div>
	
   <?php if (isset($_smarty_tpl->tpl_vars['osd_message']->value)) {?>
		[BRK]<?php echo $_smarty_tpl->tpl_vars['osd_message']->value;?>

	<?php }?>
	
<?php }?>


<?php if (isset($_smarty_tpl->tpl_vars['smarty_action']->value) && $_smarty_tpl->tpl_vars['smarty_action']->value == "ind_gen_browse") {?>
	<select id="ind_id" name="ind_id">
		<?php
$_from = $_smarty_tpl->tpl_vars['author_type']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_line_15_saved_item = isset($_smarty_tpl->tpl_vars['line']) ? $_smarty_tpl->tpl_vars['line'] : false;
$_smarty_tpl->tpl_vars['line'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['line']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['line']->value) {
$_smarty_tpl->tpl_vars['line']->_loop = true;
$__foreach_line_15_saved_local_item = $_smarty_tpl->tpl_vars['line'];
?>
			<option value="<?php echo $_smarty_tpl->tpl_vars['line']->value['ind_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['line']->value['ind_name'];?>
</option>
		<?php
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_15_saved_local_item;
}
if ($__foreach_line_15_saved_item) {
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_15_saved_item;
}
?>
	</select>
<?php }?>

				
<?php if (isset($_smarty_tpl->tpl_vars['smarty_action']->value) && $_smarty_tpl->tpl_vars['smarty_action']->value == "update_menu_disk_credits") {?>
    <br>
    <br>
	<table class="table_game_list" style="width:95%;border: solid 1px black;margin:auto;">
		<tr>
			<th id="menu_cred_th">Credits</th>
			<th id="menu_scene_th">"Sceners"</th>
			<th id="menu_nick_th">Nick</th>
			<th id="menu_delete_th">
				<div class="help-tip">
					<p style="right:260px;">The intro of a menu disk was a lot of times coded by different people than the actual menu itself. You can add them by pressing the 'add intro credits' above. Once an individual is added, you can select his/her nickname. As some people used different nicks for different menu's.</p>
				</div>
			</th>
		</tr>
		<?php if (isset($_smarty_tpl->tpl_vars['individuals']->value)) {?>
			<?php
$_from = $_smarty_tpl->tpl_vars['individuals']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_outer_16_saved_item = isset($_smarty_tpl->tpl_vars['individual']) ? $_smarty_tpl->tpl_vars['individual'] : false;
$_smarty_tpl->tpl_vars['individual'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['individual']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['individual']->value) {
$_smarty_tpl->tpl_vars['individual']->_loop = true;
$__foreach_outer_16_saved_local_item = $_smarty_tpl->tpl_vars['individual'];
?>	
				<tr>
					<td class="menu_cred_td"><?php echo $_smarty_tpl->tpl_vars['individual']->value['author_type_info'];?>
</td>
					<td class="menu_scene_td"><a href="../individuals/individuals_edit.php?ind_id=<?php echo $_smarty_tpl->tpl_vars['individual']->value['ind_id'];?>
" class="standard_table_left"><?php echo $_smarty_tpl->tpl_vars['individual']->value['ind_name'];?>
</a></td>
					<form action="#" method="post" name="nick_edit<?php echo $_smarty_tpl->tpl_vars['individual']->value['ind_id'];?>
" id="nick_edit<?php echo $_smarty_tpl->tpl_vars['individual']->value['ind_id'];?>
">
						<td class="menu_nick_td">
							<select name="individual_nicks_id" id="quick_search_small_select" style="width:125px;" onchange="ChangeNick(this.value,<?php echo $_smarty_tpl->tpl_vars['individual']->value['menu_disk_credits_id'];?>
,<?php echo $_smarty_tpl->tpl_vars['individual']->value['menu_disk_id'];?>
)">
								<option value="" selected>-</option>
								<?php
$_from = $_smarty_tpl->tpl_vars['ind_nick']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_line_17_saved_item = isset($_smarty_tpl->tpl_vars['line']) ? $_smarty_tpl->tpl_vars['line'] : false;
$_smarty_tpl->tpl_vars['line'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['line']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['line']->value) {
$_smarty_tpl->tpl_vars['line']->_loop = true;
$__foreach_line_17_saved_local_item = $_smarty_tpl->tpl_vars['line'];
?>	
									<?php if ($_smarty_tpl->tpl_vars['line']->value['ind_id'] == $_smarty_tpl->tpl_vars['individual']->value['ind_id']) {?>
										<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['line']->value['individual_nicks_id'],'output'=>$_smarty_tpl->tpl_vars['line']->value['nick'],'selected'=>$_smarty_tpl->tpl_vars['individual']->value['individual_nicks_id']),$_smarty_tpl);?>

									<?php }?>
								<?php
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_17_saved_local_item;
}
if ($__foreach_line_17_saved_item) {
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_17_saved_item;
}
?>
							</select>
						</td>
					</form>		
					<td class="menu_delete_td" style="text-align:right;">
						<input type="button" onclick="DeleteCredits(<?php echo $_smarty_tpl->tpl_vars['individual']->value['menu_disk_credits_id'];?>
,<?php echo $_smarty_tpl->tpl_vars['individual']->value['menu_disk_id'];?>
)" class="quick_search_games_button" value="delete" style="margin-right:5px;">
					</td>
				</tr>
			<?php
$_smarty_tpl->tpl_vars['individual'] = $__foreach_outer_16_saved_local_item;
}
if ($__foreach_outer_16_saved_item) {
$_smarty_tpl->tpl_vars['individual'] = $__foreach_outer_16_saved_item;
}
?>
		<?php }?>
	</table>
<?php }?>


<?php if (isset($_smarty_tpl->tpl_vars['smarty_action']->value) && $_smarty_tpl->tpl_vars['smarty_action']->value == "add_chain_to_menu_return") {?>
	<?php if (isset($_smarty_tpl->tpl_vars['game']->value)) {?>
	<div id="menu_software_list">
		<table class="table_game_list" style="width:95%;border: solid 1px black;margin:auto;">
		<tr>
			<th id="menu_mark_th"></th>
			<th id="menu_gamename_th">Software Name</th>
			<th id="menu_gamedev_th">Developer</th>
			<th id="menu_gameyear_th">Year</th>
			<th id="menu_gameinfo_th">Info</th>
			<th id="menu_gameset_th">Set</th>
		</tr>
		<?php
$_from = $_smarty_tpl->tpl_vars['game']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_line_18_saved_item = isset($_smarty_tpl->tpl_vars['line']) ? $_smarty_tpl->tpl_vars['line'] : false;
$_smarty_tpl->tpl_vars['line'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['line']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['line']->value) {
$_smarty_tpl->tpl_vars['line']->_loop = true;
$__foreach_line_18_saved_local_item = $_smarty_tpl->tpl_vars['line'];
?>
			<tr class="table_game_list">
				<td class="menu_mark_td">
					<form name="MenuDiskContent" id="MenuDiskContent">
					<input type="checkbox" id="menu_disk_title_id<?php echo $_smarty_tpl->tpl_vars['line']->value['menu_disk_title_id'];?>
" name="menu_disk_title_id[]" value="<?php echo $_smarty_tpl->tpl_vars['line']->value['menu_disk_title_id'];?>
" onchange="deleteGamefromMenu(<?php echo $_smarty_tpl->tpl_vars['line']->value['menu_disk_title_id'];?>
,<?php echo $_smarty_tpl->tpl_vars['menu_disk_id']->value;?>
)">
				</td>
				<td class="menu_gamename_td">
					<?php if ($_smarty_tpl->tpl_vars['line']->value['game_name'] != '') {?>
						<?php if ($_smarty_tpl->tpl_vars['line']->value['menu_types_text'] == 'Game') {?><a href="../games/games_detail.php?game_id=<?php echo $_smarty_tpl->tpl_vars['line']->value['game_id'];?>
" class="standard_table_left"><?php echo $_smarty_tpl->tpl_vars['line']->value['game_name'];
if ($_smarty_tpl->tpl_vars['line']->value['set_chain'] != '') {?> - <a onclick="popAddSet(<?php echo $_smarty_tpl->tpl_vars['line']->value['menu_disk_title_id'];?>
,<?php echo $_smarty_tpl->tpl_vars['menu_disk_id']->value;?>
,'<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['line']->value['game_name']);?>
')" style="cursor: pointer;" class="standard_tile_link"><i>Part <?php echo $_smarty_tpl->tpl_vars['line']->value['set_chain'];?>
</i></a><?php }?></a><?php } else { ?><a href="../administration/construction.php" class="standard_table_left"><?php echo $_smarty_tpl->tpl_vars['line']->value['game_name'];?>
</a><?php }?>
					<?php } else { ?>
						<i>n/a</i>
					<?php }?>
				</td>
				<td class="menu_gamedev_td">
					<?php if ($_smarty_tpl->tpl_vars['line']->value['developer_name'] != '') {?>	
						<?php if ($_smarty_tpl->tpl_vars['line']->value['menu_types_text'] == 'Game') {?>					
							<a href="../company/company_edit.php?comp_id=<?php echo $_smarty_tpl->tpl_vars['line']->value['developer_id'];?>
" class="standard_table_left"><?php echo $_smarty_tpl->tpl_vars['line']->value['developer_name'];?>
</a>
						<?php } else { ?>
							<a href="../administration/construction.php" class="standard_table_left"><?php echo $_smarty_tpl->tpl_vars['line']->value['developer_name'];?>
</a>
						<?php }?>
					<?php } else { ?>
						<i>n/a</i>
					<?php }?></td>				
				<td class="menu_gameyear_td">
					<?php if ($_smarty_tpl->tpl_vars['line']->value['year'] != '') {?>
						<?php if ($_smarty_tpl->tpl_vars['line']->value['menu_types_text'] == 'Game') {?>
							<a href="../games/games_list.php?year=<?php echo $_smarty_tpl->tpl_vars['line']->value['year'];?>
&amp;action=search" class="standard_table_left">
								<?php echo $_smarty_tpl->tpl_vars['line']->value['year'];?>

							</a>
						<?php } else { ?>
							<a href="../administration/construction.php" class="standard_table_left">
								<?php echo $_smarty_tpl->tpl_vars['line']->value['year'];?>

							</a>
						<?php }?>
					<?php } else { ?>
						<i>n/a</i>
					<?php }?>
				</td>
				<td class="menu_gameinfo_td">
					<?php echo $_smarty_tpl->tpl_vars['line']->value['menu_types_text'];?>

				</td>
				<td class="menu_gameset_td">
					<div id="<?php echo $_smarty_tpl->tpl_vars['line']->value['menu_disk_title_id'];?>
"><a onclick="popAddSet(<?php echo $_smarty_tpl->tpl_vars['line']->value['menu_disk_title_id'];?>
,<?php echo $_smarty_tpl->tpl_vars['menu_disk_id']->value;?>
,'<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['line']->value['game_name']);?>
')" style="cursor: pointer;" class="standard_tile_link">Add</a></div>
				</td>
			</tr>
		<?php
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_18_saved_local_item;
}
if ($__foreach_line_18_saved_item) {
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_18_saved_item;
}
?>
		<tr>
			<td class="game_list_footer" colspan="6">
				<img src="../../../themes/templates/1/includes/img/arrow_ltr.gif" alt="" width="38" height="22"  style="display:inline;">	
				<input type="hidden" name="action" value="delete_from_menu_disk">
				<input type="button" value="Delete" class="quick_search_games_button" style="display:inline;">
				<div class="help-tip" style="margin-bottom:2px;">
					<p style="right:260px;">Overhere you have an overview of the software titles on the menu disk. When pressing the 'add game/tool/demo' button above, a 
					list with search options will appear. Use this list to add titles to the menu. With the 'add' link in the 'set' column, you can CHAIN titles.</p>
				</div>
				</form>
			</td>
		</tr>
		</table>
	<?php }?>
	</div>
	<br>
	<div id="set_chain_update">
	<div class="standard_tile_text">
		<div class="main_company_container">
			<div class="main_company_child" id="child_edit_company">
				<form action="" method="post" name="link_game_to_set" id="link_game_to_set">	
					<fieldset>
					<legend>Select chain <?php if (isset($_smarty_tpl->tpl_vars['title_name']->value)) {?>for <?php echo $_smarty_tpl->tpl_vars['title_name']->value;
}?></legend>
						<select name="chainbrowse" id="quick_search_pub_select">
							<option value="" selected>-</option>
							<?php
$_from = $_smarty_tpl->tpl_vars['chain_data']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_line_19_saved_item = isset($_smarty_tpl->tpl_vars['line']) ? $_smarty_tpl->tpl_vars['line'] : false;
$_smarty_tpl->tpl_vars['line'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['line']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['line']->value) {
$_smarty_tpl->tpl_vars['line']->_loop = true;
$__foreach_line_19_saved_local_item = $_smarty_tpl->tpl_vars['line'];
?>	
								<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['line']->value['menu_disk_title_set_nr'],'output'=>$_smarty_tpl->tpl_vars['line']->value['menu_disk_name'],'selected'=>$_smarty_tpl->tpl_vars['select_chain_data']->value),$_smarty_tpl);?>

							<?php
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_19_saved_local_item;
}
if ($__foreach_line_19_saved_item) {
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_19_saved_item;
}
?>
						</select>
						<input type="text" name="menu_disk_title_set_chain" value="<?php if (isset($_smarty_tpl->tpl_vars['select_chain_nr']->value)) {
echo $_smarty_tpl->tpl_vars['select_chain_nr']->value;
} else { ?>Nr<?php }?>" class="standard_tile_input_small" style="width:5%">
						<br>
						<input type="button" onclick="LinkChain(<?php echo $_smarty_tpl->tpl_vars['menu_disk_title_id']->value;?>
,<?php echo $_smarty_tpl->tpl_vars['menu_disk_id']->value;?>
)" class="topbutton_cpanel_small" value="Link">
						<br>
						<?php if (isset($_smarty_tpl->tpl_vars['select_chain_data']->value)) {?>
							<input type="button" onclick="DeleteChain(<?php echo $_smarty_tpl->tpl_vars['menu_disk_title_id']->value;?>
,<?php echo $_smarty_tpl->tpl_vars['menu_disk_id']->value;?>
,'<?php ob_start();
echo $_smarty_tpl->tpl_vars['title_name']->value;
$_tmp1=ob_get_clean();
echo preg_replace("%(?<!\\\\)'%", "\'",$_tmp1);?>
')" class="topbutton_cpanel_small" value="Delete" style="margin-top:1px;">
						<?php }?>
						<input type="hidden" name="menu_disk_id" value="<?php echo $_smarty_tpl->tpl_vars['menu_disk_id']->value;?>
">
						<input type="hidden" name="menu_disk_title_id" value="<?php echo $_smarty_tpl->tpl_vars['menu_disk_title_id']->value;?>
">
						<input type="hidden" name="action" value="link_game_to_set">
						<br>
						<?php if (isset($_smarty_tpl->tpl_vars['selected_chain_data']->value)) {?>
							<br>
							<b>Titles linked to this chain :</b><br>
							<?php
$_from = $_smarty_tpl->tpl_vars['selected_chain_data']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_line_20_saved_item = isset($_smarty_tpl->tpl_vars['line']) ? $_smarty_tpl->tpl_vars['line'] : false;
$_smarty_tpl->tpl_vars['line'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['line']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['line']->value) {
$_smarty_tpl->tpl_vars['line']->_loop = true;
$__foreach_line_20_saved_local_item = $_smarty_tpl->tpl_vars['line'];
?>
								<?php echo $_smarty_tpl->tpl_vars['line']->value['menu_disk_name'];?>
<br>
							<?php
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_20_saved_local_item;
}
if ($__foreach_line_20_saved_item) {
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_20_saved_item;
}
?>
						<?php }?>
						<br>
						<div class="help-tip">
							<p style="right:230px;">Overhere you can select an existing CHAIN for this title (on this menu set). If the chain for this title does not yet exist, press the 'CREATE' button in the 'create chain' section.
							If the chain exist, fill in the correct 'part nr' in the NR field and hit 'LINK'. Once a title is linked to a chain, the part nr will appear in the list above.</p>
						</div>
					</fieldset>
				</form>
			</div>
			<div class="main_company_child" id="child_edit_company">
				<form action="" method="get" name="set_add_to_menu" id="set_add_to_menu">	
					<fieldset>
					<legend>Create chain <?php if (isset($_smarty_tpl->tpl_vars['title_name']->value)) {?>for <?php echo $_smarty_tpl->tpl_vars['title_name']->value;
}?></legend>
						<input type="button" onclick="CreateChain(<?php echo $_smarty_tpl->tpl_vars['menu_disk_title_id']->value;?>
,<?php echo $_smarty_tpl->tpl_vars['menu_disk_id']->value;?>
)" class="topbutton_cpanel_small" value="Create">
						<div class="help-tip">
							<p style="right:220px;">In this box you create a CHAIN for this title. <b>BE AWARE</b>, before creating a new chain for a title, make sure the chain 
							does not already exist for this menu set. Check the dropdown in the 'select chain' section before creating a new one.</p>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
	</div>
	<?php if (isset($_smarty_tpl->tpl_vars['osd_message']->value)) {?>
		[BRK]<?php echo $_smarty_tpl->tpl_vars['osd_message']->value;?>

	<?php }?>
			
<?php }
}
}

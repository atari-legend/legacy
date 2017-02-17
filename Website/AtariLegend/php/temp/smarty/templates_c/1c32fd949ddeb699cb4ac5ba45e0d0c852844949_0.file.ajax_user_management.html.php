<?php
/* Smarty version 3.1.29, created on 2017-01-21 14:29:44
  from "/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/admin/ajax_user_management.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_58837058ac4d48_92066331',
  'file_dependency' => 
  array (
    '1c32fd949ddeb699cb4ac5ba45e0d0c852844949' => 
    array (
      0 => '/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/admin/ajax_user_management.html',
      1 => 1484337716,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58837058ac4d48_92066331 ($_smarty_tpl) {
?>


    <?php if (isset($_smarty_tpl->tpl_vars['users']->value)) {?>
        <table class="standard_table_list">
            <tr>
                <th><input type="checkbox" name="user_select_all" id="user_select_all" class="quick_search_check">All</th>
                <th class="username_th">User Name</th>
                <th class="joindate_th">Join Date</th>
                <th class="lastvisit_th">Last Visit</th>
                <th class="email_th">Email</th>

            </tr>
            <?php
$_from = $_smarty_tpl->tpl_vars['users']->value;
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
            <tr>
                <td class="select_td"><input type="checkbox" name="user_id[]" value="<?php echo $_smarty_tpl->tpl_vars['line']->value['user_id'];?>
" class="user_checkbox"></td>
                <td class="username_td"><a class="standard_table_center user_popup fancybox.ajax" href="../administration/user_detail.php?user_id_selected=<?php echo $_smarty_tpl->tpl_vars['line']->value['user_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['line']->value['user_name'];?>
</a></td>
                <td class="joindate_td"><?php if ($_smarty_tpl->tpl_vars['line']->value['join_date'] != '') {
echo $_smarty_tpl->tpl_vars['line']->value['join_date'];
} else { ?><i>n/a</i><?php }?></td>
                <td class="lastvisit_td"><?php if ($_smarty_tpl->tpl_vars['line']->value['last_visit'] != '') {
echo $_smarty_tpl->tpl_vars['line']->value['last_visit'];
} else { ?><i>n/a</i><?php }?></td>
                <td class="email_td"><?php if ($_smarty_tpl->tpl_vars['line']->value['email'] != '') {?><a href="mailto:<?php echo $_smarty_tpl->tpl_vars['line']->value['email'];?>
" class="standard_tile_link_black">M</a><?php } else { ?><i>n/a</i><?php }?></td>
            </tr>
            <?php
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_0_saved_local_item;
}
if ($__foreach_line_0_saved_item) {
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_0_saved_item;
}
?>
            <?php } else { ?>
                <div class="left_nav_section">No users found</div>
            <?php }?>
            <?php if (isset($_smarty_tpl->tpl_vars['nr_users']->value)) {?>
            <tr>
                <td class="standard_table_left" colspan="5">
                    <img width="38" height="22" style="float:left;" alt="" src="../../../themes/templates/1/includes/img/arrow_ltr.gif">
                        <select name="action" id="user_list_action">
                            <option value="-" selected>Select Action</option>
                            <?php if (isset($_smarty_tpl->tpl_vars['mail_link']->value)) {?>
                                <option value="email_user">Send Email</option>
                            <?php }?>
                            <option value="deactivate_user">Deactivate User</option>
                            <?php if (isset($_smarty_tpl->tpl_vars['delete_link']->value)) {?>
                                <option value="delete_user">Delete User</option>
                            <?php }?>
                        </select>
                    <b>Found <?php if ($_smarty_tpl->tpl_vars['nr_users']->value != '') {
echo $_smarty_tpl->tpl_vars['nr_users']->value;
} else { ?>0<?php }?> users in <?php echo $_smarty_tpl->tpl_vars['query_time']->value;?>
 sec</b>
                </td>
            </tr>
            <?php }?>
        </table>



<?php }
}

<?php
/* Smarty version 3.1.29, created on 2017-01-21 14:29:34
  from "/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/admin/quick_search_users.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_5883704ebba2e5_09121506',
  'file_dependency' => 
  array (
    '38796f02abf22f856dafabfc8ae80ec5563e5953' => 
    array (
      0 => '/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/admin/quick_search_users.html',
      1 => 1484337716,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5883704ebba2e5_09121506 ($_smarty_tpl) {
if (!is_callable('smarty_function_html_options')) require_once '/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/php/vendor/smarty/smarty/libs/plugins/function.html_options.php';
if (!is_callable('smarty_function_html_select_date')) require_once '/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/php/vendor/smarty/smarty/libs/plugins/function.html_select_date.php';
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, false);
?>

<?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'quick_search_users', array (
  0 => 'block_996668615883704ebb5cf4_13739114',
  1 => false,
  3 => 0,
  2 => 0,
));
?>

<?php }
/* {block 'quick_search_users'}  file:1/admin/quick_search_users.html */
function block_996668615883704ebb5cf4_13739114($_smarty_tpl, $_blockParentStack) {
?>


<div class="standard_tile">
    <h1>USER SEARCH</h1>
    <div class="standard_tile_line"></div>
    <br>
    <form action="" id="user_search" name="user_search" >
        <div class="standard_table_center">
            <h3>User search options:</h3>   <br>
            <div class="standard_table_center">
                By name :<br>
                <select name="userbrowse" id="quick_search_small_select">
                    <option value="" SELECTED>-</option>
                    <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['az_value']->value,'output'=>$_smarty_tpl->tpl_vars['az_output']->value),$_smarty_tpl);?>

                </select>
                <input type="text" name="usersearch" value="" class="standard_tile_input_small" id="js_user_search">
            </div>
            <br>
            <br>
            <br>
            <div id="quick_search_options" class="standard_table_left">
                <div style="display:table-row;">
                    <div style="display:table-cell;font-weight:bold;vertical-align:middle;"><input type="checkbox" name="no_comments"  id="no_comments" value="1" class="quick_search_check">
                        No Comments&nbsp;
                    </div>
                </div>
                <div style="display:table-row;">
                    <div style="display:table-cell;font-weight:bold;vertical-align:middle;"><input type="checkbox" name="no_submissions" id="no_submissions" value="1" class="quick_search_check">
                        No Submissions&nbsp;
                    </div>
                </div>
                <div style="display:table-row;">
                    <div style="display:table-cell;font-weight:bold;vertical-align:middle;"><input type="checkbox" name="no_email" id="no_email" value="1" class="quick_search_check">
                        No Email
                    </div>
                </div>
                <div style="display:table-row;">
                    <div style="display:table-cell;font-weight:bold;vertical-align:middle;"><input type="checkbox" name="no_news" id="no_news" value="1" class="quick_search_check">
                        No News posts&nbsp;
                    </div>
                </div>
                <div style="display:table-row;">
                    <div style="display:table-cell;font-weight:bold;vertical-align:middle;"><input type="checkbox" name="no_links" id="no_links" value="1" class="quick_search_check">
                        No Link submissions&nbsp;
                    </div>
                </div>
                <div style="display:table-row;">
                    <div style="display:table-cell;font-weight:bold;vertical-align:middle;"><input type="checkbox" name="no_interviews" id="no_interviews" value="1" class="quick_search_check">
                        No Interviews&nbsp;
                    </div>
                </div>
                <div style="display:table-row;">
                    <div style="display:table-cell;font-weight:bold;vertical-align:middle;"><input type="checkbox" name="no_review" id="no_review" value="1" class="quick_search_check">
                        No Review&nbsp;
                    </div>
                </div>
                <div style="display:table-row;">
                    <div style="display:table-cell;font-weight:bold;vertical-align:middle;"><input type="checkbox" name="not_admin" id="not_admin" value="1" class="quick_search_check">
                        Not AL Administrator&nbsp;
                    </div>
                </div>
                <div style="display:table-row;">
                    <div style="display:table-cell;font-weight:bold;vertical-align:middle;"><input type="checkbox" name="with_comments" id="with_comments" value="1" class="quick_search_check">
                        With Comments&nbsp;
                    </div>
                </div>
                <div style="display:table-row;">
                    <div style="display:table-cell;font-weight:bold;vertical-align:middle;"><input type="checkbox" name="with_submissions" id="with_submissions" value="1" class="quick_search_check">
                        With Submissions&nbsp;
                    </div>
                </div>
                <div style="display:table-row;">
                    <div style="display:table-cell;font-weight:bold;vertical-align:middle;"><input type="checkbox" name="with_email" id="with_email" value="1" class="quick_search_check">
                        With Email&nbsp;
                    </div>
                </div>
                <div style="display:table-row;">
                    <div style="display:table-cell;font-weight:bold;vertical-align:middle;"><input type="checkbox" name="with_news" id="with_news" value="1" class="quick_search_check">
                        With News posts&nbsp;
                    </div>
                </div>
                <div style="display:table-row;">
                    <div style="display:table-cell;font-weight:bold;vertical-align:middle;"><input type="checkbox" name="with_links" id="with_links" value="1" class="quick_search_check">
                        With Link Submissions&nbsp;
                    </div>
                </div>
                <div style="display:table-row;">
                    <div style="display:table-cell;font-weight:bold;vertical-align:middle;"><input type="checkbox" name="with_interviews" id="with_interviews" value="1" class="quick_search_check">
                        With Interviews&nbsp;
                    </div>
                </div>
                <div style="display:table-row;">
                    <div style="display:table-cell;font-weight:bold;vertical-align:middle;"><input type="checkbox" name="with_review" id="with_review" value="1" class="quick_search_check">
                        With Review&nbsp;
                    </div>
                </div>
                <div style="display:table-row;">
                    <div style="display:table-cell;font-weight:bold;vertical-align:middle;"><input type="checkbox" name="is_admin" id="is_admin" value="1" class="quick_search_check">
                        Is AL Administrator&nbsp;
                    </div>
                </div>
                <div style="display:table-row;">
                    <div style="display:table-cell;font-weight:bold;vertical-align:middle;"><input type="checkbox" name="last_visit" id="last_visit" value="1" class="quick_search_check">
                        Last visit before<?php echo smarty_function_html_select_date(array('start_year'=>'2003','end_year'=>'+1'),$_smarty_tpl);?>

                    </div>
                </div>
            </div>
            <br>
            <input type="hidden" name="action" id="action_ajax_search" value="users">
            <br><br>
            <hr>
        </div>
    </form>
</div>
<?php
}
/* {/block 'quick_search_users'} */
}

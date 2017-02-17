<?php
/* Smarty version 3.1.29, created on 2017-01-21 14:29:41
  from "/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/admin/user_management.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_58837055997165_99562803',
  'file_dependency' => 
  array (
    '6e15f2696793c573996850a2e92a137f3d85c3ff' => 
    array (
      0 => '/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/admin/user_management.html',
      1 => 1484337716,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:1/admin/frontpage.html' => 1,
    'file:1/admin/quick_search_users.html' => 1,
    'file:1/admin/left_nav.html' => 1,
    'file:1/admin/quick_search_games.html' => 1,
  ),
),false)) {
function content_58837055997165_99562803 ($_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, true);
?>




<!-- <div class="standard_tile" id="<?php echo $_smarty_tpl->tpl_vars['left_nav']->value;?>
">
    <h1>ADMIN NAVIGATION</h1>
        <div class="standard_tile_line"></div>
        <div class="standard_list_entry">
            <div class="standard_tile_text">
                <ul class="standard_table_list">
                    <li class="left_nav_section">Administration Sections</li>

                    <li><a href="../administration/database_update.php" class="left_nav_link">Database Update</a></li>
                    <li><a href="../administration/construction.php" class="left_nav_link">Website Settings</a></li>
                    <li><a href="../administration/construction.php" class="left_nav_link">Website Themes</a></li>
                    <li><a href="../administration/user_management.php" class="left_nav_link">User Management</a></li>

                </ul>
            </div>
        </div>
    <div class="standard_tile_line"></div>
</div> -->


<?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'java_script', array (
  0 => 'block_2082652736588370559634e9_90673750',
  1 => false,
  3 => 0,
  2 => 0,
));
?>


<?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'left_tile', array (
  0 => 'block_16708604225883705596f3d9_67801195',
  1 => false,
  3 => 0,
  2 => 0,
));
?>


<?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'right_tile', array (
  0 => 'block_80457388058837055972204_97096683',
  1 => false,
  3 => 0,
  2 => 0,
));
?>


<?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'main_tile', array (
  0 => 'block_190449501258837055974560_18470672',
  1 => false,
  3 => 0,
  2 => 0,
));
?>

<?php $_smarty_tpl->ext->_inheritance->endChild($_smarty_tpl);
$_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:1/admin/frontpage.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block 'java_script'}  file:../../../themes/templates/1/admin/user_management.html */
function block_2082652736588370559634e9_90673750($_smarty_tpl, $_blockParentStack) {
?>

<?php echo '<script'; ?>
 type="text/javascript">
$(document).ready(function() {

function UserSearch() {

    var form_values = $( "#user_search" ).serialize();

    $.ajax({

    // The URL for the request
    url: "ajax_user_management.php",

    // The data to send (will be converted to a query string)
    data: form_values,

    // Whether this is a POST or GET request
    type: "GET",

    // The type of data we expect back
   dataType : "html",

    // Code to run if the request succeeds;
    // the response is passed to the function
    success: function( html ) {
        $( "#ajax_usersearch" ).html( html );
    }
    });
}

    $( "#quick_search_small_select" ).change(function () { UserSearch(); });
    $( "#js_user_search" ).keyup(function () {
        var value = $(this).val();
        if (value.length >= 3 || value == "") {
            UserSearch();
        }
    });
    $( "#no_comments" ).change(function () {
        if ($(this).is(':checked')) { $("#with_comments").prop("checked", false);}
        UserSearch();
    });
    $( "#with_comments" ).change(function () {
        if ($(this).is(':checked')) { $("#no_comments").prop("checked", false);}
        UserSearch();
    });
    $( "#no_submissions" ).change(function () {
        if ($(this).is(':checked')) { $("#with_submissions").prop("checked", false);}
        UserSearch();
    });
    $( "#with_submissions" ).change(function () {
        if ($(this).is(':checked')) { $("#no_submissions").prop("checked", false);}
        UserSearch();
    });
    $( "#no_email" ).change(function () {
        if ($(this).is(':checked')) { $("#with_email").prop("checked", false);}
        UserSearch();
    });
    $( "#with_email" ).change(function () {
        if ($(this).is(':checked')) { $("#no_email").prop("checked", false);}
        UserSearch();
    });
    $( "#no_news" ).change(function () {
        if ($(this).is(':checked')) { $("#with_news").prop("checked", false);}
        UserSearch();
    });
    $( "#with_news" ).change(function () {
        if ($(this).is(':checked')) { $("#no_news").prop("checked", false);}
        UserSearch();
    });
    $( "#no_links" ).change(function () {
        if ($(this).is(':checked')) { $("#with_links").prop("checked", false);}
        UserSearch();
    });
    $( "#with_links" ).change(function () {
     if ($(this).is(':checked')) { $("#no_links").prop("checked", false);}
        UserSearch();
    });
    $( "#no_interviews" ).change(function () {
        if ($(this).is(':checked')) { $("#with_interviews").prop("checked", false);}
        UserSearch();
    });
    $( "#with_interviews" ).change(function () {
        if ($(this).is(':checked')) { $("#no_interviews").prop("checked", false);}
        UserSearch();
    });
    $( "#no_review" ).change(function () {
        if ($(this).is(':checked')) { $("#with_review").prop("checked", false);}
        UserSearch();
    });
    $( "#with_review" ).change(function () {
        if ($(this).is(':checked')) { $("#no_review").prop("checked", false);}
        UserSearch();
    });
    $( "#not_admin" ).change(function () {
        if ($(this).is(':checked')) { $("#is_admin").prop("checked", false);}
        UserSearch();
    });
    $( "#is_admin" ).change(function () {
        if ($(this).is(':checked')) { $("#not_admin").prop("checked", false);}
        UserSearch();
    });
    $( "#last_visit" ).change(function () {
        UserSearch();
    });

});

$( document ).ajaxComplete(function() {
  UserlistFunction();

});

$(document).ready(function() {
    UserlistFunction();

});


function UserlistFunction() {

            // select all checkboxes in list
    $( '#user_select_all' ).click(function () {
         $('.user_checkbox').prop('checked', $(this).prop('checked'));
    });


        // Are you sure question Delete
    $( "#user_list_action" ).change(function () {

         if ($(this).val() == "delete_user") {
                 $( "#dialog_confirm_delete" ).dialog({
                    resizable: false,
                    height:140,
                    modal: true,
                    buttons: {
                        "Delete user(s)": function() {
                        $( this ).dialog( "close" );
                        UserModify();
                        },
                        Cancel: function() {
                        $( this ).dialog( "close" );
                        }
                    }
                });
        }
         if ($(this).val() == "deactivate_user") {
                 $( "#dialog_confirm_deactivate" ).dialog({
                    resizable: false,
                    height:140,
                    modal: true,
                    buttons: {
                        "Deactivate user(s)": function() {
                        $( this ).dialog( "close" );
                        UserModify();
                        },
                        Cancel: function() {
                        $( this ).dialog( "close" );
                        }
                    }
                });
        }

        if ($(this).val() == "email_user") {

                // $( "#dialog_confirm_email" ).dialog({
                //  resizable: false,
                //  height:140,
                //  modal: true,
                //  buttons: {
                //      "Email user(s)": function() {
                //      $( this ).dialog( "close" );
                //      UserModify();
                //      },
                //      Cancel: function() {
                //      $( this ).dialog( "close" );
                //      }
                //  }
                //});
                 document.getElementById('email_fields').style.visibility = 'visible';

        }
    });


}

function UserModify() {

    // var form_values = $( "#user_list" ).serialize();

    // $.ajax({

    // The URL for the request
    // url: "db_user_management.php",

    // The data to send (will be converted to a query string)
    // data: form_values,

    // Whether this is a POST or GET request
    // type: "POST",

    // The type of data we expect back
    // dataType : "text",

    // Code to run if the request succeeds;
    // the response is passed to the function
    // success: function( text ) {

        // $.notify_osd.create({
                // 'text'        : text,             // notification message
                // 'icon'        : '<?php echo $_smarty_tpl->tpl_vars['style_dir']->value;?>
/images/osd_icons/star.png', // icon path, 48x48
                // 'sticky'      : false,             // if true, timeout is ignored
                // 'timeout'     : 4,                 // disappears after 6 seconds
                // 'dismissable' : true               // can be dismissed manually
                // });

        //Reload userlist
            // var form_values = $( "#user_search" ).serialize();

        // $.ajax({

        // The URL for the request
        // url: "ajax_user_management.php",

        // The data to send (will be converted to a query string)
        // data: form_values,

        // Whether this is a POST or GET request
        // type: "GET",

        // The type of data we expect back
        // dataType : "html",

        // Code to run if the request succeeds;
        // the response is passed to the function
        // success: function( html ) {
        // $( "#ajax_usersearch" ).html( html );
        // }
            // });
    // }
    // });

    document.getElementById('user_list').method="post";
    document.getElementById('user_list').action="../administration/db_user_management.php?action=delete_user";
    document.getElementById('user_list').submit();
}

 $(document).ready(function() {
  $(".user_popup").fancybox({
      maxWidth    : 900,
      maxHeight   : 600,
      fitToView   : true,
      width       : '70%',
      height      : '70%',
      autoSize    : true,
      closeClick  : false,
      openEffect  : 'elastic',
      closeEffect : 'elastic'
  });
});
<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
function EmailSent(){
   $( "#dialog_confirm_email" ).dialog({
        resizable: false,
        height:140,
        modal: true,
        buttons: {
            "Email user(s)": function() {
            $( this ).dialog( "close" );
            document.getElementById('user_list').method="post";
            document.getElementById('user_list').action="../administration/db_user_management.php?action=email_user";
            document.getElementById('user_list').submit();
            },
            Cancel: function() {
            $( this ).dialog( "close" );
            }
        }
    });
}
<?php echo '</script'; ?>
>
<?php
}
/* {/block 'java_script'} */
/* {block 'left_tile'}  file:../../../themes/templates/1/admin/user_management.html */
function block_16708604225883705596f3d9_67801195($_smarty_tpl, $_blockParentStack) {
?>

    <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:1/admin/quick_search_users.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

    <br>
    <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:1/admin/left_nav.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php
}
/* {/block 'left_tile'} */
/* {block 'right_tile'}  file:../../../themes/templates/1/admin/user_management.html */
function block_80457388058837055972204_97096683($_smarty_tpl, $_blockParentStack) {
?>

    <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:1/admin/quick_search_games.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php
}
/* {/block 'right_tile'} */
/* {block 'main_tile'}  file:../../../themes/templates/1/admin/user_management.html */
function block_190449501258837055974560_18470672($_smarty_tpl, $_blockParentStack) {
?>

<div id="dialog_confirm_delete" title="Delete Users?" style="display:none;">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
  These users will be permanently deleted. Are you sure?</p>
</div>
<div id="dialog_confirm_deactivate" title="Deactivate Users?" style="display:none;">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
  These users will be deactivated. Are you sure?</p>
</div>
<div id="dialog_confirm_email" title="Email Users?" style="display:none;">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
  Email users?</p>
</div>
<div class="standard_tile" id="user_management">
    <h1>USER MANAGEMENT</h1>
    <div class="standard_tile_line"></div>
    <div class="standard_tile_text">
        <div class="left_nav_section">
            Deleting users - You can only delete users if all the 'No' checks are activated in your search.<br>
            Email users - You can only email users if the 'with email' check is activated in your search.
        </div>
        <br>
        <form action="test" name="user_list" id="user_list">
        <div class="main_stats_container" id="ajax_usersearch">
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
                    <!-- <td class="username_td"><?php if ($_smarty_tpl->tpl_vars['line']->value['user_name'] != '') {?><a href="../user/user_detail.php?user_id_selected=<?php echo $_smarty_tpl->tpl_vars['line']->value['user_id'];?>
" class="standard_table_center"><?php echo $_smarty_tpl->tpl_vars['line']->value['user_name'];?>
</a><?php } else { ?><i>n/a</i><?php }?></td> -->
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
        </div>
    </div>
</div>
<?php if (isset($_smarty_tpl->tpl_vars['mail_link']->value)) {?>
    <div class="standard_tile_text" id="email_fields" style="visibility:hidden">
        <fieldset>
            <legend>Create email</legend>
            <input type="text" name="email_head" id="email_head" class="standard_tile_input_small" Value="Email title">
            <br>
            <textarea name="email_descr" id="email_descr" class="links_addnew_area">Email description</textarea>
            <br>
            <br>
            <input type="button" onclick="EmailSent()" name="email_sent" value="Sent" class="topbutton_cpanel_small">
        </fieldset>
    </div>
<?php }?>
</form>
<?php
}
/* {/block 'main_tile'} */
}

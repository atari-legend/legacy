<?php
/* Smarty version 3.1.29, created on 2017-01-21 14:26:57
  from "/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/admin/menus_disk_list.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_58836fb1998883_02784121',
  'file_dependency' => 
  array (
    'e98839002de8f43d1043dc6f37931397ec0a77df' => 
    array (
      0 => '/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/admin/menus_disk_list.html',
      1 => 1484514352,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:1/admin/frontpage.html' => 1,
    'file:1/admin/left_nav.html' => 1,
  ),
),false)) {
function content_58836fb1998883_02784121 ($_smarty_tpl) {
if (!is_callable('smarty_function_html_options')) require_once '/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/php/vendor/smarty/smarty/libs/plugins/function.html_options.php';
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'java_script', array (
  0 => 'block_132505375458836fb1936b06_78526482',
  1 => false,
  3 => 0,
  2 => 0,
));
?>


<?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'title', array (
  0 => 'block_149234561258836fb1962206_79809981',
  1 => false,
  3 => 0,
  2 => 0,
));
?>


<?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'left_tile', array (
  0 => 'block_204312997058836fb1963208_57990243',
  1 => false,
  3 => 0,
  2 => 0,
));
?>


<?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'main_tile', array (
  0 => 'block_190938217958836fb1984726_54025319',
  1 => false,
  3 => 0,
  2 => 0,
));
?>

<?php $_smarty_tpl->ext->_inheritance->endChild($_smarty_tpl);
$_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:1/admin/frontpage.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block 'java_script'}  file:../../../themes/templates/1/admin/menus_disk_list.html */
function block_132505375458836fb1936b06_78526482($_smarty_tpl, $_blockParentStack) {
?>

<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['template_dir']->value;?>
includes/js/lightbox.min.js"><?php echo '</script'; ?>
>
<link type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['style_dir']->value;?>
css/lightbox.css" hreflang="en" rel="stylesheet">

<?php echo '<script'; ?>
 type="text/javascript">
function browseCrew(str) {
    if (str == "") {
        document.getElementById("option_crew").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById("option_crew").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../menus/ajax_menus.php?action=crew_browse&query="+str,true);
        xmlhttp.send();
    }
}

function browseIndividual(str) {
    if (str == "") {
        document.getElementById("option_ind").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById("option_ind").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../menus/ajax_menus.php?action=ind_browse&query="+str,true);
        xmlhttp.send();
    }
}

function addNewdisk(str) {
    if (str == "") {
        document.getElementById("new_disk").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById("new_disk").innerHTML = xmlhttp.responseText;
                document.getElementById("close_new_disk").innerHTML = "<a onclick=\"CloseaddNewdisk("+str+")\" style=\"cursor: pointer;\" class=\"MAINNAV\">Add New Disk</a>";
            }
        }
        xmlhttp.open("GET","../menus/ajax_menus.php?action=add_new_disk_box&menu_sets_id="+str,true);
        xmlhttp.send();
    }
}

function CloseaddNewdisk(str) {
        document.getElementById("new_disk").innerHTML = "";
        document.getElementById("close_new_disk").innerHTML = "<a onclick=\"addNewdisk("+str+")\" style=\"cursor: pointer;\" class=\"MAINNAV\">Add New Disk</a>";
        return;
}


function editDisk(str) {

    var str2 = "diskedit_ajax_";
    var disk_edit_ajax = str2.concat(str);

    if (str == "") {
        document.getElementById(disk_edit_ajax).innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById(disk_edit_ajax).innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../menus/ajax_menus_detail.php?action=edit_disk_box&menu_disk_id="+str,true);
        xmlhttp.send();
    }
}

function CloseeditDisk(str) {

    var str2 = "diskedit_ajax_";
    var disk_edit_ajax = str2.concat(str);

    if (str == "") {
        document.getElementById(disk_edit_ajax).innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById(disk_edit_ajax).innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../menus/ajax_menus_detail.php?action=close_edit_disk_box&menu_disk_id="+str,true);
        xmlhttp.send();
    }
}
function browseInd(str) {
    if (str == "") {
        document.getElementById("ind_member").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("ind_member").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../menus/ajax_menus_detail.php?action=ind_gen_browse&query="+str,true);
        xmlhttp.send();
    }
}

function searchInd(str) {
    if (str == "") {
        str = "empty";
            xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("ind_member").innerHTML = xmlhttp.responseText;
            }
        }

    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("ind_member").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../menus/ajax_menus_detail.php?action=ind_gen_search&query="+str,true);
        xmlhttp.send();
    }
}
function IndDelete(ind_select)
{
            // CONFIRM REQUIRES ONE ARGUMENT
         var message = "Are you sure you want to delete this individual from this menu set?";
         // CONFIRM IS BOOLEAN. THAT MEANS THAT
         // IT RETURNS TRUE IF 'OK' IS CLICKED
         // OTHERWISE IT RETURN FALSE
         var return_value = confirm(message);

         if (return_value !="0")
         {
              url="db_menu_disk.php?menu_sets_id=<?php echo $_smarty_tpl->tpl_vars['menu_set']->value['menu_sets_id'];?>
&ind_id="+ind_select+"&action=delete_ind_from_menu_set";
              location.href=url;
         }
}

function CrewDelete(crew_select)
{
            // CONFIRM REQUIRES ONE ARGUMENT
         var message = "Are you sure you want to delete this crew from this menu set?";
         // CONFIRM IS BOOLEAN. THAT MEANS THAT
         // IT RETURNS TRUE IF 'OK' IS CLICKED
         // OTHERWISE IT RETURN FALSE
         var return_value = confirm(message);

         if (return_value !="0")
         {
              url="db_menu_disk.php?menu_sets_id=<?php echo $_smarty_tpl->tpl_vars['menu_set']->value['menu_sets_id'];?>
&crew_id="+crew_select+"&action=delete_crew_from_menu_set";
              location.href=url;
         }
}

function MenuTypeDelete(menu_type_select)
{
            // CONFIRM REQUIRES ONE ARGUMENT
         var message = "Are you sure you want to delete this menu type from this menu set?";
         // CONFIRM IS BOOLEAN. THAT MEANS THAT
         // IT RETURNS TRUE IF 'OK' IS CLICKED
         // OTHERWISE IT RETURN FALSE
         var return_value = confirm(message);

         if (return_value !="0")
         {
              url="db_menu_disk.php?menu_sets_id=<?php echo $_smarty_tpl->tpl_vars['menu_set']->value['menu_sets_id'];?>
&menu_type_id="+menu_type_select+"&action=delete_menu_type_from_menu_set";
              location.href=url;
         }
}

function popAddIntroCred(str) {
    if (str == "") {
        document.getElementById("menu_detail_expand").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("menu_detail_expand").innerHTML = xmlhttp.responseText;
                document.getElementById("intro_credit_link").innerHTML = "<a onclick=\"closeAddIntroCred("+str+")\" style=\"cursor: pointer;\" class=\"MAINNAV\">Add intro credits</a>";
            }
        }
        xmlhttp.open("GET","../menus/ajax_menus_detail.php?action=add_intro_credit&query="+str,true);
        xmlhttp.send();
    }
}

function closeAddIntroCred(str) {
        document.getElementById("menu_detail_expand").innerHTML = "";
        document.getElementById("intro_credit_link").innerHTML = "<a onclick=\"popAddIntroCred("+str+")\" style=\"cursor: pointer;\" class=\"MAINNAV\">Add intro credits</a>";
        return;
}

function popAddGames(str) {
    if (str == "") {
        document.getElementById("menu_detail_expand_games").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("menu_detail_expand_games").innerHTML = xmlhttp.responseText;
                document.getElementById("gameto_menu_link").innerHTML = "<a onclick=\"closeAddGames("+str+")\" style=\"cursor: pointer;\" class=\"MAINNAV\">Add Game/Tool/Demo to menu</a>";
            }
        }
        xmlhttp.open("GET","../menus/ajax_addgames_menus.php?action=game_browse&list=full&query=num&menu_disk_id="+str,true);
        xmlhttp.send();
    }
}

function closeAddGames(str) {
        document.getElementById("menu_detail_expand_games").innerHTML = "";
        document.getElementById("gameto_menu_link").innerHTML = "<a onclick=\"popAddGames("+str+")\" style=\"cursor: pointer;\" class=\"MAINNAV\">Add Game/Tool/Demo to menu</a>";
        return;
}

function popAddDocs(str) {
    if (str == "") {
        document.getElementById("menu_detail_expand_docs").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("menu_detail_expand_docs").innerHTML = xmlhttp.responseText;
                document.getElementById("docto_menu_link").innerHTML = "<a onclick=\"closeAddDocs("+str+")\" style=\"cursor: pointer;\" class=\"MAINNAV\">Add Doc to menu</a>";
            }
        }
        xmlhttp.open("GET","../menus/ajax_adddocs_menus.php?action=game_browse&list=full&query=num&menu_disk_id="+str,true);
        xmlhttp.send();
    }
}

function closeAddDocs(str) {
        document.getElementById("menu_detail_expand_docs").innerHTML = "";
        document.getElementById("docto_menu_link").innerHTML = "<a onclick=\"popAddDocs("+str+")\" style=\"cursor: pointer;\" class=\"MAINNAV\">Add Doc to menu</a>";
        return;
}

function popAddScreenshots(str) {
    if (str == "") {
        document.getElementById("menu_detail_expand_screenshots").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("menu_detail_expand_screenshots").innerHTML = xmlhttp.responseText;
                document.getElementById("screenshot_link").innerHTML = "<a onclick=\"closeAddScreenshots("+str+")\" style=\"cursor: pointer;\" class=\"MAINNAV\">Add Screenshots to menu</a>";
            }
        }
        xmlhttp.open("GET","../menus/ajax_addscreenshots_menus.php?menu_disk_id="+str,true);
        xmlhttp.send();
    }
}

function closeAddScreenshots(str) {
        document.getElementById("menu_detail_expand_screenshots").innerHTML = "";
        document.getElementById("screenshot_link").innerHTML = "<a onclick=\"popAddScreenshots("+str+")\" style=\"cursor: pointer;\" class=\"MAINNAV\">Add Screenshots to menu</a>";
        return;
}

function popAddFile(str) {
    if (str == "") {
        document.getElementById("menu_detail_expand_file").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("menu_detail_expand_file").innerHTML = xmlhttp.responseText;
                document.getElementById("file_link").innerHTML = "<a onclick=\"closeAddFile("+str+")\" style=\"cursor: pointer;\" class=\"MAINNAV\">Add File to menu</a>";
            }
        }
        xmlhttp.open("GET","../menus/ajax_addfile_menus.php?menu_disk_id="+str,true);
        xmlhttp.send();
    }
}

function closeAddFile(str) {
        document.getElementById("menu_detail_expand_file").innerHTML = "";
        document.getElementById("file_link").innerHTML = "<a onclick=\"popAddFile("+str+")\" style=\"cursor: pointer;\" class=\"MAINNAV\">Add File to menu</a>";
        return;
}

function addslashes( str ) {
    return (str + '').replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0');
}

function popAddSet(str, menu_disk_id, title_name) {
    if (str == "") {
        document.getElementById("menu_detail_expand_set").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("menu_detail_expand_set").innerHTML = xmlhttp.responseText;
                var title = addslashes(title_name);
                document.getElementById(str).innerHTML = "<a onclick=\"closeAddSet("+str+","+menu_disk_id+",'"+title+"')\" style=\"cursor: pointer;\" class=\"standard_tile_link\">Add</a>";
            }
        }

        var elementExists = document.getElementById("set_chain_update");
        if (typeof(elementExists) != 'undefined' && elementExists != null)
        {
            document.getElementById("set_chain_update").innerHTML = "";
        }
        xmlhttp.open("GET","../menus/ajax_addset_menus.php?menu_disk_title_id="+str+"&menu_disk_id="+menu_disk_id+"&title_name="+title_name,true);
        xmlhttp.send();
    }
}

function closeAddSet(str, menu_disk_id, title_name) {
        var title = addslashes(title_name);
        document.getElementById("menu_detail_expand_set").innerHTML = "";
        document.getElementById(str).innerHTML = "<a onclick=\"popAddSet("+str+","+menu_disk_id+",'"+title+"')\" style=\"cursor: pointer;\" class=\"standard_tile_link\">Add</a>";
        return;
}

function browseGame(str,menu_disk_id) {
    if (str == "") {
        document.getElementById("game_list").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("game_list").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../menus/ajax_addgames_menus.php?action=game_browse&list=inner&query="+str+"&menu_disk_id="+menu_disk_id,true);
        xmlhttp.send();
    }
}

function browseDoc(str,menu_disk_id) {
    if (str == "") {
        document.getElementById("doc_list").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("doc_list").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../menus/ajax_adddocs_menus.php?action=game_browse&list=inner&query="+str+"&menu_disk_id="+menu_disk_id,true);
        xmlhttp.send();
    }
}

function searchGame(str,menu_disk_id) {
    if (str == "") {
        str = "empty";
            xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("game_list").innerHTML = xmlhttp.responseText;
            }
        }

    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("game_list").innerHTML = xmlhttp.responseText;
            }
        }
        if (str.length >= 3) {
        xmlhttp.open("GET","../menus/ajax_addgames_menus.php?action=game_search&list=inner&query="+str+"&menu_disk_id="+menu_disk_id,true);
        xmlhttp.send();
    }
    }
}

function searchDoc(str,menu_disk_id) {
    if (str == "") {
        str = "empty";
            xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("doc_list").innerHTML = xmlhttp.responseText;
            }
        }

    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("doc_list").innerHTML = xmlhttp.responseText;
            }
        }
        if (str.length >= 3) {
        xmlhttp.open("GET","../menus/ajax_adddocs_menus.php?action=game_search&list=inner&query="+str+"&menu_disk_id="+menu_disk_id,true);
        xmlhttp.send();
    }
    }
}

function addGametoMenu(software_id,menu_disk_id,software_type) {
 if (software_id == "") {
        document.getElementById("menu_software_list").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

                data = xmlhttp.responseText.split ( "[BRK]" );
                document.getElementById("menu_software_list").innerHTML = data[0];

            $.notify_osd.create({
                'text'        : data[1],             // notification message
                'icon'        : '<?php echo $_smarty_tpl->tpl_vars['style_dir']->value;?>
images/osd_icons/star.png', // icon path, 48x48
                'sticky'      : false,             // if true, timeout is ignored
                'timeout'     : 4,                 // disappears after 6 seconds
                'dismissable' : true               // can be dismissed manually
                });

            document.getElementById("game_add_to_menu").reset();
            }
        }
        xmlhttp.open("GET","../menus/db_menu_disk.php?action=add_title_to_menu&software_id="+software_id+"&menu_disk_id="+menu_disk_id+"&software_type="+software_type,true);
        xmlhttp.send();
    }
}

function addDoctoMenu(software_id,menu_disk_id,software_type) {
 if (software_id == "") {
        document.getElementById("menu_doc_list").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

                data = xmlhttp.responseText.split ( "[BRK]" );
                document.getElementById("menu_doc_list").innerHTML = data[0];

            $.notify_osd.create({
                'text'        : data[1],             // notification message
                'icon'        : '<?php echo $_smarty_tpl->tpl_vars['style_dir']->value;?>
images/osd_icons/star.png', // icon path, 48x48
                'sticky'      : false,             // if true, timeout is ignored
                'timeout'     : 4,                 // disappears after 6 seconds
                'dismissable' : true               // can be dismissed manually
                });

            document.getElementById("doc_add_to_menu").reset();
            }
        }
        xmlhttp.open("GET","../menus/db_menu_disk.php?action=add_doc_to_menu&software_id="+software_id+"&menu_disk_id="+menu_disk_id+"&software_type="+software_type,true);
        xmlhttp.send();
    }
}


function addScreenshottoMenu(menu_disk_id) {
 if (menu_disk_id == "") {
        document.getElementById("menu_screenshot_list").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

                data = xmlhttp.responseText.split ( "[BRK]" );
                document.getElementById("menu_screenshot_list").innerHTML = data[0];

            $.notify_osd.create({
                'text'        : data[1],             // notification message
                'icon'        : '<?php echo $_smarty_tpl->tpl_vars['style_dir']->value;?>
images/osd_icons/star.png', // icon path, 48x48
                'sticky'      : false,             // if true, timeout is ignored
                'timeout'     : 4,                 // disappears after 6 seconds
                'dismissable' : true               // can be dismissed manually
                });

            document.getElementById("screenshot_add_to_menu").reset();
            }
        }

        var formData = new FormData( document.getElementById("screenshot_add_to_menu") );

        xmlhttp.open("POST","../menus/db_menu_disk.php",true);
        xmlhttp.send(formData);
    }
}

function addFiletoMenu(menu_disk_id) {
 if (menu_disk_id == "") {
        document.getElementById("menu_file_list").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

                data = xmlhttp.responseText.split ( "[BRK]" );
                document.getElementById("menu_file_list").innerHTML = data[0];

            $.notify_osd.create({
                'text'        : data[1],             // notification message
                'icon'        : '<?php echo $_smarty_tpl->tpl_vars['style_dir']->value;?>
images/osd_icons/star.png', // icon path, 48x48
                'sticky'      : false,             // if true, timeout is ignored
                'timeout'     : 4,                 // disappears after 6 seconds
                'dismissable' : true               // can be dismissed manually
                });

            document.getElementById("File_add_to_menu").reset();
            }
        }

        var formData = new FormData( document.getElementById("file_add_to_menu") );

        xmlhttp.open("POST","../menus/db_menu_disk.php",true);
        xmlhttp.send(formData);
    }
}

function LinkChain(menu_disk_title_id,menu_disk_id) {
 if (menu_disk_title_id == "") {
        document.getElementById("menu_software_list").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

                data = xmlhttp.responseText.split ( "[BRK]" );
                document.getElementById("menu_software_list").innerHTML = data[0];

            $.notify_osd.create({
                'text'        : data[1],             // notification message
                'icon'        : '<?php echo $_smarty_tpl->tpl_vars['style_dir']->value;?>
images/osd_icons/star.png', // icon path, 48x48
                'sticky'      : false,             // if true, timeout is ignored
                'timeout'     : 4,                 // disappears after 6 seconds
                'dismissable' : true               // can be dismissed manually
                });

             //document.getElementById("link_game_to_set").reset();
            document.getElementById("menu_detail_expand_set").innerHTML = "";
            }
        }

        var formData = new FormData( document.getElementById("link_game_to_set") );

        xmlhttp.open("POST","../menus/db_menu_disk.php",true);
        xmlhttp.send(formData);
    }
}

function DeleteChain(menu_disk_title_id,menu_disk_id,title_name) {
 if (menu_disk_title_id == "") {
        document.getElementById("menu_software_list").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

                data = xmlhttp.responseText.split ( "[BRK]" );
                document.getElementById("menu_software_list").innerHTML = data[0];

            $.notify_osd.create({
                'text'        : data[1],             // notification message
                'icon'        : '<?php echo $_smarty_tpl->tpl_vars['style_dir']->value;?>
images/osd_icons/star.png', // icon path, 48x48
                'sticky'      : false,             // if true, timeout is ignored
                'timeout'     : 4,                 // disappears after 6 seconds
                'dismissable' : true               // can be dismissed manually
                });

            //document.getElementById("link_game_to_set").reset();
            document.getElementById("menu_detail_expand_set").innerHTML = "";
            }
        }
        xmlhttp.open("GET","../menus/db_menu_disk.php?action=delete_game_from_set&menu_disk_title_id="+menu_disk_title_id+"&menu_disk_id="+menu_disk_id+"&title_name="+title_name,true);
        xmlhttp.send();
    }
}



function CreateChain(str,menu_disk_id) {
 if (str == "") {
        document.getElementById("menu_software_list").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

                data = xmlhttp.responseText.split ( "[BRK]" );
                document.getElementById("menu_software_list").innerHTML = data[0];

            $.notify_osd.create({
                'text'        : data[1],             // notification message
                'icon'        : '<?php echo $_smarty_tpl->tpl_vars['style_dir']->value;?>
images/osd_icons/star.png', // icon path, 48x48
                'sticky'      : false,             // if true, timeout is ignored
                'timeout'     : 4,                 // disappears after 6 seconds
                'dismissable' : true               // can be dismissed manually
                });

            //document.getElementById("link_game_to_set").reset();
            document.getElementById("menu_detail_expand_set").innerHTML = "";
            }
        }
        xmlhttp.open("GET","../menus/db_menu_disk.php?action=add_set_to_menu&menu_disk_title_id="+str+"&menu_disk_id="+menu_disk_id,true);
        xmlhttp.send();
    }
}

function deleteScreenshotfromMenu(str,menu_disk_id) {

         // CONFIRM REQUIRES ONE ARGUMENT
         var message = "Are you sure you want to delete this screenshot from this menu disk?";
         // CONFIRM IS BOOLEAN. THAT MEANS THAT
         // IT RETURNS TRUE IF 'OK' IS CLICKED
         // OTHERWISE IT RETURN FALSE
         var return_value = confirm(message);

        if (return_value =="0")
        {
            return;
        }
        else
        {
            if (window.XMLHttpRequest)
            {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            }
            else
            {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }

            xmlhttp.onreadystatechange = function()
            {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                {
                    document.getElementById("menu_screenshot_list").innerHTML = xmlhttp.responseText;

                     $.notify_osd.create({
                    'text'        : 'Screenshot deleted from menudisk', // notification message
                    'icon'        : '<?php echo $_smarty_tpl->tpl_vars['style_dir']->value;?>
images/osd_icons/star.png', // icon path, 48x48
                    'sticky'      : false,             // if true, timeout is ignored
                    'timeout'     : 4,                 // disappears after 6 seconds
                    'dismissable' : true               // can be dismissed manually
                    });

                }
            }

            xmlhttp.open("GET","../menus/db_menu_disk.php?action=delete_screen_from_menu_disk&screenshot_id="+str+"&menu_disk_id="+menu_disk_id,true);
            xmlhttp.send();

        }
}

function deleteDownload(str,menu_disk_id) {

         // CONFIRM REQUIRES ONE ARGUMENT
         var message = "Are you sure you want to delete this download from this menu disk?";
         // CONFIRM IS BOOLEAN. THAT MEANS THAT
         // IT RETURNS TRUE IF 'OK' IS CLICKED
         // OTHERWISE IT RETURN FALSE
         var return_value = confirm(message);

        if (return_value =="0")
        {
            return;
        }
        else
        {
            if (window.XMLHttpRequest)
            {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            }
            else
            {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }

            xmlhttp.onreadystatechange = function()
            {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                {
                    document.getElementById("menu_file_list").innerHTML = xmlhttp.responseText;

                     $.notify_osd.create({
                    'text'        : 'Download deleted from menudisk', // notification message
                    'icon'        : '<?php echo $_smarty_tpl->tpl_vars['style_dir']->value;?>
images/osd_icons/star.png', // icon path, 48x48
                    'sticky'      : false,             // if true, timeout is ignored
                    'timeout'     : 4,                 // disappears after 6 seconds
                    'dismissable' : true               // can be dismissed manually
                    });

                }
            }
            xmlhttp.open("GET","../menus/db_menu_disk.php?action=delete_download_from_menu_disk&menu_disk_download_id="+str+"&menu_disk_id="+menu_disk_id,true);
            xmlhttp.send();
        }
}

function deleteGamefromMenu(str,menu_disk_id) {

         // CONFIRM REQUIRES ONE ARGUMENT
         var message = "Are you sure you want to delete this title from this menu disk?";
         // CONFIRM IS BOOLEAN. THAT MEANS THAT
         // IT RETURNS TRUE IF 'OK' IS CLICKED
         // OTHERWISE IT RETURN FALSE
         var return_value = confirm(message);

         document.getElementById("menu_disk_title_id"+str).checked = false;

         if (return_value !="0")
         {
            if (str == "")
            {
                document.getElementById("menu_software_list").innerHTML = "";
                return;
            }
            else
            {
                if (window.XMLHttpRequest)
                {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                }
                else
                {
                    // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function()
                {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                    {
                        data = xmlhttp.responseText.split ( "[BRK]" );
                        document.getElementById("menu_software_list").innerHTML = data[0];

                         $.notify_osd.create({
                        'text'        : data[1],            // notification message
                        'icon'        : '<?php echo $_smarty_tpl->tpl_vars['style_dir']->value;?>
images/osd_icons/star.png', // icon path, 48x48
                        'sticky'      : false,             // if true, timeout is ignored
                        'timeout'     : 4,                 // disappears after 6 seconds
                        'dismissable' : true               // can be dismissed manually
                                            });
                    }
                }
                xmlhttp.open("GET","../menus/db_menu_disk.php?action=delete_from_menu_disk&menu_disk_title_id="+str+"&menu_disk_id="+menu_disk_id,true);
                xmlhttp.send();
            }
         }
}

function deleteDocfromMenu(str,menu_disk_id) {

         // CONFIRM REQUIRES ONE ARGUMENT
         var message = "Are you sure you want to delete this doc title from this menu disk?";
         // CONFIRM IS BOOLEAN. THAT MEANS THAT
         // IT RETURNS TRUE IF 'OK' IS CLICKED
         // OTHERWISE IT RETURN FALSE
         var return_value = confirm(message);

         document.getElementById("menu_disk_title_id"+str).checked = false;

         if (return_value !="0")
         {
            if (str == "")
            {
                document.getElementById("menu_doc_list").innerHTML = "";
                return;
            }
            else
            {
                if (window.XMLHttpRequest)
                {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                }
                else
                {
                    // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function()
                {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                    {
                        data = xmlhttp.responseText.split ( "[BRK]" );
                        document.getElementById("menu_doc_list").innerHTML = data[0];

                         $.notify_osd.create({
                        'text'        : data[1],            // notification message
                        'icon'        : '<?php echo $_smarty_tpl->tpl_vars['style_dir']->value;?>
images/osd_icons/star.png', // icon path, 48x48
                        'sticky'      : false,             // if true, timeout is ignored
                        'timeout'     : 4,                 // disappears after 6 seconds
                        'dismissable' : true               // can be dismissed manually
                                            });
                    }
                }
                xmlhttp.open("GET","../menus/db_menu_disk.php?action=delete_doc_from_menu_disk&menu_disk_title_id="+str+"&menu_disk_id="+menu_disk_id,true);
                xmlhttp.send();
            }
         }
}

function DeleteMenuDisk(str) {

    var str2 = "diskedit_ajax_";
    var disk_edit_ajax = str2.concat(str);

     // CONFIRM REQUIRES ONE ARGUMENT
     var message = "Are you sure you want to delete this menudisk and all data linked to it?";
     // CONFIRM IS BOOLEAN. THAT MEANS THAT
     // IT RETURNS TRUE IF 'OK' IS CLICKED
     // OTHERWISE IT RETURN FALSE
     var return_value = confirm(message);

    if (return_value =="0")
    {
        return;
    }
    else
    {
        if (window.XMLHttpRequest)
        {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                data = xmlhttp.responseText.split ( "[BRK]" );
                document.getElementById(disk_edit_ajax).innerHTML = data[0];

                if (data[9]!==undefined)
                {
                    data[1] = data[9];
                }

                 $.notify_osd.create({
                'text'        : data[1], // notification message
                'icon'        : '<?php echo $_smarty_tpl->tpl_vars['style_dir']->value;?>
images/osd_icons/star.png', // icon path, 48x48
                'sticky'      : false,             // if true, timeout is ignored
                'timeout'     : 4,                 // disappears after 6 seconds
                'dismissable' : true               // can be dismissed manually
                });
            }
        }

        xmlhttp.open("GET","../menus/db_menu_disk.php?action=delete_menu_disk&menu_disk_id="+str,true);
        xmlhttp.send();
    }
}

function DeleteSet(str) {

    // CONFIRM REQUIRES ONE ARGUMENT
    var message = "Are you sure you want to delete this set?";
    // CONFIRM IS BOOLEAN. THAT MEANS THAT
    // IT RETURNS TRUE IF 'OK' IS CLICKED
    // OTHERWISE IT RETURN FALSE
    var return_value = confirm(message);

    if (return_value !="0")
    {
        url="../menus/db_menu_disk.php?action=delete_set&menu_sets_id="+str;
        location.href=url;
    }
}

function PublishSet(str,action) {
    // CONFIRM REQUIRES ONE ARGUMENT
    var message = "Change status of this set?";
    // CONFIRM IS BOOLEAN. THAT MEANS THAT
    // IT RETURNS TRUE IF 'OK' IS CLICKED
    // OTHERWISE IT RETURN FALSE
    var return_value = confirm(message);

    if (return_value !="0")
    {
        url="../menus/db_menu_disk.php?action=publish_set&online="+action+"&menu_sets_id="+str;
        location.href=url;
    }
}

function addCreditstoMenu(menu_disk_id) {
 if (menu_disk_id == "") {
        document.getElementById("menu_credit_list").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("menu_credit_list").innerHTML = xmlhttp.responseText;
            }
        }

        var ind_id = document.getElementById("menu_credits_form").elements.namedItem("ind_id").value;
        var author_type_id = document.getElementById("menu_credits_form").elements.namedItem("author_type_id").value;

        xmlhttp.open("GET","../menus/db_menu_disk.php?action=add_intro_credits&author_type_id="+author_type_id+"&menu_disk_id="+menu_disk_id+"&ind_id="+ind_id,true);
        xmlhttp.send();
    }
}

function DeleteCredits(menu_disk_credits_id,menu_disk_id) {

            // CONFIRM REQUIRES ONE ARGUMENT
         var message = "Are you sure you want to delete this person from the credit list????";
         // CONFIRM IS BOOLEAN. THAT MEANS THAT
         // IT RETURNS TRUE IF 'OK' IS CLICKED
         // OTHERWISE IT RETURN FALSE
         var return_value = confirm(message);

         if (return_value !="0")
         {

        if (menu_disk_credits_id == "") {
        document.getElementById("menu_credit_list").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("menu_credit_list").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../menus/db_menu_disk.php?action=delete_menu_disk_credits&menu_disk_credits_id="+menu_disk_credits_id+"&menu_disk_id="+menu_disk_id,true);
        xmlhttp.send();
            }
         }
}

function ChangeState(state_id,menu_disk_id) {

    var str2 = "diskedit_ajax_";
    var disk_edit_ajax = str2.concat(menu_disk_id);

 if (menu_disk_id == "") {
        document.getElementById(disk_edit_ajax).innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById(disk_edit_ajax).innerHTML = xmlhttp.responseText;

                 $.notify_osd.create({
                'text'        : 'Update status of menudisk',             // notification message
                'icon'        : '<?php echo $_smarty_tpl->tpl_vars['style_dir']->value;?>
images/osd_icons/star.png', // icon path, 48x48
                'sticky'      : false,             // if true, timeout is ignored
                'timeout'     : 4,                 // disappears after 4 seconds
                'dismissable' : true               // can be dismissed manually
                });

            }
        }
        xmlhttp.open("GET","../menus/db_menu_disk.php?action=change_menu_disk_state&state_id="+state_id+"&menu_disk_id="+menu_disk_id,true);
        xmlhttp.send();
    }
}

function ChangeNick(individual_nicks_id,menu_disk_credits_id,menu_disk_id) {

 if (menu_disk_credits_id == "") {
        document.getElementById("menu_credit_list").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("menu_credit_list").innerHTML = xmlhttp.responseText;

                 $.notify_osd.create({
                'text'        : 'Nickname changed',             // notification message
                'icon'        : '<?php echo $_smarty_tpl->tpl_vars['style_dir']->value;?>
images/osd_icons/star.png', // icon path, 48x48
                'sticky'      : false,             // if true, timeout is ignored
                'timeout'     : 4,                 // disappears after 4 seconds
                'dismissable' : true               // can be dismissed manually
                });

            }
        }
        xmlhttp.open("GET","../menus/db_menu_disk.php?action=change_nickname&individual_nicks_id="+individual_nicks_id+"&menu_disk_credits_id="+menu_disk_credits_id+"&menu_disk_id="+menu_disk_id,true);
        xmlhttp.send();
    }
}

function ChangeDoctype(doc_type_id,doc_id,menu_disk_id) {

 if (doc_type_id == "") {
        document.getElementById("menu_doc_list").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("menu_doc_list").innerHTML = xmlhttp.responseText;

                 $.notify_osd.create({
                'text'        : 'Doctype changed',             // notification message
                'icon'        : '<?php echo $_smarty_tpl->tpl_vars['style_dir']->value;?>
images/osd_icons/star.png', // icon path, 48x48
                'sticky'      : false,             // if true, timeout is ignored
                'timeout'     : 4,                 // disappears after 4 seconds
                'dismissable' : true               // can be dismissed manually
                });

            }
        }
        xmlhttp.open("GET","../menus/db_menu_disk.php?action=change_doctype&doc_type_id="+doc_type_id+"&doc_id="+doc_id+"&menu_disk_id="+menu_disk_id,true);
        xmlhttp.send();
    }
}

function ChangeYear(year_id,menu_disk_id) {

    var str2 = "diskedit_ajax_";
    var disk_edit_ajax = str2.concat(menu_disk_id);

 if (menu_disk_id == "") {
        document.getElementById(disk_edit_ajax).innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById(disk_edit_ajax).innerHTML = xmlhttp.responseText;

                 $.notify_osd.create({
                'text'        : 'Update release year of menudisk',             // notification message
                'icon'        : '<?php echo $_smarty_tpl->tpl_vars['style_dir']->value;?>
images/osd_icons/star.png', // icon path, 48x48
                'sticky'      : false,             // if true, timeout is ignored
                'timeout'     : 4,                 // disappears after 4 seconds
                'dismissable' : true               // can be dismissed manually
                });

            }
        }
        xmlhttp.open("GET","../menus/db_menu_disk.php?action=change_menu_disk_year&year_id="+year_id+"&menu_disk_id="+menu_disk_id,true);
        xmlhttp.send();
    }
}

function ChangeParent(parent_id,menu_disk_id) {

    var str2 = "diskedit_ajax_";
    var disk_edit_ajax = str2.concat(menu_disk_id);

 if (menu_disk_id == "") {
        document.getElementById(disk_edit_ajax).innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById(disk_edit_ajax).innerHTML = xmlhttp.responseText;

                 $.notify_osd.create({
                'text'        : 'Parent disk updated',             // notification message
                'icon'        : '<?php echo $_smarty_tpl->tpl_vars['style_dir']->value;?>
images/osd_icons/star.png', // icon path, 48x48
                'sticky'      : false,             // if true, timeout is ignored
                'timeout'     : 4,                 // disappears after 4 seconds
                'dismissable' : true               // can be dismissed manually
                });

            }
        }
        xmlhttp.open("GET","../menus/db_menu_disk.php?action=change_menu_disk_parent&parent_id="+parent_id+"&menu_disk_id="+menu_disk_id,true);
        xmlhttp.send();
    }
}
<?php echo '</script'; ?>
>
<?php
}
/* {/block 'java_script'} */
/* {block 'title'}  file:../../../themes/templates/1/admin/menus_disk_list.html */
function block_149234561258836fb1962206_79809981($_smarty_tpl, $_blockParentStack) {
?>
Menus Search results<?php
}
/* {/block 'title'} */
/* {block 'left_tile'}  file:../../../themes/templates/1/admin/menus_disk_list.html */
function block_204312997058836fb1963208_57990243($_smarty_tpl, $_blockParentStack) {
?>

<div class="standard_tile">
    <h1>SET OPTIONS</h1>
    <div class="standard_tile_line"></div>
    <div class="standard_table_center">
        <br>
        <form action="../menus/menus_disk_list.php" method="get" name="post" id="menu_set_change">
            <select name="menu_sets_id" id="quick_search_pub_select" onchange="this.form.submit()">
                <option value="" selected style="background-color:white;">Change Menu Set</option>
                <?php
$_from = $_smarty_tpl->tpl_vars['menu_set_list']->value;
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
                    <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['line']->value['menu_sets_id'],'output'=>$_smarty_tpl->tpl_vars['line']->value['menu_sets_name']),$_smarty_tpl);?>

                <?php
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_0_saved_local_item;
}
if ($__foreach_line_0_saved_item) {
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_0_saved_item;
}
?>
            </select>
        </form>
        <br>
        <div class="standard_tile_line"></div>
        <br>
        
        <form action="../menus/db_menu_disk.php" method="post" name="post" id="menu_edit">
            <b>Menu set Editor</b><br><br>
            Change name of menu set:<br>
            <input type="text" name="menu_sets_name" value="<?php echo $_smarty_tpl->tpl_vars['menu_set']->value['menu_sets_name'];?>
" class="standard_tile_input_small"><br/>
            <input type="hidden" name="menu_sets_id" value="<?php echo $_smarty_tpl->tpl_vars['menu_set']->value['menu_sets_id'];?>
">
            <input type="hidden" name="action" value="menu_set_name_update">
            <br>
            <input type="submit" value="Update" class="quick_search_games_button">
        </form>
        <br>
        <div class="standard_tile_line"></div>
        <div class="help-tip">
            <p>This is the overal type of the menu disk. Eg. The "Adrenaline UK" set is considered to be a game set. The "Sewer Doc Disk" set is an E-zine/doc set. However, this does not
               mean a game set can not contain anything else. Each menu disk title in the database has its own menu disk title TYPE attribute. Please see the general HELP of this section for more details.</p>
        </div>
        <br>
        <form action="../menus/db_menu_disk.php" method="post" name="post" id="menu_edit">
            <div style="margin-left:20px;">
                Menu type:<br>
            </div>
            <select name="menu_type_browse" size="1" id="quick_search_pub_select">
                <option value="" selected>-</option>
                <?php
$_from = $_smarty_tpl->tpl_vars['menu_types']->value;
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
                    <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['line']->value['menu_types_id'],'output'=>$_smarty_tpl->tpl_vars['line']->value['menu_types_text']),$_smarty_tpl);?>

                <?php
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_1_saved_local_item;
}
if ($__foreach_line_1_saved_item) {
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_1_saved_item;
}
?>
            </select>
            <input type="hidden" name="menu_sets_id" value="<?php echo $_smarty_tpl->tpl_vars['menu_set']->value['menu_sets_id'];?>
">
            <input type="hidden" name="action" value="menu_set_type_set">
            <br><br>
            <input type="submit" value="Set" class="quick_search_games_button">
        </form>
        <br>
        <?php if (isset($_smarty_tpl->tpl_vars['connected_menu_types']->value)) {?>
            <?php
$_from = $_smarty_tpl->tpl_vars['connected_menu_types']->value;
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
             <?php echo $_smarty_tpl->tpl_vars['line']->value['menu_types_text'];?>
 - <a href="#" class="standard_tile_link" onclick="MenuTypeDelete(<?php echo $_smarty_tpl->tpl_vars['line']->value['menu_types_main_id'];?>
);">Delete</a><br>
            <?php
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_2_saved_local_item;
}
if ($__foreach_line_2_saved_item) {
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_2_saved_item;
}
?>
        <?php }?>
        <br>
        <div class="standard_tile_line"></div>
        <div class="help-tip">
            <p>Most Menu Sets are released by a certain crew, a group of people. This is where you set the crew of this menu set. If you want to add or edit a crew, go to the <a href="../crew/crew_main.php" class="standard_tile_link">Crew</a> section.</p>
        </div>
        <br>
        
        <div style="margin-left:20px;">
            <b>Crew Editor</b><br>
        </div>
        <br>
        Set Crew for menu set:<br>
        <form action="../menus/db_menu_disk.php" method="post" name="post_menu_crew_set" id="menu_crew_set">
            <select name="crew_browse" size="1" id="quick_search_small_select" onchange="browseCrew(this.value)">
                <option value="" SELECTED>-</option>
                <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['az_value']->value,'output'=>$_smarty_tpl->tpl_vars['az_output']->value),$_smarty_tpl);?>

            </select>
            
            <div id="option_crew">
                <select name="crew_id" id="quick_search_pub_select">
                    <option value="" selected>-</option>
                    <?php
$_from = $_smarty_tpl->tpl_vars['crew']->value;
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
                        <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['line']->value['crew_id'],'output'=>$_smarty_tpl->tpl_vars['line']->value['crew_name']),$_smarty_tpl);?>

                    <?php
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_3_saved_local_item;
}
if ($__foreach_line_3_saved_item) {
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_3_saved_item;
}
?>
                </select>
            </div>
            <br>
            <input type="submit" value="Set" class="quick_search_games_button">
            <input type="hidden" name="menu_sets_id" value="<?php echo $_smarty_tpl->tpl_vars['menu_set']->value['menu_sets_id'];?>
">
            <input type="hidden" name="action" value="menu_set_crew_set">
        </form>
        <br>
        <?php if (isset($_smarty_tpl->tpl_vars['connected_crew']->value)) {?>
        <?php
$_from = $_smarty_tpl->tpl_vars['connected_crew']->value;
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
         <?php echo $_smarty_tpl->tpl_vars['line']->value['crew_name'];?>
 - <a href="#" class="standard_tile_link" onclick="CrewDelete(<?php echo $_smarty_tpl->tpl_vars['line']->value['crew_id'];?>
);">Delete</a><br>
        <?php
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_4_saved_local_item;
}
if ($__foreach_line_4_saved_item) {
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_4_saved_item;
}
?>
        <?php }?>
        <br>
        <div class="standard_tile_line"></div>
        <div class="help-tip">
            <p>Some Menu Sets were released by one individual. These sets are not common, but do exist. Go to the <a href="../individuals/individuals_main.php" class="standard_tile_link">Individuals</a> section for more details.</p>
        </div>
        <br>
        
        <div style="margin-left:20px;">
            <b>Individual Editor</b><br>
        </div>
        <br>
        Set individual for menu set:<br>
        <form action="../menus/db_menu_disk.php" method="post" name="post_menu_ind_set" id="menu_ind_set">
            <select name="ind_browse" size="1" id="quick_search_small_select" onchange="browseIndividual(this.value)">
                <option value="" SELECTED>-</option>
                <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['az_value']->value,'output'=>$_smarty_tpl->tpl_vars['az_output']->value),$_smarty_tpl);?>

            </select>
            
            <div id="option_ind">
                <select name="ind_id" id="quick_search_pub_select">
                    <option value="" selected>-</option>
                    <?php
$_from = $_smarty_tpl->tpl_vars['ind']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_line_5_saved_item = isset($_smarty_tpl->tpl_vars['line']) ? $_smarty_tpl->tpl_vars['line'] : false;
$_smarty_tpl->tpl_vars['line'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['line']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['line']->value) {
$_smarty_tpl->tpl_vars['line']->_loop = true;
$__foreach_line_5_saved_local_item = $_smarty_tpl->tpl_vars['line'];
?>
                        <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['line']->value['ind_id'],'output'=>$_smarty_tpl->tpl_vars['line']->value['ind_name']),$_smarty_tpl);?>

                    <?php
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_5_saved_local_item;
}
if ($__foreach_line_5_saved_item) {
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_5_saved_item;
}
?>
                </select>
            </div>
            <br>
            <input type="submit" value="Set" class="quick_search_games_button">
            <input type="hidden" name="menu_sets_id" value="<?php echo $_smarty_tpl->tpl_vars['menu_set']->value['menu_sets_id'];?>
">
            <input type="hidden" name="action" value="menu_set_ind_set">
        </form>
        <br>
        <?php if (isset($_smarty_tpl->tpl_vars['connected_ind']->value)) {?>
        <?php
$_from = $_smarty_tpl->tpl_vars['connected_ind']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_line_6_saved_item = isset($_smarty_tpl->tpl_vars['line']) ? $_smarty_tpl->tpl_vars['line'] : false;
$_smarty_tpl->tpl_vars['line'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['line']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['line']->value) {
$_smarty_tpl->tpl_vars['line']->_loop = true;
$__foreach_line_6_saved_local_item = $_smarty_tpl->tpl_vars['line'];
?>
         <?php echo $_smarty_tpl->tpl_vars['line']->value['ind_name'];?>
 - <a href="#" class="standard_tile_link" onclick="IndDelete(<?php echo $_smarty_tpl->tpl_vars['line']->value['ind_id'];?>
);">Delete</a><br>
        <?php
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_6_saved_local_item;
}
if ($__foreach_line_6_saved_item) {
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_6_saved_item;
}
?>
        <?php }?>
        <br>
        <div class="standard_tile_line"></div>
        <br>
        Quick add new Crew to db:
        <form action="../menus/db_menu_disk.php" method="post" name="post_menu_crew_add" id="menu_crew_add">
            <input type="text" name="new_crew_name" value="" class="standard_tile_input_small">
            <br>
            <br>
            <input type="submit" value="Add" class="quick_search_games_button">
            <input type="hidden" name="menu_sets_id" value="<?php echo $_smarty_tpl->tpl_vars['menu_set']->value['menu_sets_id'];?>
">
            <input type="hidden" name="action" value="menu_set_crew_add">
        </form>
        <br>
        <div class="standard_tile_line"></div>
        <br>
        Quick add new individual to db:
        <form action="../menus/db_menu_disk.php" method="post" name="post_menu_ind_add" id="menu_ind_add">
            <input type="text" name="new_ind_name" value="" class="standard_tile_input_small">
            <br>
            <br>
            <input type="submit" value="Add" class="quick_search_games_button">
            <input type="hidden" name="menu_sets_id" value="<?php echo $_smarty_tpl->tpl_vars['menu_set']->value['menu_sets_id'];?>
">
            <input type="hidden" name="action" value="menu_set_ind_add">
        </form>
        <br>
    </div>
</div>
<br>
<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:1/admin/left_nav.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php
}
/* {/block 'left_tile'} */
/* {block 'main_tile'}  file:../../../themes/templates/1/admin/menus_disk_list.html */
function block_190938217958836fb1984726_54025319($_smarty_tpl, $_blockParentStack) {
?>

<div class="standard_tile">
    <h1>EDIT SET</h1>
    <div class="standard_tile_line"></div>
    <div class="standard_tile_text">
        <div class="left_nav_section">
            Overhere you can edit/delete menu set <b><?php echo $_smarty_tpl->tpl_vars['menu_set']->value['menu_sets_name'];?>
</b>, or you can add menu disks to it. You can also make the set available on the website with the publish options.
        </div>
        <br>
        <div class="main_company_container">
            <div class="main_company_child" id="child_edit_company" style="text-align:left;">
                <fieldset>
                    <legend>More options</legend>
                        <div id="close_new_disk"><a onclick="addNewdisk(<?php echo $_smarty_tpl->tpl_vars['menu_set']->value['menu_sets_id'];?>
)" style="cursor: pointer;" class="left_nav_link" >Add New Disk</a><br></div>
                        <a onclick="DeleteSet(<?php echo $_smarty_tpl->tpl_vars['menu_set']->value['menu_sets_id'];?>
)" style="cursor: pointer;" class="left_nav_link" >Delete set</a>
                </fieldset>
            </div>
            <div class="main_company_child" id="child_add_company" style="text-align:left;">
                <fieldset>
                    <legend>Publish Set</legend>
                        <input onchange="PublishSet(<?php echo $_smarty_tpl->tpl_vars['menu_set']->value['menu_sets_id'];?>
,'online')" type="radio" name="publish" value="online" <?php ob_start();
echo $_smarty_tpl->tpl_vars['menu_set']->value['online'];
$_tmp1=ob_get_clean();
if (($_tmp1 == '1')) {?>checked<?php }?>> Online<br>
                        <input onchange="PublishSet(<?php echo $_smarty_tpl->tpl_vars['menu_set']->value['menu_sets_id'];?>
,'offline')" type="radio" name="publish" value="offline" <?php ob_start();
echo $_smarty_tpl->tpl_vars['menu_set']->value['online'];
$_tmp2=ob_get_clean();
if (($_tmp2 == '0')) {?>checked<?php }?>> Offline<br>
                </fieldset>
            </div>
        </div>
        <br>
        <div id="new_disk"></div>
        <br>
        <table class="standard_table_list" id="game_list_table">
            <tr>
                <th id="menu_disk_list_th">Menu Disk</th>
                <th id="menu_list_crew_th">Crew</th>
                <th id="menu_list_ind_th">Individual</th>
                <th id="menu_state_th">State</th>
            </tr>
            <?php if (isset($_smarty_tpl->tpl_vars['menus']->value)) {?>
                <?php
$_from = $_smarty_tpl->tpl_vars['menus']->value;
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
                    <tr id="diskedit_ajax_<?php echo $_smarty_tpl->tpl_vars['line']->value['menu_disk_id'];?>
">
                        <td class="menu_disk_list_td"><?php if ($_smarty_tpl->tpl_vars['line']->value['menu_disk_id'] != '') {?><a onclick="editDisk(<?php echo $_smarty_tpl->tpl_vars['line']->value['menu_disk_id'];?>
)" style="cursor: pointer;"><?php echo $_smarty_tpl->tpl_vars['line']->value['menu_disk_name'];?>
</a><?php } else { ?><i>n/a</i><?php }?></td>
                        <td class="menu_list_crew_td"><?php if (isset($_smarty_tpl->tpl_vars['line']->value['crew_id'])) {
echo $_smarty_tpl->tpl_vars['line']->value['crew_name'];
} else { ?><i>n/a</i><?php }?></td>
                        <td class="menu_list_ind_td"><?php if (isset($_smarty_tpl->tpl_vars['line']->value['ind_id'])) {
echo $_smarty_tpl->tpl_vars['line']->value['ind_name'];
} else { ?><i>n/a</i><?php }?></td>
                        <td class="menu_state_td"><?php if (isset($_smarty_tpl->tpl_vars['line']->value['menu_state'])) {
echo $_smarty_tpl->tpl_vars['line']->value['menu_state'];
} else { ?><i>n/a</i><?php }?></td>
                    </tr>
                <?php
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_7_saved_local_item;
}
if ($__foreach_line_7_saved_item) {
$_smarty_tpl->tpl_vars['line'] = $__foreach_line_7_saved_item;
}
?>
            <?php }?>
            <tr>
                <td class="standard_table_left" colspan="4">
                    <b><?php if ($_smarty_tpl->tpl_vars['nr_of_entries']->value == 1) {?>1 menu disk found <?php } else { ?> <?php echo $_smarty_tpl->tpl_vars['nr_of_entries']->value;?>
 menu disks found<?php }?> in <?php echo $_smarty_tpl->tpl_vars['querytime']->value;?>
 sec </b>
                </td>
            </tr>
        </table>
    </div>
</div>
<br>
<div class="standard_table_center"><a href="javascript:history.go(-1)" class="standard_tile_link">back</a></div>
<br>
<?php
}
/* {/block 'main_tile'} */
}

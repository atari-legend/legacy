/*!
 * menus.js
 * http://www.atarilegend.com
 *
 * Copyright 2017 Mattias Lönnback
 */

 (function($) {

$.fn.bindWithDelay = function( type, data, fn, timeout, throttle ) {

    if ( $.isFunction( data ) ) {
        throttle = timeout;
        timeout = fn;
        fn = data;
        data = undefined;
    }

    // Allow delayed function to be removed with fn in unbind function
    fn.guid = fn.guid || ($.guid && $.guid++);

    // Bind each separately so that each element has its own delay
    return this.each(function() {

        var wait = null;

        function cb() {
            var e = $.extend(true, { }, arguments[0]);
            var ctx = this;
            var throttler = function() {
                wait = null;
                fn.apply(ctx, [e]);
            };

            if (!throttle) { clearTimeout(wait); wait = null; }
            if (!wait) { wait = setTimeout(throttler, timeout); }
        }

        cb.guid = fn.guid;

        $(this).bind(type, data, cb);
    });
};

})(jQuery);


function OSDMessageDisplay(message) {
    $.notify_osd.create({
        'text': message, // notification message
        'icon': '../../../themes/styles/1/images/osd_icons/star.png', // icon path, 48x48
        'sticky': false, // if true, timeout is ignored
        'timeout': 4, // disappears after 6 seconds
        'dismissable': true // can be dismissed manually
    });
}

function editDisk(str) {
    var disk_edit_ajax = "diskedit_ajax_".concat(str);
    $.ajax({
        // The URL for the request
        url: "ajax_menus_detail.php",
        data: "action=edit_disk_box&menu_disk_id=" + str,
        type: "GET",
        dataType: "html",
        // Code to run if the request succeeds;
        success: function (html) {
            $("#" + disk_edit_ajax).html(html);
        }
    });
}

function CloseeditDisk(str) {
    var disk_edit_ajax = "diskedit_ajax_".concat(str);
    $.ajax({
        // The URL for the request
        url: "ajax_menus_detail.php",
        data: "action=close_edit_disk_box&menu_disk_id=" + str,
        type: "GET",
        dataType: "html",
        // Code to run if the request succeeds;
        success: function (html) {
            $("#" + disk_edit_ajax).html(html);
        }
    });
}

function popAddGames(str) {
    if (str === "") {
        $("#JSMenuDetailExpandGames").html("");
        return;
    } else {
        $.ajax({
            // The URL for the request
            url: "ajax_addgames_menus.php",
            data: "action=game_browse&list=full&query=num&menu_disk_id=" + str,
            type: "GET",
            dataType: "html",
            // Code to run if the request succeeds;
            success: function(html) {
                $("#JSMenuDetailExpandGames").html(html);
                $("#gameto_menu_link").html("<a onclick=\"closeAddGames(" + str + ")\" style=\"cursor: pointer;\" class=\"MAINNAV\">Add Game/Tool/Demo to menu</a>");
                GameSearchListen();
            }
        });
    }
}

function closeAddGames(str) {
    $("#JSMenuDetailExpandGames").html("");
    $("#gameto_menu_link").html("<a onclick=\"popAddGames(" + str + ")\" style=\"cursor: pointer;\" class=\"MAINNAV\">Add Game/Tool/Demo to menu</a>");
    return;
}

function SearchingGame(GameSearchAction) {
    if (GameSearchAction === "game_browse") {
        var form_values = $("#game_search_menu").serialize() + "&action=game_browse&list=inner&query=" + $(".JSGameBrowse").val();
    } else {
        if (GameSearchAction === "game_search") {
            var form_values = $("#game_search_menu").serialize() + "&action=game_search&list=inner&query=" + $(".JSGameSearch").val();
        }
    }
    $.ajax({
        // The URL for the request
        url: "ajax_addgames_menus.php",
        data: form_values,
        type: "GET",
        dataType: "html",
        // Code to run if the request succeeds;
        success: function(html) {
            $("#game_list").html(html);
        }
    });
}

function GameSearchListen() {
    $(".JSGameBrowse").change(function() {
        SearchingGame("game_browse");
    });

    $(".JSGameSearch").bindWithDelay("keyup", function(e) {
        var value = $(this).val();
        if (value.length >= 3) {
            SearchingGame("game_search");
        }
    }, 300);
}

function addGametoMenu(software_id, menu_disk_id, software_type) {
    if (software_id === "") {
        $("#JSMenuSoftwareList").html("");
        return;
    } else {
        $.ajax({
            // The URL for the request
            url: "db_menu_disk.php",
            data: "action=add_title_to_menu&software_id=" + software_id + "&menu_disk_id=" + menu_disk_id + "&software_type=" + software_type,
            type: "POST",
            dataType: "html",
            // Code to run if the request succeeds;
            success: function(html) {
                var ReturnHtml = html.split('[BRK]');
                $("#JSMenuSoftwareList").html(ReturnHtml[0]);
                OSDMessageDisplay(ReturnHtml[1]);
            }
        });
    }
}

function addNewdisk(str) {
    if (str === "") {
        $("#new_disk").html("");
        return;
    } else {
        $.ajax({
            // The URL for the request
            url: "ajax_menus.php",
            data: "action=add_new_disk_box&menu_sets_id=" + str,
            type: "POST",
            dataType: "html",
            // Code to run if the request succeeds;
            success: function(html) {
                $("#new_disk").html(html);
                $("#close_new_disk").html("<a onclick=\"CloseaddNewdisk(" + str + ")\" style=\"cursor: pointer;\" class=\"MAINNAV\">Add New Disk</a>");
            }
        });
    }
}

function CloseaddNewdisk(str) {
    $("#new_disk").html("");
    $("#close_new_disk").html("<a onclick=\"addNewdisk(" + str + ")\" style=\"cursor: pointer;\" class=\"MAINNAV\">Add New Disk</a>");
    return;
}

function myFunction() {
    $but = $('#file_upload_game_file');
    $("input:file[id=file_upload]").change(function() {
        document.getElementById('file_upload_game_screenshots').value = 'file(s) selected';
    });
    $("input:file[id=file_upload2]").change(function() {
        document.getElementById('file_upload_game_file').value = $(this).val();
    });
}

function browseCrew(str) {
    if (str === "") {
        $("#option_crew").html("");
        return;
    } else {
        $.ajax({
            // The URL for the request
            url: "ajax_menus.php",
            data: "action=crew_browse&query=" + str,
            type: "GET",
            dataType: "html",
            // Code to run if the request succeeds;
            success: function(html) {
                $("#option_crew").html(html);
            }
        });
    }
}

function browseIndividual(str) {
    if (str === "") {
        $("#option_ind").html("");
        return;
    } else {
        $.ajax({
            // The URL for the request
            url: "ajax_menus.php",
            data: "action=ind_browse&query=" + str,
            type: "GET",
            dataType: "html",
            // Code to run if the request succeeds;
            success: function(html) {
                $("#option_ind").html(html);
            }
        });
    }
}

function browseInd(str) {
    if (str === "") {
        $("#ind_member").html("");
        return;
    } else {
        $.ajax({
            // The URL for the request
            url: "ajax_menus_detail.php",
            data: "action=ind_gen_browse&query=" + str,
            type: "GET",
            dataType: "html",
            // Code to run if the request succeeds;
            success: function(html) {
                $("#ind_member").html(html);
            }
        });
    }
}

function searchInd(str) {
    if (str === "") {
        $("#ind_member").html("");
    } else {
        $.ajax({
            // The URL for the request
            url: "ajax_menus_detail.php",
            data: "action=ind_gen_search&query=" + str,
            type: "GET",
            dataType: "html",
            // Code to run if the request succeeds;
            success: function(html) {
                $("#ind_member").html(html);
            }
        });
    }
}

function popAddIntroCred(str) {
    if (str === "") {
        $("#menu_detail_expand").html("");
        return;
    } else {
        $.ajax({
            // The URL for the request
            url: "ajax_menus_detail.php",
            data: "action=add_intro_credit&query=" + str,
            type: "GET",
            dataType: "html",
            // Code to run if the request succeeds;
            success: function(html) {
                $("#menu_detail_expand").html(html);
                $("#intro_credit_link").html("<a onclick=\"closeAddIntroCred(" + str + ")\" style=\"cursor: pointer;\" class=\"MAINNAV\">Add intro credits</a>");
            }
        });
    }
}

function closeAddIntroCred(str) {
    $("#menu_detail_expand").html("");
    $("#intro_credit_link").html("<a onclick=\"popAddIntroCred(" + str + ")\" style=\"cursor: pointer;\" class=\"MAINNAV\">Add intro credits</a>");
    return;
}

function popAddAuthorMenutitle(menu_disk_title_id, game_id, game_name) {
    if (menu_disk_title_id === "") {
        $("#menu_detail_expand_author_title").html("");
        return;
    } else {
        $.ajax({
            // The URL for the request
            url: "ajax_add_author_menutitle.php",
            data: "menu_disk_title_id=" + menu_disk_title_id + "&game_name=" + game_name + "&game_id=" + game_id,
            type: "GET",
            dataType: "html",
            // Code to run if the request succeeds;
            success: function(html) {
                $("#menu_detail_expand_author_title").html(html);
                $("#author_to_menu_title" + game_id).html("<a onclick=\"closeAddAuthor(" + menu_disk_title_id + "," + game_id + ",'" + game_name + "')\" style=\"cursor: pointer;\" class=\"standard_tile_link\">" + game_name + "</a>");
            }
        });
    }
}

function closeAddAuthor(menu_disk_title_id, game_id, game_name) {
    $("#menu_detail_expand_author_title").html("");
    $("#author_to_menu_title" + game_id).html("<a onclick=\"popAddAuthorMenutitle(" + menu_disk_title_id + "," + game_id + ",'" + game_name + "')\" style=\"cursor: pointer;\" class=\"standard_tile_link\">" + game_name + "</a>");
    return;
}

function popAddAuthorMenutitleDoc(menu_disk_title_id, game_id, game_name) {
    if (menu_disk_title_id === "") {
        $("#menu_detail_expand_author_title_doc").html("");
        return;
    } else {
        $.ajax({
            // The URL for the request
            url: "ajax_add_author_menutitle.php",
            data: "menu_disk_title_id=" + menu_disk_title_id + "&game_name=" + game_name + "&game_id=" + game_id,
            type: "GET",
            dataType: "html",
            // Code to run if the request succeeds;
            success: function(html) {
                $("#menu_detail_expand_author_title_doc").html(html);
                $("#author_to_menu_title_doc" + game_id).html("<a onclick=\"closeAddAuthorDoc(" + menu_disk_title_id + "," + game_id + ",'" + game_name + "')\" style=\"cursor: pointer;\" class=\"standard_tile_link\">" + game_name + "</a>");
            }
        });
    }
}

function closeAddAuthorDoc(menu_disk_title_id, game_id, game_name) {
    $("#menu_detail_expand_author_title_doc").html("");
    $("#author_to_menu_title_doc" + game_id).html("<a onclick=\"popAddAuthorMenutitleDoc(" + menu_disk_title_id + "," + game_id + ",'" + game_name + "')\" style=\"cursor: pointer;\" class=\"standard_tile_link\">" + game_name + "</a>");
    return;
}

function popAddDocs(str) {
    if (str === "") {
        $("#menu_detail_expand_docs").html("");
        return;
    } else {
        $.ajax({
            // The URL for the request
            url: "ajax_adddocs_menus.php",
            data: "action=game_browse&list=full&query=num&menu_disk_id=" + str,
            type: "GET",
            dataType: "html",
            // Code to run if the request succeeds;
            success: function(html) {
                $("#menu_detail_expand_docs").html(html);
                $("#docto_menu_link").html("<a onclick=\"closeAddDocs(" + str + ")\" style=\"cursor: pointer;\" class=\"MAINNAV\">Add Doc to menu</a>");
            }
        });
    }
}

function closeAddDocs(str) {
    $("#menu_detail_expand_docs").html("");
    $("#docto_menu_link").html("<a onclick=\"popAddDocs(" + str + ")\" style=\"cursor: pointer;\" class=\"MAINNAV\">Add Doc to menu</a>");
    return;
}

function popAddScreenshots(str) {
    if (str === "") {
        $("#JSMenuDetailExpandScreenshots").html("");
        return;
    } else {
        $.ajax({
            // The URL for the request
            url: "ajax_addscreenshots_menus.php",
            data: "menu_disk_id=" + str,
            type: "GET",
            dataType: "html",
            // Code to run if the request succeeds;
            success: function(html) {
                $("#JSMenuDetailExpandScreenshots").html(html);
                $("#screenshot_link").html("<a onclick=\"closeAddScreenshots(" + str + ")\" style=\"cursor: pointer;\" class=\"MAINNAV\">Add Screenshots to menu</a>");
            }
        });
    }
}

function closeAddScreenshots(str) {
    $("#JSMenuDetailExpandScreenshots").html("");
    $("#screenshot_link").html("<a onclick=\"popAddScreenshots(" + str + ")\" style=\"cursor: pointer;\" class=\"MAINNAV\">Add Screenshots to menu</a>");
    return;
}

function popAddFile(str) {
    if (str === "") {
        $("#JSMenuDetailExpandFile").html("");
        return;
    } else {
        $.ajax({
            // The URL for the request
            url: "ajax_addfile_menus.php",
            data: "menu_disk_id=" + str,
            type: "GET",
            dataType: "html",
            // Code to run if the request succeeds;
            success: function(html) {
                $("#JSMenuDetailExpandFile").html(html);
                $("#file_link").html("<a onclick=\"closeAddFile(" + str + ")\" style=\"cursor: pointer;\" class=\"MAINNAV\">Add File to menu</a>");
            }
        });
    }
}

function closeAddFile(str) {
    $("#JSMenuDetailExpandFile").html("");
    $("#file_link").html("<a onclick=\"popAddFile(" + str + ")\" style=\"cursor: pointer;\" class=\"MAINNAV\">Add File to menu</a>");
    return;
}

function addslashes(str) {
    return (str + '').replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0');
}

function popAddSet(str, menu_disk_id, title_name) {
    if (str === "") {
        $("#JSMenuDetailExpandSet").html("");
        return;
    } else {
        $.ajax({
            // The URL for the request
            url: "ajax_addset_menus.php",
            data: "menu_disk_title_id=" + str + "&menu_disk_id=" + menu_disk_id + "&title_name=" + title_name,
            type: "GET",
            dataType: "html",
            // Code to run if the request succeeds;
            success: function(html) {
                $("#JSMenuDetailExpandSet").html(html);
                var title = addslashes(title_name);
                $("#" + str).html("<a onclick=\"closeAddSet(" + str + "," + menu_disk_id + ",'" + title + "')\" style=\"cursor: pointer;\" class=\"standard_tile_link\">Add</a>");
            }
        });
        var elementExists = document.getElementById("set_chain_update");
        if (typeof(elementExists) != 'undefined' && elementExists !== null) {
            $("#set_chain_update").html("");
        }
    }
}

function closeAddSet(str, menu_disk_id, title_name) {
    var title = addslashes(title_name);
    $("#JSMenuDetailExpandSet").html("");
    $("#" + str).html("<a onclick=\"popAddSet(" + str + "," + menu_disk_id + ",'" + title + "')\" style=\"cursor: pointer;\" class=\"standard_tile_link\">Add</a>");
    return;
}

function browseDoc(str, menu_disk_id) {
    if (str === "") {
        $("#doc_list").html("");
        return;
    } else {
        $.ajax({
            // The URL for the request
            url: "ajax_adddocs_menus.php",
            data: "action=game_browse&list=inner&query=" + str + "&menu_disk_id=" + menu_disk_id,
            type: "GET",
            dataType: "html",
            // Code to run if the request succeeds;
            success: function(html) {
                $("#doc_list").html(html);
            }
        });
    }
}

function searchDoc(menu_disk_id) {
    var JSid = document.getElementById("docsearch_menudisk");
    var str = JSid.value;
    if (str === "") {
        str = "empty";
        $("#doc_list").html("");
    } else {
        if (str.length >= 3) {
            $.ajax({
                // The URL for the request
                url: "ajax_adddocs_menus.php",
                data: "action=game_search&list=inner&query=" + str + "&menu_disk_id=" + menu_disk_id,
                type: "GET",
                dataType: "html",
                // Code to run if the request succeeds;
                success: function(html) {
                    $("#doc_list").html(html);
                }
            });
        }
    }
}

function addAuthorstoMenutitle(menu_disk_title_id) {
    if (menu_disk_title_id === "") {
        $("#author_list").html("");
        return;
    } else {
        var form_values = $("#authors_form").serialize();
        $.ajax({
            // The URL for the request
            url: "db_menu_disk.php",
            data: form_values,
            type: "POST",
            dataType: "html",
            // Code to run if the request succeeds;
            success: function(html) {
                var ReturnHtml = html.split('[BRK]');
                $("#author_list").html(ReturnHtml[0]);
                OSDMessageDisplay(ReturnHtml[1]);
            }
        });
    }
}

function addDoctoMenu(software_id, menu_disk_id, software_type) {
    if (software_id === "") {
        $("#menu_doc_list").html("");
        return;
    } else {
        $.ajax({
            // The URL for the request
            url: "db_menu_disk.php",
            data: "action=add_doc_to_menu&software_id=" + software_id + "&menu_disk_id=" + menu_disk_id + "&software_type=" + software_type,
            type: "POST",
            dataType: "html",
            // Code to run if the request succeeds;
            success: function(html) {
                var ReturnHtml = html.split('[BRK]');
                $("#menu_doc_list").html(ReturnHtml[0]);
                OSDMessageDisplay(ReturnHtml[1]);
            }
        });
    }
}

function addScreenshottoMenu(menu_disk_id) {
    if (menu_disk_id === "") {
        $("#JSMenuScreenshotList").html("");
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
                data = xmlhttp.responseText.split("[BRK]");
                document.getElementById("JSMenuScreenshotList").innerHTML = data[0];
                OSDMessageDisplay(data[1]);
                document.getElementById("screenshot_add_to_menu").reset();
            }
        }
        var formData = new FormData(document.getElementById("screenshot_add_to_menu"));
        xmlhttp.open("POST", "../menus/db_menu_disk.php", true);
        xmlhttp.send(formData);
    }
}

function addFiletoMenu(menu_disk_id) {
    if (menu_disk_id === "") {
        $("#JSMenuFileList").html("");
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
                data = xmlhttp.responseText.split("[BRK]");
                document.getElementById("JSMenuFileList").innerHTML = data[0];
                OSDMessageDisplay(data[1]);
                document.getElementById("File_add_to_menu").reset();
            }
        }
        var formData = new FormData(document.getElementById("file_add_to_menu"));
        xmlhttp.open("POST", "../menus/db_menu_disk.php", true);
        xmlhttp.send(formData);
    }
}

function LinkChain(menu_disk_title_id, menu_disk_id) {
    if (menu_disk_title_id === "") {
        $("#JSMenuSoftwareList").html("");
        return;
    } else {
        var form_values = $("#link_game_to_set").serialize();
        $.ajax({
            // The URL for the request
            url: "db_menu_disk.php",
            data: form_values,
            type: "POST",
            dataType: "html",
            // Code to run if the request succeeds;
            success: function(html) {
                var ReturnHtml = html.split('[BRK]');
                $("#JSMenuSoftwareList").html(ReturnHtml[0]);
                OSDMessageDisplay(ReturnHtml[1]);
                $("#JSMenuDetailExpandSet").html("");
            }
        });
    }
}

function DeleteChain(menu_disk_title_id, menu_disk_id, title_name) {
    if (menu_disk_title_id === "") {
        $("#JSMenuSoftwareList").html("");
        return;
    } else {
        $.ajax({
            // The URL for the request
            url: "db_menu_disk.php",
            data: "action=delete_game_from_set&menu_disk_title_id=" + menu_disk_title_id + "&menu_disk_id=" + menu_disk_id + "&title_name=" + title_name,
            type: "POST",
            dataType: "html",
            // Code to run if the request succeeds;
            success: function(html) {
                var ReturnHtml = html.split('[BRK]');
                $("#JSMenuSoftwareList").html(ReturnHtml[0]);
                OSDMessageDisplay(ReturnHtml[1]);
                $("#JSMenuDetailExpandSet").html("");
            }
        });
    }
}

function CreateChain(str, menu_disk_id) {
    if (str === "") {
        $("#JSMenuSoftwareList").html("");
        return;
    } else {
        $.ajax({
            // The URL for the request
            url: "db_menu_disk.php",
            data: "action=add_set_to_menu&menu_disk_title_id=" + str + "&menu_disk_id=" + menu_disk_id,
            type: "POST",
            dataType: "html",
            // Code to run if the request succeeds;
            success: function(html) {
                var ReturnHtml = html.split('[BRK]');
                $("#JSMenuSoftwareList").html(ReturnHtml[0]);
                OSDMessageDisplay(ReturnHtml[1]);
                $("#JSMenuDetailExpandSet").html("");
            }
        });
    }
}

function addCreditstoMenu(menu_disk_id) {
    if (menu_disk_id === "") {
        $("#menu_credit_list").html("");
        return;
    } else {
        var ind_id = document.getElementById("menu_credits_form").elements.namedItem("ind_id").value;
        var author_type_id = document.getElementById("menu_credits_form").elements.namedItem("author_type_id").value;
        $.ajax({
            // The URL for the request
            url: "db_menu_disk.php",
            data: "action=add_intro_credits&author_type_id=" + author_type_id + "&menu_disk_id=" + menu_disk_id + "&ind_id=" + ind_id,
            type: "POST",
            dataType: "html",
            // Code to run if the request succeeds;
            success: function(html) {
                var ReturnHtml = html.split('[BRK]');
                $("#menu_credit_list").html(ReturnHtml[0]);
                OSDMessageDisplay(ReturnHtml[1]);
                document.getElementById("menu_credit_list").reset();
            }
        });
    }
}

function ChangeState(state_id, menu_disk_id) {
    var str2 = "diskedit_ajax_";
    var disk_edit_ajax = str2.concat(menu_disk_id);
    if (menu_disk_id === "") {
        $("#" + disk_edit_ajax).html("");
        return;
    } else {
        $.ajax({
            // The URL for the request
            url: "db_menu_disk.php",
            data: "action=change_menu_disk_state&state_id=" + state_id + "&menu_disk_id=" + menu_disk_id,
            type: "POST",
            dataType: "html",
            // Code to run if the request succeeds;
            success: function(html) {
                var ReturnHtml = html.split('[BRK]');
                $("#" + disk_edit_ajax).html(ReturnHtml[0]);
                OSDMessageDisplay(ReturnHtml[1]);
                document.getElementById(disk_edit_ajax).reset();
            }
        });
    }
}

function ChangeDoctype(doc_type_id, doc_id, menu_disk_id) {
    if (doc_type_id === "") {
        $("#menu_doc_list").html("");
        return;
    } else {
        $.ajax({
            // The URL for the request
            url: "db_menu_disk.php",
            data: "action=change_doctype&doc_type_id=" + doc_type_id + "&doc_id=" + doc_id + "&menu_disk_id=" + menu_disk_id,
            type: "POST",
            dataType: "html",
            // Code to run if the request succeeds;
            success: function(html) {
                var ReturnHtml = html.split('[BRK]');
                $("#menu_doc_list").html(ReturnHtml[0]);
                OSDMessageDisplay(ReturnHtml[1]);
                document.getElementById("menu_doc_list").reset();
            }
        });
    }
}

function ChangeYear(year_id, menu_disk_id) {
    var str2 = "diskedit_ajax_";
    var disk_edit_ajax = str2.concat(menu_disk_id);
    if (menu_disk_id === "") {
        $("#" + disk_edit_ajax).html("");
        return;
    } else {
        $.ajax({
            // The URL for the request
            url: "db_menu_disk.php",
            data: "action=change_menu_disk_year&year_id=" + year_id + "&menu_disk_id=" + menu_disk_id,
            type: "POST",
            dataType: "html",
            // Code to run if the request succeeds;
            success: function(html) {
                var ReturnHtml = html.split('[BRK]');
                $("#" + disk_edit_ajax).html(ReturnHtml[0]);
                OSDMessageDisplay(ReturnHtml[1]);
                document.getElementById(disk_edit_ajax).reset();
            }
        });
    }
}

function ChangeParent(parent_id, menu_disk_id) {
    var str2 = "diskedit_ajax_";
    var disk_edit_ajax = str2.concat(menu_disk_id);
    if (menu_disk_id === "") {
        $("#disk_edit_ajax").html("");
        return;
    } else {
        $.ajax({
            // The URL for the request
            url: "db_menu_disk.php",
            data: "action=change_menu_disk_parent&parent_id=" + parent_id + "&menu_disk_id=" + menu_disk_id,
            type: "POST",
            dataType: "html",
            // Code to run if the request succeeds;
            success: function(html) {
                var ReturnHtml = html.split('[BRK]');
                $("#" + disk_edit_ajax).html(ReturnHtml[0]);
                OSDMessageDisplay(ReturnHtml[1]);
                document.getElementById(disk_edit_ajax).reset();
            }
        });
    }
}
// Are you sure question Delete
function DeleteGamefromMenuButton(str, menu_disk_id) {
    $("#JSGenericModal").dialog({
        title: "Delete Title",
        open: $("#JSGenericModalText").text("Are you sure you want to delete this title from the menu disk?"),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            "Delete title": function() {
                $(this).dialog("close");
                DeleteGamefromMenu(str, menu_disk_id);
            },
            Cancel: function() {
                $(this).dialog("close");
                $("#menu_disk_title_id" + str).prop("checked", false);
            }
        }
    });
}

function DeleteGamefromMenu(menu_disk_title_id, menu_disk_id) {
    if (menu_disk_title_id === "") {
        $("#JSMenuSoftwareList").html("");
        return;
    } else {
        $.ajax({
            // The URL for the request
            url: "db_menu_disk.php",
            data: "action=delete_from_menu_disk&menu_disk_title_id=" + menu_disk_title_id + "&menu_disk_id=" + menu_disk_id,
            type: "POST",
            dataType: "html",
            // Code to run if the request succeeds;
            success: function(html) {
                var ReturnHtml = html.split('[BRK]');
                $("#JSMenuSoftwareList").html(ReturnHtml[0]);
                OSDMessageDisplay(ReturnHtml[1]);
            }
        });
    }
}

function DeleteMenuDiskModal(menu_disk_id) {
    $("#JSGenericModal").dialog({
        title: "Delete Disk?",
        open: $("#JSGenericModalText").text("Are you sure you want to delete this menu disk?"),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            "Delete disk": function() {
                $(this).dialog("close");
                DeleteMenuDisk(menu_disk_id);
            },
            Cancel: function() {
                $(this).dialog("close");
            }
        }
    });
}

function DeleteMenuDisk(menu_disk_id) {
    var str2 = "diskedit_ajax_";
    var disk_edit_ajax = str2.concat(menu_disk_id);
    $.ajax({
        // The URL for the request
        url: "db_menu_disk.php",
        data: "action=delete_menu_disk&menu_disk_id=" + menu_disk_id,
        type: "POST",
        dataType: "html",
        // Code to run if the request succeeds;
        success: function(html) {
            if (html == "Menudisk completely removed") {
                $("#" + disk_edit_ajax).html("");
            }
            OSDMessageDisplay(html);
        }
    });
}

function DeleteMenuSetIndividualModal(ind_select,menu_sets_id) {
    $("#JSGenericModal").dialog({
        title: "Delete Individual?",
        open: $("#JSGenericModalText").text("Are you sure you want to delete this Individual from the Menu Set?"),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            "Delete disk": function() {
                $(this).dialog("close");
                url = "db_menu_disk.php?menu_sets_id=" + menu_sets_id +"&ind_id=" + ind_select + "&action=delete_ind_from_menu_set";
                location.href = url;
            },
            Cancel: function() {
                $(this).dialog("close");
            }
        }
    });
}

function DeleteMenuSetCrewModal(crew_select,menu_sets_id) {
    $("#JSGenericModal").dialog({
        title: "Delete Crew?",
        open: $("#JSGenericModalText").text("Are you sure you want to delete this Crew from the Menu Set?"),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            "Delete disk": function() {
                $(this).dialog("close");
                url = "db_menu_disk.php?menu_sets_id=" + menu_sets_id + "&crew_id=" + crew_select + "&action=delete_crew_from_menu_set";
                location.href = url;
            },
            Cancel: function() {
                $(this).dialog("close");
            }
        }
    });
}

function MenuTypeDelete(menu_type_select,menu_sets_id) {
    $("#JSGenericModal").dialog({
        title: "Delete menu type?",
        open: $("#JSGenericModalText").text("Are you sure you want to delete this menu type from this menu set?"),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            "Delete disk": function() {
                $(this).dialog("close");
                url = "db_menu_disk.php?menu_sets_id=" + menu_sets_id + "&menu_type_id=" + menu_type_select + "&action=delete_menu_type_from_menu_set";
                location.href = url;
            },
            Cancel: function() {
                $(this).dialog("close");
            }
        }
    });
}

function deleteScreenshotfromMenu(str, menu_disk_id) {
    $("#JSGenericModal").dialog({
        title: "Delete Screenshot?",
        open: $("#JSGenericModalText").text("Are you sure you want to delete this screenshot from this menu disk?"),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            "Delete": function() {
                $(this).dialog("close");
                $.ajax({
                    // The URL for the request
                    url: "db_menu_disk.php",
                    data: "action=delete_screen_from_menu_disk&screenshot_id=" + str + "&menu_disk_id=" + menu_disk_id,
                    type: "POST",
                    dataType: "html",
                    // Code to run if the request succeeds;
                    success: function(html) {
                        var ReturnHtml = html.split('[BRK]');
                        $("#JSMenuSoftwareList").html(ReturnHtml[0]);
                        OSDMessageDisplay(ReturnHtml[1]);
                    }
                });
            },
            Cancel: function() {
                $(this).dialog("close");
                $("#JSMenuScreenshotList").html("");
            }
        }
    });
}

function deleteDownload(str, menu_disk_id) {
    $("#JSGenericModal").dialog({
        title: "Delete download?",
        open: $("#JSGenericModalText").text("Are you sure you want to delete this download from this menu disk?"),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            "Delete": function() {
                $(this).dialog("close");
                $.ajax({
                    // The URL for the request
                    url: "db_menu_disk.php",
                    data: "action=delete_download_from_menu_disk&menu_disk_download_id=" + str + "&menu_disk_id=" + menu_disk_id,
                    type: "POST",
                    dataType: "html",
                    // Code to run if the request succeeds;
                    success: function(html) {
                        var ReturnHtml = html.split('[BRK]');
                        $("#JSMenuFileList").html(ReturnHtml[0]);
                        OSDMessageDisplay(ReturnHtml[1]);
                    }
                });
            },
            Cancel: function() {
                $(this).dialog("close");
            }
        }
    });
}

function deleteDocfromMenu(str, menu_disk_id) {
    document.getElementById("menu_disk_title_id" + str).checked = false;
    $("#JSGenericModal").dialog({
        title: "Delete Doc title?",
        open: $("#JSGenericModalText").text("Are you sure you want to delete this doc title from this menu disk?"),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            "Delete": function() {
                $(this).dialog("close");
                $.ajax({
                    // The URL for the request
                    url: "db_menu_disk.php",
                    data: "action=delete_doc_from_menu_disk&menu_disk_title_id=" + str + "&menu_disk_id=" + menu_disk_id,
                    type: "POST",
                    dataType: "html",
                    // Code to run if the request succeeds;
                    success: function(html) {
                        var ReturnHtml = html.split('[BRK]');
                        $("#menu_doc_list").html(ReturnHtml[0]);
                        OSDMessageDisplay(ReturnHtml[1]);
                    }
                });
            },
            Cancel: function() {
                $(this).dialog("close");
                $("#menu_doc_list").html("");
            }
        }
    });
}

function DeleteSet(str) {
    $("#JSGenericModal").dialog({
        title: "Delete menu set?",
        open: $("#JSGenericModalText").text("Are you sure you want to delete this set?"),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            "Delete disk": function() {
                $(this).dialog("close");
                url = "../menus/db_menu_disk.php?action=delete_set&menu_sets_id=" + str;
                location.href = url;
            },
            Cancel: function() {
                $(this).dialog("close");
            }
        }
    });
}

function PublishSet(str, action) {
    $("#JSGenericModal").dialog({
        title: "Change Status?",
        open: $("#JSGenericModalText").text("Are you sure you want to change status on this set?"),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            "Change": function() {
                $(this).dialog("close");
                url = "../menus/db_menu_disk.php?action=publish_set&online=" + action + "&menu_sets_id=" + str;
                location.href = url;
            },
            Cancel: function() {
                $(this).dialog("close");
            }
        }
    });
}

function DeleteCredits(menu_disk_credits_id, menu_disk_id) {
    $("#JSGenericModal").dialog({
        title: "Delete from credits?",
        open: $("#JSGenericModalText").text("Are you sure you want to delete this person from the credit list?"),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            "Delete": function() {
                $(this).dialog("close");
                $.ajax({
                    // The URL for the request
                    url: "db_menu_disk.php",
                    data: "action=delete_menu_disk_credits&menu_disk_credits_id=" + menu_disk_credits_id + "&menu_disk_id=" + menu_disk_id,
                    type: "POST",
                    dataType: "html",
                    // Code to run if the request succeeds;
                    success: function(html) {
                        var ReturnHtml = html.split('[BRK]');
                        $("#menu_credit_list").html(ReturnHtml[0]);
                        OSDMessageDisplay(ReturnHtml[1]);
                        document.getElementById("menu_credit_list").reset();
                    }
                });
            },
            Cancel: function() {
                $(this).dialog("close");
            }
        }
    });
}

function DeleteTitleCredits(menu_disk_title_id, ind_id, author_type_id) {
    $("#JSGenericModal").dialog({
        title: "Delete from credits?",
        open: $("#JSGenericModalText").text("Are you sure you want to delete this person from the title credit list?"),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            "Delete": function() {
                $(this).dialog("close");
                $.ajax({
                    // The URL for the request
                    url: "db_menu_disk.php",
                    data: "action=delete_menu_disk_title_credits&menu_disk_title_id=" + menu_disk_title_id + "&author_type_id=" + author_type_id + "+&ind_id=" + ind_id,
                    type: "POST",
                    dataType: "html",
                    // Code to run if the request succeeds;
                    success: function(html) {
                        var ReturnHtml = html.split('[BRK]');
                        $("#author_list").html(ReturnHtml[0]);
                        OSDMessageDisplay(ReturnHtml[1]);
                        document.getElementById("author_list").reset();
                    }
                });
            },
            Cancel: function() {
                $(this).dialog("close");
            }
        }
    });
}

/*!
 * menus.js
 * http://www.atarilegend.com
 *
 */

window.editDisk = function (str) {
    var diskEditAjax = 'diskedit_ajax_'.concat(str);
    $.ajax({
        // The URL for the request
        url: 'ajax_menus_detail.php',
        data: 'action=edit_disk_box&menu_disk_id=' + str,
        type: 'GET',
        dataType: 'html',
        // Code to run if the request succeeds;
        success: function (html) {
            $('#' + diskEditAjax).html(html);
        }
    });
}

window.closeeditDisk = function (str) {
    var diskEditAjax = 'diskedit_ajax_'.concat(str);
    $.ajax({
        // The URL for the request
        url: 'ajax_menus_detail.php',
        data: 'action=close_edit_disk_box&menu_disk_id=' + str,
        type: 'GET',
        dataType: 'html',
        // Code to run if the request succeeds;
        success: function (html) {
            $('#' + diskEditAjax).html(html);
        }
    });
}

window.popAddGames = function (str) {
    if (str === '') {
        $('#JSMenuDetailExpandGames').html('');
    } else {
        $.ajax({
            // The URL for the request
            url: 'ajax_addgames_menus.php',
            data: 'action=game_browse&list=full&query=num&menu_disk_id=' + str,
            type: 'GET',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                $('#JSMenuDetailExpandGames').html(html);
                $('#gameto_menu_link').html('<a onclick="closeAddGames(' + str + ')" style="cursor: pointer;" class="MAINNAV">Add Game/Tool/Demo to menu</a>');
                gameSearchListen();
            }
        });
    }
}

window.closeAddGames = function (str) {
    $('#JSMenuDetailExpandGames').html('');
    $('#gameto_menu_link').html('<a onclick="popAddGames(' + str + ')" style="cursor: pointer;" class="MAINNAV">Add Game/Tool/Demo to menu</a>');
}

function searchingGame (GameSearchAction) {
    var formValues = '';
    if (GameSearchAction === 'game_browse') {
        formValues = $('#game_search_menu').serialize() + '&action=game_browse&list=inner&query=' + $('.JSGameBrowse').val();
    } else {
        if (GameSearchAction === 'game_search') {
            formValues = $('#game_search_menu').serialize() + '&action=game_search&list=inner&query=' + $('.JSGameSearch').val();
        }
    }
    $.ajaxQueue({
        // The URL for the request
        url: 'ajax_addgames_menus.php',
        data: formValues,
        type: 'GET',
        dataType: 'html',
        // Code to run if the request succeeds;
        success: function (html) {
            $('#game_list').html(html);
        }
    });
}

function gameSearchListen () {
    $('.JSGameBrowse').change(function () {
        searchingGame('game_browse');
    });

    $('.JSGameSearch').keyup(function () {
        var value = $(this).val();
        if (value.length >= 3) {
            searchingGame('game_search');
        }
    });
}

function searchingDoc (DocSearchAction) {
    var formValues = '';
    if (DocSearchAction === 'doc_browse') {
        formValues = $('#doc_search_menu').serialize() + '&action=game_browse&list=inner&query=' + $('.JSDocBrowse').val();
    } else {
        if (DocSearchAction === 'doc_search') {
            formValues = $('#doc_search_menu').serialize() + '&action=game_search&list=inner&query=' + $('.JSDocSearch').val();
        }
    }
    $.ajaxQueue({
        // The URL for the request
        url: 'ajax_adddocs_menus.php',
        data: formValues,
        type: 'GET',
        dataType: 'html',
        // Code to run if the request succeeds;
        success: function (html) {
            $('#doc_list').html(html);
        }
    });
}

function docSearchListen () {
    $('.JSDocBrowse').change(function () {
        searchingDoc('doc_browse');
    });

    $('.JSDocSearch').keyup(function () {
        var value = $(this).val();
        if (value.length >= 3) {
            searchingDoc('doc_search');
        }
    });
}

window.addGametoMenu = function (softwareId, menuDiskId, softwareType) {
    if (softwareId === '') {
        $('#JSMenuSoftwareList').html('');
    } else {
        $.ajax({
            // The URL for the request
            url: 'db_menu_disk.php',
            data: 'action=add_title_to_menu&software_id=' + softwareId + '&menu_disk_id=' + menuDiskId + '&software_type=' + softwareType,
            type: 'POST',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                var returnHtml = html.split('[BRK]');
                $('#JSMenuSoftwareList').html(returnHtml[0]);
                window.OSDMessageDisplay(returnHtml[1]);
            }
        });
    }
}

window.addNewdisk = function (str) {
    if (str === '') {
        $('#new_disk').html('');
    } else {
        $.ajax({
            // The URL for the request
            url: 'ajax_menus.php',
            data: 'action=add_new_disk_box&menu_sets_id=' + str,
            type: 'POST',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                $('#new_disk').html(html);
                $('#close_new_disk').html('<a onclick="closeaddNewdisk(' + str + ')" style="cursor: pointer;" class="MAINNAV">Add New Disk</a>');
            }
        });
    }
}

window.closeaddNewdisk = function (str) {
    $('#new_disk').html('');
    $('#close_new_disk').html('<a onclick="addNewdisk(' + str + ')" style="cursor: pointer;" class="MAINNAV">Add New Disk</a>');
}

window.myFunction = function () {
    $('input:file[id=file_upload]').change(function () {
        document.getElementById('file_upload_game_screenshots').value = 'file(s) selected';
    });
    $('input:file[id=file_upload2]').change(function () {
        document.getElementById('file_upload_game_file').value = $(this).val();
    });
}

window.browseCrew = function (str) {
    if (str === '') {
        $('#option_crew').html('');
    } else {
        $.ajax({
            // The URL for the request
            url: 'ajax_menus.php',
            data: 'action=crew_browse&query=' + str,
            type: 'GET',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                $('#option_crew').html(html);
            }
        });
    }
}

window.browseIndividual = function (str) {
    if (str === '') {
        $('#option_ind').html('');
    } else {
        $.ajax({
            // The URL for the request
            url: 'ajax_menus.php',
            data: 'action=ind_browse&query=' + str,
            type: 'GET',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                $('#option_ind').html(html);
            }
        });
    }
}

window.browseInd = function (str) {
    if (str === '') {
        $('#ind_member').html('');
    } else {
        $.ajaxQueue({
            // The URL for the request
            url: 'ajax_menus_detail.php',
            data: 'action=ind_gen_browse&query=' + str,
            type: 'GET',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                $('#ind_member').html(html);
            }
        });
    }
}

window.searchInd = function (str) {
    if (str === '') {
        $('#ind_member').html('');
    } else {
        $.ajaxQueue({
            // The URL for the request
            url: 'ajax_menus_detail.php',
            data: 'action=ind_gen_search&query=' + str,
            type: 'GET',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                $('#ind_member').html(html);
            }
        });
    }
}

window.popAddIntroCred = function (str) {
    if (str === '') {
        $('#menu_detail_expand').html('');
    } else {
        $.ajax({
            // The URL for the request
            url: 'ajax_menus_detail.php',
            data: 'action=add_intro_credit&query=' + str,
            type: 'GET',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                $('#menu_detail_expand').html(html);
                $('#intro_credit_link').html('<a onclick="closeAddIntroCred(' + str + ')" style="cursor: pointer;" class="MAINNAV">Add intro credits</a>');
            }
        });
    }
}

window.closeAddIntroCred = function (str) {
    $('#menu_detail_expand').html('');
    $('#intro_credit_link').html('<a onclick="popAddIntroCred(' + str + ')" style="cursor: pointer;" class="MAINNAV">Add intro credits</a>');
}

window.popAddAuthorMenutitle = function (menuDiskTitleId, gameId, gameName) {
    if (menuDiskTitleId === '') {
        $('#menu_detail_expand_author_title').html('');
    } else {
        $.ajaxQueue({
            // The URL for the request
            url: 'ajax_add_author_menutitle.php',
            data: 'menu_disk_title_id=' + menuDiskTitleId + '&game_name=' + gameName + '&game_id=' + gameId,
            type: 'GET',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                $('#menu_detail_expand_author_title').html(html);
                $('#author_to_menu_title' + gameId).html('<a onclick="closeAddAuthor(' + menuDiskTitleId + ',' + gameId + ',' + gameName + ')" style="cursor: pointer;" class="standard_tile_link">' + gameName + '</a>');
            }
        });
    }
}

window.closeAddAuthor = function (menuDiskTitleId, gameId, gameName) {
    $('#menu_detail_expand_author_title').html('');
    $('#author_to_menu_title' + gameId).html('<a onclick="popAddAuthorMenutitle(' + menuDiskTitleId + ',' + gameId + ',' + gameName + ')" style="cursor: pointer;" class="standard_tile_link">' + gameName + '</a>');
}

window.popAddAuthorMenutitleDoc = function (menuDiskTitleId, gameId, gameName) {
    if (menuDiskTitleId === '') {
        $('#menu_detail_expand_author_title_doc').html('');
    } else {
        $.ajax({
            // The URL for the request
            url: 'ajax_add_author_menutitle.php',
            data: 'menu_disk_title_id=' + menuDiskTitleId + '&game_name=' + gameName + '&game_id=' + gameId,
            type: 'GET',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                $('#menu_detail_expand_author_title_doc').html(html);
                $('#author_to_menu_title_doc' + gameId).html('<a onclick="closeAddAuthorDoc(' + menuDiskTitleId + ',' + gameId + ',' + gameName + ')" style="cursor: pointer;" class="standard_tile_link">' + gameName + '</a>');
            }
        });
    }
}

window.closeAddAuthorDoc = function (menuDiskTitleId, gameId, gameName) {
    $('#menu_detail_expand_author_title_doc').html('');
    $('#author_to_menu_title_doc' + gameId).html('<a onclick="popAddAuthorMenutitleDoc(' + menuDiskTitleId + ',' + gameId + ',' + gameName + ')" style="cursor: pointer;" class="standard_tile_link">' + gameName + '</a>');
}

window.popAddDocs = function (str) {
    if (str === '') {
        $('#menu_detail_expand_docs').html('');
    } else {
        $.ajax({
            // The URL for the request
            url: 'ajax_adddocs_menus.php',
            data: 'action=game_browse&list=full&query=num&menu_disk_id=' + str,
            type: 'GET',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                $('#menu_detail_expand_docs').html(html);
                $('#docto_menu_link').html('<a onclick="closeAddDocs(' + str + ')" style="cursor: pointer;" class="MAINNAV">Add Doc to menu</a>');
                docSearchListen();
            }
        });
    }
}

window.closeAddDocs = function (str) {
    $('#menu_detail_expand_docs').html('');
    $('#docto_menu_link').html('<a onclick="popAddDocs(' + str + ')" style="cursor: pointer;" class="MAINNAV">Add Doc to menu</a>');
}

window.popAddScreenshots = function (str) {
    if (str === '') {
        $('#JSMenuDetailExpandScreenshots').html('');
    } else {
        $.ajax({
            // The URL for the request
            url: 'ajax_addscreenshots_menus.php',
            data: 'menu_disk_id=' + str,
            type: 'GET',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                $('#JSMenuDetailExpandScreenshots').html(html);
                $('#screenshot_link').html('<a onclick="closeAddScreenshots(' + str + ')" style="cursor: pointer;" class="MAINNAV">Add Screenshots to menu</a>');
            }
        });
    }
}

window.closeAddScreenshots = function (str) {
    $('#JSMenuDetailExpandScreenshots').html('');
    $('#screenshot_link').html('<a onclick="popAddScreenshots(' + str + ')" style="cursor: pointer;" class="MAINNAV">Add Screenshots to menu</a>');
}

window.popAddFile = function (str) {
    if (str === '') {
        $('#JSMenuDetailExpandFile').html('');
    } else {
        $.ajax({
            // The URL for the request
            url: 'ajax_addfile_menus.php',
            data: 'menu_disk_id=' + str,
            type: 'GET',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                $('#JSMenuDetailExpandFile').html(html);
                $('#file_link').html('<a onclick="closeAddFile(' + str + ')" style="cursor: pointer;" class="MAINNAV">Add File to menu</a>');
            }
        });
    }
}

window.closeAddFile = function (str) {
    $('#JSMenuDetailExpandFile').html('');
    $('#file_link').html('<a onclick="popAddFile(' + str + ')" style="cursor: pointer;" class="MAINNAV">Add File to menu</a>');
}

function addslashes (str) {
    /* eslint-disable-next-line no-control-regex */
    return (str + '').replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0');
}

window.popAddSet = function (str, menuDiskId, titleName) {
    if (str === '') {
        $('#JSMenuDetailExpandSet').html('');
    } else {
        $.ajax({
            // The URL for the request
            url: 'ajax_addset_menus.php',
            data: 'menu_disk_title_id=' + str + '&menu_disk_id=' + menuDiskId + '&title_name=' + titleName,
            type: 'GET',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                $('#JSMenuDetailExpandSet').html(html);
                var title = addslashes(titleName);
                $('#' + str).html('<a onclick="closeAddSet(' + str + ',' + menuDiskId + ',' + title + ')" style="cursor: pointer;" class="standard_tile_link">Add</a>');
            }
        });
        var elementExists = document.getElementById('set_chain_update');
        if (typeof (elementExists) !== 'undefined' && elementExists !== null) {
            $('#set_chain_update').html('');
        }
    }
}

window.closeAddSet = function (str, menuDiskId, titleName) {
    var title = addslashes(titleName);
    $('#JSMenuDetailExpandSet').html('');
    $('#' + str).html('<a onclick="popAddSet(' + str + ',' + menuDiskId + ',' + title + ')" style="cursor: pointer;" class="standard_tile_link">Add</a>');
}

window.addAuthorstoMenutitle = function (menuDiskTitleId) {
    if (menuDiskTitleId === '') {
        $('#author_list').html('');
    } else {
        var formValues = $('#authors_form').serialize();
        $.ajax({
            // The URL for the request
            url: 'db_menu_disk.php',
            data: formValues,
            type: 'POST',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                var returnHtml = html.split('[BRK]');
                $('#author_list').html(returnHtml[0]);
                window.OSDMessageDisplay(returnHtml[1]);
            }
        });
    }
}

window.addDoctoMenu = function (softwareId, menuDiskId, softwareType) {
    if (softwareId === '') {
        $('#menu_doc_list').html('');
    } else {
        $.ajax({
            // The URL for the request
            url: 'db_menu_disk.php',
            data: 'action=add_doc_to_menu&software_id=' + softwareId + '&menu_disk_id=' + menuDiskId + '&software_type=' + softwareType,
            type: 'POST',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                var returnHtml = html.split('[BRK]');
                $('#menu_doc_list').html(returnHtml[0]);
                window.OSDMessageDisplay(returnHtml[1]);
            }
        });
    }
}

window.addScreenshottoMenu = function (menuDiskId) {
    if (menuDiskId === '') {
        $('#JSMenuScreenshotList').html('');
    } else {
        var form = $('#screenshot_add_to_menu')[0];
        var formValues = new FormData(form);

        $.ajax({
            // The URL for the request
            url: 'db_menu_disk.php',
            data: formValues,
            type: 'POST',
            contentType: false,
            processData: false,
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                var returnHtml = html.split('[BRK]');
                $('#JSMenuScreenshotList').html(returnHtml[0]);
                window.OSDMessageDisplay(returnHtml[1]);
                document.getElementById('screenshot_add_to_menu').reset();
            }
        });
    }
}

window.addFiletoMenu = function (menuDiskId) {
    if (menuDiskId === '') {
        $('#JSMenuFileList').html('');
    } else {
        var form = $('#file_add_to_menu')[0];
        var formValues = new FormData(form);

        $.ajax({
            // The URL for the request
            url: 'db_menu_disk.php',
            data: formValues,
            type: 'POST',
            contentType: false,
            processData: false,
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                var returnHtml = html.split('[BRK]');
                $('#JSMenuFileList').html(returnHtml[0]);
                window.OSDMessageDisplay(returnHtml[1]);
                document.getElementById('File_add_to_menu').reset();
            }
        });
    }
}

window.linkChain = function (menuDiskTitleId, menuDiskId) {
    if (menuDiskTitleId === '') {
        $('#JSMenuSoftwareList').html('');
    } else {
        var formValues = $('#link_game_to_set').serialize();
        $.ajax({
            // The URL for the request
            url: 'db_menu_disk.php',
            data: formValues,
            type: 'POST',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                var returnHtml = html.split('[BRK]');
                $('#JSMenuSoftwareList').html(returnHtml[0]);
                window.OSDMessageDisplay(returnHtml[1]);
                $('#JSMenuDetailExpandSet').html('');
            }
        });
    }
}

window.deleteChain = function (menuDiskTitleId, menuDiskId, titleName) {
    if (menuDiskTitleId === '') {
        $('#JSMenuSoftwareList').html('');
    } else {
        $.ajax({
            // The URL for the request
            url: 'db_menu_disk.php',
            data: 'action=delete_game_from_set&menu_disk_title_id=' + menuDiskTitleId + '&menu_disk_id=' + menuDiskId + '&title_name=' + titleName,
            type: 'POST',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                var returnHtml = html.split('[BRK]');
                $('#JSMenuSoftwareList').html(returnHtml[0]);
                window.OSDMessageDisplay(returnHtml[1]);
                $('#JSMenuDetailExpandSet').html('');
            }
        });
    }
}

window.createChain = function (str, menuDiskId) {
    if (str === '') {
        $('#JSMenuSoftwareList').html('');
    } else {
        $.ajax({
            // The URL for the request
            url: 'db_menu_disk.php',
            data: 'action=add_set_to_menu&menu_disk_title_id=' + str + '&menu_disk_id=' + menuDiskId,
            type: 'POST',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                var returnHtml = html.split('[BRK]');
                $('#JSMenuSoftwareList').html(returnHtml[0]);
                window.OSDMessageDisplay(returnHtml[1]);
                $('#JSMenuDetailExpandSet').html('');
            }
        });
    }
}

window.addCreditstoMenu = function (menuDiskId) {
    if (menuDiskId === '') {
        $('#menu_credit_list').html('');
    } else {
        var indId = document.getElementById('menu_credits_form').elements.namedItem('ind_id').value;
        var authorTypeId = document.getElementById('menu_credits_form').elements.namedItem('author_type_id').value;
        $.ajax({
            // The URL for the request
            url: 'db_menu_disk.php',
            data: 'action=add_intro_credits&author_type_id=' + authorTypeId + '&menu_disk_id=' + menuDiskId + '&ind_id=' + indId,
            type: 'POST',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                var returnHtml = html.split('[BRK]');
                $('#menu_credit_list').html(returnHtml[0]);
                window.OSDMessageDisplay(returnHtml[1]);
                document.getElementById('menu_credit_list').reset();
            }
        });
    }
}

window.changeState = function (stateId, menuDiskId) {
    var str2 = 'diskedit_ajax_';
    var diskEditAjax = str2.concat(menuDiskId);
    if (menuDiskId === '') {
        $('#' + diskEditAjax).html('');
    } else {
        $.ajax({
            // The URL for the request
            url: 'db_menu_disk.php',
            data: 'action=change_menu_disk_state&state_id=' + stateId + '&menu_disk_id=' + menuDiskId,
            type: 'POST',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                var returnHtml = html.split('[BRK]');
                $('#' + diskEditAjax).html(returnHtml[0]);
                window.OSDMessageDisplay(returnHtml[1]);
                document.getElementById(diskEditAjax).reset();
            }
        });
    }
}

window.changeDoctype = function (docTypeId, docId, menuDiskId) {
    if (docTypeId === '') {
        $('#menu_doc_list').html('');
    } else {
        $.ajax({
            // The URL for the request
            url: 'db_menu_disk.php',
            data: 'action=change_doctype&doc_type_id=' + docTypeId + '&doc_id=' + docId + '&menu_disk_id=' + menuDiskId,
            type: 'POST',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                var returnHtml = html.split('[BRK]');
                $('#menu_doc_list').html(returnHtml[0]);
                window.OSDMessageDisplay(returnHtml[1]);
                document.getElementById('menu_doc_list').reset();
            }
        });
    }
}

window.changeYear = function (yearId, menuDiskId) {
    var str2 = 'diskedit_ajax_';
    var diskEditAjax = str2.concat(menuDiskId);
    if (menuDiskId === '') {
        $('#' + diskEditAjax).html('');
    } else {
        $.ajax({
            // The URL for the request
            url: 'db_menu_disk.php',
            data: 'action=change_menu_disk_year&year_id=' + yearId + '&menu_disk_id=' + menuDiskId,
            type: 'POST',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                var returnHtml = html.split('[BRK]');
                $('#' + diskEditAjax).html(returnHtml[0]);
                window.OSDMessageDisplay(returnHtml[1]);
                document.getElementById(diskEditAjax).reset();
            }
        });
    }
}

window.changeParent = function (parentId, menuDiskId) {
    var str2 = 'diskedit_ajax_';
    var diskEditAjax = str2.concat(menuDiskId);
    if (menuDiskId === '') {
        $('#disk_edit_ajax').html('');
    } else {
        $.ajax({
            // The URL for the request
            url: 'db_menu_disk.php',
            data: 'action=change_menu_disk_parent&parent_id=' + parentId + '&menu_disk_id=' + menuDiskId,
            type: 'POST',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                var returnHtml = html.split('[BRK]');
                $('#' + diskEditAjax).html(returnHtml[0]);
                window.OSDMessageDisplay(returnHtml[1]);
                document.getElementById(diskEditAjax).reset();
            }
        });
    }
}
// Are you sure question Delete
window.deleteGamefromMenuButton = function (str, menuDiskId) {
    $('#JSGenericModal').dialog({
        title: 'Delete Title',
        open: $('#JSGenericModalText').text('Are you sure you want to delete this title from the menu disk?'),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            'Delete title': function () {
                $(this).dialog('close');
                deleteGamefromMenu(str, menuDiskId);
            },
            Cancel: function () {
                $(this).dialog('close');
                $('#menu_disk_title_id' + str).prop('checked', false);
            }
        }
    });
}

function deleteGamefromMenu (menuDiskTitleId, menuDiskId) {
    if (menuDiskTitleId === '') {
        $('#JSMenuSoftwareList').html('');
    } else {
        $.ajax({
            // The URL for the request
            url: 'db_menu_disk.php',
            data: 'action=delete_from_menu_disk&menu_disk_title_id=' + menuDiskTitleId + '&menu_disk_id=' + menuDiskId,
            type: 'POST',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                var returnHtml = html.split('[BRK]');
                $('#JSMenuSoftwareList').html(returnHtml[0]);
                window.OSDMessageDisplay(returnHtml[1]);
            }
        });
    }
}

window.deleteMenuDiskModal = function (menuDiskId) {
    $('#JSGenericModal').dialog({
        title: 'Delete Disk?',
        open: $('#JSGenericModalText').text('Are you sure you want to delete this menu disk?'),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            'Delete disk': function () {
                $(this).dialog('close');
                deleteMenuDisk(menuDiskId);
            },
            Cancel: function () {
                $(this).dialog('close');
            }
        }
    });
}

function deleteMenuDisk (menuDiskId) {
    var str2 = 'diskedit_ajax_';
    var diskEditAjax = str2.concat(menuDiskId);
    $.ajax({
        // The URL for the request
        url: 'db_menu_disk.php',
        data: 'action=delete_menu_disk&menu_disk_id=' + menuDiskId,
        type: 'POST',
        dataType: 'html',
        // Code to run if the request succeeds;
        success: function (html) {
            if (html === 'Menudisk completely removed') {
                $('#' + diskEditAjax).html('');
            }
            window.OSDMessageDisplay(html);
        }
    });
}

window.deleteMenuSetIndividualModal = function (indSelect, menuSetsId) {
    $('#JSGenericModal').dialog({
        title: 'Delete Individual?',
        open: $('#JSGenericModalText').text('Are you sure you want to delete this Individual from the Menu Set?'),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            'Delete disk': function () {
                $(this).dialog('close');
                var url = 'db_menu_set.php?menu_sets_id=' + menuSetsId + '&ind_id=' + indSelect + '&action=delete_ind_from_menu_set';
                location.href = url;
            },
            Cancel: function () {
                $(this).dialog('close');
            }
        }
    });
}

window.deleteMenuSetCrewModal = function (crewSelect, menuSetsId) {
    $('#JSGenericModal').dialog({
        title: 'Delete Crew?',
        open: $('#JSGenericModalText').text('Are you sure you want to delete this Crew from the Menu Set?'),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            'Delete disk': function () {
                $(this).dialog('close');
                var url = 'db_menu_set.php?menu_sets_id=' + menuSetsId + '&crew_id=' + crewSelect + '&action=delete_crew_from_menu_set';
                location.href = url;
            },
            Cancel: function () {
                $(this).dialog('close');
            }
        }
    });
}

window.menuTypeDelete = function (menuTypeSelect, menuSetsId) {
    $('#JSGenericModal').dialog({
        title: 'Delete menu type?',
        open: $('#JSGenericModalText').text('Are you sure you want to delete this menu type from this menu set?'),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            'Delete disk': function () {
                $(this).dialog('close');
                var url = 'db_menu_set.php?menu_sets_id=' + menuSetsId + '&menu_type_id=' + menuTypeSelect + '&action=delete_menu_type_from_menu_set';
                location.href = url;
            },
            Cancel: function () {
                $(this).dialog('close');
            }
        }
    });
}

window.deleteScreenshotfromMenu = function (str, menuDiskId) {
    $('#JSGenericModal').dialog({
        title: 'Delete Screenshot?',
        open: $('#JSGenericModalText').text('Are you sure you want to delete this screenshot from this menu disk?'),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            'Delete': function () {
                $(this).dialog('close');
                $.ajax({
                    // The URL for the request
                    url: 'db_menu_disk.php',
                    data: 'action=delete_screen_from_menu_disk&screenshot_id=' + str + '&menu_disk_id=' + menuDiskId,
                    type: 'POST',
                    dataType: 'html',
                    // Code to run if the request succeeds;
                    success: function (html) {
                        var returnHtml = html.split('[BRK]');
                        $('#JSMenuScreenshotList').html(returnHtml[0]);
                        window.OSDMessageDisplay(returnHtml[1]);
                    }
                });
            },
            Cancel: function () {
                $(this).dialog('close');
                $('#JSMenuScreenshotList').html('');
            }
        }
    });
}

window.deleteDownload = function (str, menuDiskId) {
    $('#JSGenericModal').dialog({
        title: 'Delete download?',
        open: $('#JSGenericModalText').text('Are you sure you want to delete this download from this menu disk?'),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            'Delete': function () {
                $(this).dialog('close');
                $.ajax({
                    // The URL for the request
                    url: 'db_menu_disk.php',
                    data: 'action=delete_download_from_menu_disk&menu_disk_download_id=' + str + '&menu_disk_id=' + menuDiskId,
                    type: 'POST',
                    dataType: 'html',
                    // Code to run if the request succeeds;
                    success: function (html) {
                        var returnHtml = html.split('[BRK]');
                        $('#JSMenuFileList').html(returnHtml[0]);
                        window.OSDMessageDisplay(returnHtml[1]);
                    }
                });
            },
            Cancel: function () {
                $(this).dialog('close');
            }
        }
    });
}

window.deleteDocfromMenu = function (str, menuDiskId) {
    document.getElementById('menu_disk_title_id' + str).checked = false;
    $('#JSGenericModal').dialog({
        title: 'Delete Doc title?',
        open: $('#JSGenericModalText').text('Are you sure you want to delete this doc title from this menu disk?'),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            'Delete': function () {
                $(this).dialog('close');
                $.ajax({
                    // The URL for the request
                    url: 'db_menu_disk.php',
                    data: 'action=delete_doc_from_menu_disk&menu_disk_title_id=' + str + '&menu_disk_id=' + menuDiskId,
                    type: 'POST',
                    dataType: 'html',
                    // Code to run if the request succeeds;
                    success: function (html) {
                        var returnHtml = html.split('[BRK]');
                        $('#menu_doc_list').html(returnHtml[0]);
                        window.OSDMessageDisplay(returnHtml[1]);
                    }
                });
            },
            Cancel: function () {
                $(this).dialog('close');
                $('#menu_doc_list').html('');
            }
        }
    });
}

window.deleteSet = function (str) {
    $('#JSGenericModal').dialog({
        title: 'Delete menu set?',
        open: $('#JSGenericModalText').text('Are you sure you want to delete this set?'),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            'Delete disk': function () {
                $(this).dialog('close');
                var url = '../menus/db_menu_set.php?action=delete_set&menu_sets_id=' + str;
                location.href = url;
            },
            Cancel: function () {
                $(this).dialog('close');
            }
        }
    });
}

window.publishSet = function (str, action) {
    $('#JSGenericModal').dialog({
        title: 'Change Status?',
        open: $('#JSGenericModalText').text('Are you sure you want to change status on this set?'),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            'Change': function () {
                $(this).dialog('close');
                var url = '../menus/db_menu_set.php?action=publish_set&online=' + action + '&menu_sets_id=' + str;
                location.href = url;
            },
            Cancel: function () {
                $(this).dialog('close');
            }
        }
    });
}

window.deleteCredits = function (menuDiskCreditsId, menuDiskId) {
    $('#JSGenericModal').dialog({
        title: 'Delete from credits?',
        open: $('#JSGenericModalText').text('Are you sure you want to delete this person from the credit list?'),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            'Delete': function () {
                $(this).dialog('close');
                $.ajax({
                    // The URL for the request
                    url: 'db_menu_disk.php',
                    data: 'action=delete_menu_disk_credits&menu_disk_credits_id=' + menuDiskCreditsId + '&menu_disk_id=' + menuDiskId,
                    type: 'POST',
                    dataType: 'html',
                    // Code to run if the request succeeds;
                    success: function (html) {
                        var returnHtml = html.split('[BRK]');
                        $('#menu_credit_list').html(returnHtml[0]);
                        window.OSDMessageDisplay(returnHtml[1]);
                        document.getElementById('menu_credit_list').reset();
                    }
                });
            },
            Cancel: function () {
                $(this).dialog('close');
            }
        }
    });
}

window.deleteTitleCredits = function (menuDiskTitleId, indId, authorTypeId) {
    $('#JSGenericModal').dialog({
        title: 'Delete from credits?',
        open: $('#JSGenericModalText').text('Are you sure you want to delete this person from the title credit list?'),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            'Delete': function () {
                $(this).dialog('close');
                $.ajax({
                    // The URL for the request
                    url: 'db_menu_disk.php',
                    data: 'action=delete_menu_disk_title_credits&menu_disk_title_id=' + menuDiskTitleId + '&author_type_id=' + authorTypeId + '+&ind_id=' + indId,
                    type: 'POST',
                    dataType: 'html',
                    // Code to run if the request succeeds;
                    success: function (html) {
                        var returnHtml = html.split('[BRK]');
                        $('#author_list').html(returnHtml[0]);
                        window.OSDMessageDisplay(returnHtml[1]);
                        document.getElementById('author_list').reset();
                    }
                });
            },
            Cancel: function () {
                $(this).dialog('close');
            }
        }
    });
}

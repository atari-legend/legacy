/*!
 * menus.js
 * http://www.atarilegend.com
 *
 */

// This handles the queues
(function ($) {
    // jQuery on an empty object, we are going to use this as our Queue
    var ajaxQueue = $({});

    $.ajaxQueue = function (ajaxOpts) {
        var jqXHR,
            dfd = $.Deferred(),
            promise = dfd.promise();

        // run the actual query
        function doRequest (next) {
            jqXHR = $.ajax(ajaxOpts);
            jqXHR.done(dfd.resolve)
                .fail(dfd.reject)
                .then(next, next);
        }

        // queue our ajax request
        ajaxQueue.queue(doRequest);

        // add the abort method
        promise.abort = function (statusText) {
            // proxy abort to the jqXHR if it is active
            if (jqXHR) {
                return jqXHR.abort(statusText);
            }

            // if there wasn't already a jqXHR we need to remove from queue
            var queue = ajaxQueue.queue(),
                index = $.inArray(doRequest, queue);

            if (index > -1) {
                queue.splice(index, 1);
            }

            // and then reject the deferred
            dfd.rejectWith(ajaxOpts.context || ajaxOpts, [promise, statusText, '']);
            return promise;
        };

        return promise;
    };
})(jQuery);

function OSDMessageDisplay (message) {
    $.notify_osd.create({
        'text': message, // notification message
        'icon': '../../../themes/styles/1/images/osd_icons/star.png', // icon path, 48x48
        'sticky': false, // if true, timeout is ignored
        'timeout': 4, // disappears after 6 seconds
        'dismissable': true // can be dismissed manually
    });
}

var editDisk = function (str) {
    var DiskEditAjax = 'diskedit_ajax_'.concat(str);
    $.ajax({
        // The URL for the request
        url: 'ajax_menus_detail.php',
        data: 'action=edit_disk_box&menu_disk_id=' + str,
        type: 'GET',
        dataType: 'html',
        // Code to run if the request succeeds;
        success: function (html) {
            $('#' + DiskEditAjax).html(html);
        }
    });
}

function CloseeditDisk (str) {
    var DiskEditAjax = 'diskedit_ajax_'.concat(str);
    $.ajax({
        // The URL for the request
        url: 'ajax_menus_detail.php',
        data: 'action=close_edit_disk_box&menu_disk_id=' + str,
        type: 'GET',
        dataType: 'html',
        // Code to run if the request succeeds;
        success: function (html) {
            $('#' + DiskEditAjax).html(html);
        }
    });
}

function popAddGames (str) {
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
                GameSearchListen();
            }
        });
    }
}

function closeAddGames (str) {
    $('#JSMenuDetailExpandGames').html('');
    $('#gameto_menu_link').html('<a onclick="popAddGames(' + str + ')" style="cursor: pointer;" class="MAINNAV">Add Game/Tool/Demo to menu</a>');
}

function SearchingGame (GameSearchAction) {
    var FormValues = '';
    if (GameSearchAction === 'game_browse') {
        FormValues = $('#game_search_menu').serialize() + '&action=game_browse&list=inner&query=' + $('.JSGameBrowse').val();
    } else {
        if (GameSearchAction === 'game_search') {
            FormValues = $('#game_search_menu').serialize() + '&action=game_search&list=inner&query=' + $('.JSGameSearch').val();
        }
    }
    $.ajaxQueue({
        // The URL for the request
        url: 'ajax_addgames_menus.php',
        data: FormValues,
        type: 'GET',
        dataType: 'html',
        // Code to run if the request succeeds;
        success: function (html) {
            $('#game_list').html(html);
        }
    });
}

function GameSearchListen () {
    $('.JSGameBrowse').change(function () {
        SearchingGame('game_browse');
    });

    $('.JSGameSearch').keyup(function () {
        var value = $(this).val();
        if (value.length >= 3) {
            SearchingGame('game_search');
        }
    });
}

function SearchingDoc (DocSearchAction) {
    var FormValues = '';
    if (DocSearchAction === 'doc_browse') {
        FormValues = $('#doc_search_menu').serialize() + '&action=game_browse&list=inner&query=' + $('.JSDocBrowse').val();
    } else {
        if (DocSearchAction === 'doc_search') {
            FormValues = $('#doc_search_menu').serialize() + '&action=game_search&list=inner&query=' + $('.JSDocSearch').val();
        }
    }
    $.ajaxQueue({
        // The URL for the request
        url: 'ajax_adddocs_menus.php',
        data: FormValues,
        type: 'GET',
        dataType: 'html',
        // Code to run if the request succeeds;
        success: function (html) {
            $('#doc_list').html(html);
        }
    });
}

function DocSearchListen () {
    $('.JSDocBrowse').change(function () {
        SearchingDoc('doc_browse');
    });

    $('.JSDocSearch').keyup(function () {
        var value = $(this).val();
        if (value.length >= 3) {
            SearchingDoc('doc_search');
        }
    });
}

function addGametoMenu (SoftwareId, MenuDiskId, SoftwareType) {
    if (SoftwareId === '') {
        $('#JSMenuSoftwareList').html('');
    } else {
        $.ajax({
            // The URL for the request
            url: 'db_menu_disk.php',
            data: 'action=add_title_to_menu&software_id=' + SoftwareId + '&menu_disk_id=' + MenuDiskId + '&software_type=' + SoftwareType,
            type: 'POST',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                var ReturnHtml = html.split('[BRK]');
                $('#JSMenuSoftwareList').html(ReturnHtml[0]);
                OSDMessageDisplay(ReturnHtml[1]);
            }
        });
    }
}

function addNewdisk (str) {
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
                $('#close_new_disk').html('<a onclick="CloseaddNewdisk(' + str + ')" style="cursor: pointer;" class="MAINNAV">Add New Disk</a>');
            }
        });
    }
}

function CloseaddNewdisk (str) {
    $('#new_disk').html('');
    $('#close_new_disk').html('<a onclick="addNewdisk(' + str + ')" style="cursor: pointer;" class="MAINNAV">Add New Disk</a>');
}

function myFunction () {
    $but = $('#file_upload_game_file');
    $('input:file[id=file_upload]').change(function () {
        document.getElementById('file_upload_game_screenshots').value = 'file(s) selected';
    });
    $('input:file[id=file_upload2]').change(function () {
        document.getElementById('file_upload_game_file').value = $(this).val();
    });
}

function browseCrew (str) {
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

function browseIndividual (str) {
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

function browseInd (str) {
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

function searchInd (str) {
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

function popAddIntroCred (str) {
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

function closeAddIntroCred (str) {
    $('#menu_detail_expand').html('');
    $('#intro_credit_link').html('<a onclick="popAddIntroCred(' + str + ')" style="cursor: pointer;" class="MAINNAV">Add intro credits</a>');
}

function popAddAuthorMenutitle (MenuDiskTitleId, GameId, GameName) {
    if (MenuDiskTitleId === '') {
        $('#menu_detail_expand_author_title').html('');
    } else {
        $.ajaxQueue({
            // The URL for the request
            url: 'ajax_add_author_menutitle.php',
            data: 'menu_disk_title_id=' + MenuDiskTitleId + '&game_name=' + GameName + '&game_id=' + GameId,
            type: 'GET',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                $('#menu_detail_expand_author_title').html(html);
                $('#author_to_menu_title' + GameId).html('<a onclick="closeAddAuthor(' + MenuDiskTitleId + ',' + GameId + ',' + GameName + ')" style="cursor: pointer;" class="standard_tile_link">' + GameName + '</a>');
            }
        });
    }
}

function closeAddAuthor (MenuDiskTitleId, GameId, GameName) {
    $('#menu_detail_expand_author_title').html('');
    $('#author_to_menu_title' + GameId).html('<a onclick="popAddAuthorMenutitle(' + MenuDiskTitleId + ',' + GameId + ',' + GameName + ')" style="cursor: pointer;" class="standard_tile_link">' + GameName + '</a>');
}

function popAddAuthorMenutitleDoc (MenuDiskTitleId, GameId, GameName) {
    if (MenuDiskTitleId === '') {
        $('#menu_detail_expand_author_title_doc').html('');
    } else {
        $.ajax({
            // The URL for the request
            url: 'ajax_add_author_menutitle.php',
            data: 'menu_disk_title_id=' + MenuDiskTitleId + '&game_name=' + GameName + '&game_id=' + GameId,
            type: 'GET',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                $('#menu_detail_expand_author_title_doc').html(html);
                $('#author_to_menu_title_doc' + GameId).html('<a onclick="closeAddAuthorDoc(' + MenuDiskTitleId + ',' + GameId + ',' + GameName + ')" style="cursor: pointer;" class="standard_tile_link">' + GameName + '</a>');
            }
        });
    }
}

function closeAddAuthorDoc (MenuDiskTitleId, GameId, GameName) {
    $('#menu_detail_expand_author_title_doc').html('');
    $('#author_to_menu_title_doc' + GameId).html('<a onclick="popAddAuthorMenutitleDoc(' + MenuDiskTitleId + ',' + GameId + ',' + GameName + ')" style="cursor: pointer;" class="standard_tile_link">' + GameName + '</a>');
}

function popAddDocs (str) {
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
                DocSearchListen();
            }
        });
    }
}

function closeAddDocs (str) {
    $('#menu_detail_expand_docs').html('');
    $('#docto_menu_link').html('<a onclick="popAddDocs(' + str + ')" style="cursor: pointer;" class="MAINNAV">Add Doc to menu</a>');
}

function popAddScreenshots (str) {
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

function closeAddScreenshots (str) {
    $('#JSMenuDetailExpandScreenshots').html('');
    $('#screenshot_link').html('<a onclick="popAddScreenshots(' + str + ')" style="cursor: pointer;" class="MAINNAV">Add Screenshots to menu</a>');
}

function popAddFile (str) {
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

function closeAddFile (str) {
    $('#JSMenuDetailExpandFile').html('');
    $('#file_link').html('<a onclick="popAddFile(' + str + ')" style="cursor: pointer;" class="MAINNAV">Add File to menu</a>');
}

function addslashes (str) {
    return (str + '').replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0');
}

function popAddSet (str, MenuDiskId, TitleName) {
    if (str === '') {
        $('#JSMenuDetailExpandSet').html('');
    } else {
        $.ajax({
            // The URL for the request
            url: 'ajax_addset_menus.php',
            data: 'menu_disk_title_id=' + str + '&menu_disk_id=' + MenuDiskId + '&title_name=' + TitleName,
            type: 'GET',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                $('#JSMenuDetailExpandSet').html(html);
                var title = addslashes(TitleName);
                $('#' + str).html('<a onclick="closeAddSet(' + str + ',' + MenuDiskId + ',' + title + ')" style="cursor: pointer;" class="standard_tile_link">Add</a>');
            }
        });
        var elementExists = document.getElementById('set_chain_update');
        if (typeof (elementExists) !== 'undefined' && elementExists !== null) {
            $('#set_chain_update').html('');
        }
    }
}

function closeAddSet (str, MenuDiskId, TitleName) {
    var title = addslashes(TitleName);
    $('#JSMenuDetailExpandSet').html('');
    $('#' + str).html('<a onclick="popAddSet(' + str + ',' + MenuDiskId + ',' + title + ')" style="cursor: pointer;" class="standard_tile_link">Add</a>');
}

function addAuthorstoMenutitle (MenuDiskTitleId) {
    if (MenuDiskTitleId === '') {
        $('#author_list').html('');
    } else {
        var FormValues = $('#authors_form').serialize();
        $.ajax({
            // The URL for the request
            url: 'db_menu_disk.php',
            data: FormValues,
            type: 'POST',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                var ReturnHtml = html.split('[BRK]');
                $('#author_list').html(ReturnHtml[0]);
                OSDMessageDisplay(ReturnHtml[1]);
            }
        });
    }
}

function addDoctoMenu (SoftwareId, MenuDiskId, SoftwareType) {
    if (SoftwareId === '') {
        $('#menu_doc_list').html('');
    } else {
        $.ajax({
            // The URL for the request
            url: 'db_menu_disk.php',
            data: 'action=add_doc_to_menu&software_id=' + SoftwareId + '&menu_disk_id=' + MenuDiskId + '&software_type=' + SoftwareType,
            type: 'POST',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                var ReturnHtml = html.split('[BRK]');
                $('#menu_doc_list').html(ReturnHtml[0]);
                OSDMessageDisplay(ReturnHtml[1]);
            }
        });
    }
}

function addScreenshottoMenu (MenuDiskId) {
    if (MenuDiskId === '') {
        $('#JSMenuScreenshotList').html('');
    } else {
        var form = $('#screenshot_add_to_menu')[0];
        var FormValues = new FormData(form);

        $.ajax({
            // The URL for the request
            url: 'db_menu_disk.php',
            data: FormValues,
            type: 'POST',
            contentType: false,
            processData: false,
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                var ReturnHtml = html.split('[BRK]');
                $('#JSMenuScreenshotList').html(ReturnHtml[0]);
                OSDMessageDisplay(ReturnHtml[1]);
                document.getElementById('screenshot_add_to_menu').reset();
            }
        });
    }
}

function addFiletoMenu (MenuDiskId) {
    if (MenuDiskId === '') {
        $('#JSMenuFileList').html('');
    } else {
        var form = $('#file_add_to_menu')[0];
        var FormValues = new FormData(form);

        $.ajax({
            // The URL for the request
            url: 'db_menu_disk.php',
            data: FormValues,
            type: 'POST',
            contentType: false,
            processData: false,
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                var ReturnHtml = html.split('[BRK]');
                $('#JSMenuFileList').html(ReturnHtml[0]);
                OSDMessageDisplay(ReturnHtml[1]);
                document.getElementById('File_add_to_menu').reset();
            }
        });
    }
}

function LinkChain (MenuDiskTitleId, MenuDiskId) {
    if (MenuDiskTitleId === '') {
        $('#JSMenuSoftwareList').html('');
    } else {
        var FormValues = $('#link_game_to_set').serialize();
        $.ajax({
            // The URL for the request
            url: 'db_menu_disk.php',
            data: FormValues,
            type: 'POST',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                var ReturnHtml = html.split('[BRK]');
                $('#JSMenuSoftwareList').html(ReturnHtml[0]);
                OSDMessageDisplay(ReturnHtml[1]);
                $('#JSMenuDetailExpandSet').html('');
            }
        });
    }
}

function DeleteChain (MenuDiskTitleId, MenuDiskId, TitleName) {
    if (MenuDiskTitleId === '') {
        $('#JSMenuSoftwareList').html('');
    } else {
        $.ajax({
            // The URL for the request
            url: 'db_menu_disk.php',
            data: 'action=delete_game_from_set&menu_disk_title_id=' + MenuDiskTitleId + '&menu_disk_id=' + MenuDiskId + '&title_name=' + TitleName,
            type: 'POST',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                var ReturnHtml = html.split('[BRK]');
                $('#JSMenuSoftwareList').html(ReturnHtml[0]);
                OSDMessageDisplay(ReturnHtml[1]);
                $('#JSMenuDetailExpandSet').html('');
            }
        });
    }
}

function CreateChain (str, MenuDiskId) {
    if (str === '') {
        $('#JSMenuSoftwareList').html('');
    } else {
        $.ajax({
            // The URL for the request
            url: 'db_menu_disk.php',
            data: 'action=add_set_to_menu&menu_disk_title_id=' + str + '&menu_disk_id=' + MenuDiskId,
            type: 'POST',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                var ReturnHtml = html.split('[BRK]');
                $('#JSMenuSoftwareList').html(ReturnHtml[0]);
                OSDMessageDisplay(ReturnHtml[1]);
                $('#JSMenuDetailExpandSet').html('');
            }
        });
    }
}

function addCreditstoMenu (MenuDiskId) {
    if (MenuDiskId === '') {
        $('#menu_credit_list').html('');
    } else {
        var IndId = document.getElementById('menu_credits_form').elements.namedItem('ind_id').value;
        var AuthorTypeId = document.getElementById('menu_credits_form').elements.namedItem('author_type_id').value;
        $.ajax({
            // The URL for the request
            url: 'db_menu_disk.php',
            data: 'action=add_intro_credits&author_type_id=' + AuthorTypeId + '&menu_disk_id=' + MenuDiskId + '&ind_id=' + IndId,
            type: 'POST',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                var ReturnHtml = html.split('[BRK]');
                $('#menu_credit_list').html(ReturnHtml[0]);
                OSDMessageDisplay(ReturnHtml[1]);
                document.getElementById('menu_credit_list').reset();
            }
        });
    }
}

function ChangeState (StateId, MenuDiskId) {
    var str2 = 'diskedit_ajax_';
    var DiskEditAjax = str2.concat(MenuDiskId);
    if (MenuDiskId === '') {
        $('#' + DiskEditAjax).html('');
    } else {
        $.ajax({
            // The URL for the request
            url: 'db_menu_disk.php',
            data: 'action=change_menu_disk_state&state_id=' + StateId + '&menu_disk_id=' + MenuDiskId,
            type: 'POST',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                var ReturnHtml = html.split('[BRK]');
                $('#' + DiskEditAjax).html(ReturnHtml[0]);
                OSDMessageDisplay(ReturnHtml[1]);
                document.getElementById(DiskEditAjax).reset();
            }
        });
    }
}

function ChangeDoctype (DocTypeId, DocId, MenuDiskId) {
    if (DocTypeId === '') {
        $('#menu_doc_list').html('');
    } else {
        $.ajax({
            // The URL for the request
            url: 'db_menu_disk.php',
            data: 'action=change_doctype&doc_type_id=' + DocTypeId + '&doc_id=' + DocId + '&menu_disk_id=' + MenuDiskId,
            type: 'POST',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                var ReturnHtml = html.split('[BRK]');
                $('#menu_doc_list').html(ReturnHtml[0]);
                OSDMessageDisplay(ReturnHtml[1]);
                document.getElementById('menu_doc_list').reset();
            }
        });
    }
}

function ChangeYear (YearId, MenuDiskId) {
    var str2 = 'diskedit_ajax_';
    var DiskEditAjax = str2.concat(MenuDiskId);
    if (MenuDiskId === '') {
        $('#' + DiskEditAjax).html('');
    } else {
        $.ajax({
            // The URL for the request
            url: 'db_menu_disk.php',
            data: 'action=change_menu_disk_year&year_id=' + YearId + '&menu_disk_id=' + MenuDiskId,
            type: 'POST',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                var ReturnHtml = html.split('[BRK]');
                $('#' + DiskEditAjax).html(ReturnHtml[0]);
                OSDMessageDisplay(ReturnHtml[1]);
                document.getElementById(DiskEditAjax).reset();
            }
        });
    }
}

function ChangeParent (ParentId, MenuDiskId) {
    var str2 = 'diskedit_ajax_';
    var DiskEditAjax = str2.concat(MenuDiskId);
    if (MenuDiskId === '') {
        $('#disk_edit_ajax').html('');
    } else {
        $.ajax({
            // The URL for the request
            url: 'db_menu_disk.php',
            data: 'action=change_menu_disk_parent&parent_id=' + ParentId + '&menu_disk_id=' + MenuDiskId,
            type: 'POST',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                var ReturnHtml = html.split('[BRK]');
                $('#' + DiskEditAjax).html(ReturnHtml[0]);
                OSDMessageDisplay(ReturnHtml[1]);
                document.getElementById(DiskEditAjax).reset();
            }
        });
    }
}
// Are you sure question Delete
function DeleteGamefromMenuButton (str, MenuDiskId) {
    $('#JSGenericModal').dialog({
        title: 'Delete Title',
        open: $('#JSGenericModalText').text('Are you sure you want to delete this title from the menu disk?'),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            'Delete title': function () {
                $(this).dialog('close');
                DeleteGamefromMenu(str, MenuDiskId);
            },
            Cancel: function () {
                $(this).dialog('close');
                $('#menu_disk_title_id' + str).prop('checked', false);
            }
        }
    });
}

function DeleteGamefromMenu (MenuDiskTitleId, MenuDiskId) {
    if (MenuDiskTitleId === '') {
        $('#JSMenuSoftwareList').html('');
    } else {
        $.ajax({
            // The URL for the request
            url: 'db_menu_disk.php',
            data: 'action=delete_from_menu_disk&menu_disk_title_id=' + MenuDiskTitleId + '&menu_disk_id=' + MenuDiskId,
            type: 'POST',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                var ReturnHtml = html.split('[BRK]');
                $('#JSMenuSoftwareList').html(ReturnHtml[0]);
                OSDMessageDisplay(ReturnHtml[1]);
            }
        });
    }
}

function DeleteMenuDiskModal (MenuDiskId) {
    $('#JSGenericModal').dialog({
        title: 'Delete Disk?',
        open: $('#JSGenericModalText').text('Are you sure you want to delete this menu disk?'),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            'Delete disk': function () {
                $(this).dialog('close');
                DeleteMenuDisk(MenuDiskId);
            },
            Cancel: function () {
                $(this).dialog('close');
            }
        }
    });
}

function DeleteMenuDisk (MenuDiskId) {
    var str2 = 'diskedit_ajax_';
    var DiskEditAjax = str2.concat(MenuDiskId);
    $.ajax({
        // The URL for the request
        url: 'db_menu_disk.php',
        data: 'action=delete_menu_disk&menu_disk_id=' + MenuDiskId,
        type: 'POST',
        dataType: 'html',
        // Code to run if the request succeeds;
        success: function (html) {
            if (html === 'Menudisk completely removed') {
                $('#' + DiskEditAjax).html('');
            }
            OSDMessageDisplay(html);
        }
    });
}

function DeleteMenuSetIndividualModal (IndSelect, MenuSetsId) {
    $('#JSGenericModal').dialog({
        title: 'Delete Individual?',
        open: $('#JSGenericModalText').text('Are you sure you want to delete this Individual from the Menu Set?'),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            'Delete disk': function () {
                $(this).dialog('close');
                var url = 'db_menu_disk.php?menu_sets_id=' + MenuSetsId + '&ind_id=' + IndSelect + '&action=delete_ind_from_menu_set';
                location.href = url;
            },
            Cancel: function () {
                $(this).dialog('close');
            }
        }
    });
}

function DeleteMenuSetCrewModal (CrewSelect, MenuSetsId) {
    $('#JSGenericModal').dialog({
        title: 'Delete Crew?',
        open: $('#JSGenericModalText').text('Are you sure you want to delete this Crew from the Menu Set?'),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            'Delete disk': function () {
                $(this).dialog('close');
                var url = 'db_menu_disk.php?menu_sets_id=' + MenuSetsId + '&crew_id=' + CrewSelect + '&action=delete_crew_from_menu_set';
                location.href = url;
            },
            Cancel: function () {
                $(this).dialog('close');
            }
        }
    });
}

function MenuTypeDelete (MenuTypeSelect, MenuSetsId) {
    $('#JSGenericModal').dialog({
        title: 'Delete menu type?',
        open: $('#JSGenericModalText').text('Are you sure you want to delete this menu type from this menu set?'),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            'Delete disk': function () {
                $(this).dialog('close');
                var url = 'db_menu_disk.php?menu_sets_id=' + MenuSetsId + '&menu_type_id=' + MenuTypeSelect + '&action=delete_menu_type_from_menu_set';
                location.href = url;
            },
            Cancel: function () {
                $(this).dialog('close');
            }
        }
    });
}

function deleteScreenshotfromMenu (str, MenuDiskId) {
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
                    data: 'action=delete_screen_from_menu_disk&screenshot_id=' + str + '&menu_disk_id=' + MenuDiskId,
                    type: 'POST',
                    dataType: 'html',
                    // Code to run if the request succeeds;
                    success: function (html) {
                        var ReturnHtml = html.split('[BRK]');
                        $('#JSMenuScreenshotList').html(ReturnHtml[0]);
                        OSDMessageDisplay(ReturnHtml[1]);
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

function deleteDownload (str, MenuDiskId) {
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
                    data: 'action=delete_download_from_menu_disk&menu_disk_download_id=' + str + '&menu_disk_id=' + MenuDiskId,
                    type: 'POST',
                    dataType: 'html',
                    // Code to run if the request succeeds;
                    success: function (html) {
                        var ReturnHtml = html.split('[BRK]');
                        $('#JSMenuFileList').html(ReturnHtml[0]);
                        OSDMessageDisplay(ReturnHtml[1]);
                    }
                });
            },
            Cancel: function () {
                $(this).dialog('close');
            }
        }
    });
}

function deleteDocfromMenu (str, MenuDiskId) {
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
                    data: 'action=delete_doc_from_menu_disk&menu_disk_title_id=' + str + '&menu_disk_id=' + MenuDiskId,
                    type: 'POST',
                    dataType: 'html',
                    // Code to run if the request succeeds;
                    success: function (html) {
                        var ReturnHtml = html.split('[BRK]');
                        $('#menu_doc_list').html(ReturnHtml[0]);
                        OSDMessageDisplay(ReturnHtml[1]);
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

function DeleteSet (str) {
    $('#JSGenericModal').dialog({
        title: 'Delete menu set?',
        open: $('#JSGenericModalText').text('Are you sure you want to delete this set?'),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            'Delete disk': function () {
                $(this).dialog('close');
                var url = '../menus/db_menu_disk.php?action=delete_set&menu_sets_id=' + str;
                location.href = url;
            },
            Cancel: function () {
                $(this).dialog('close');
            }
        }
    });
}

function PublishSet (str, action) {
    $('#JSGenericModal').dialog({
        title: 'Change Status?',
        open: $('#JSGenericModalText').text('Are you sure you want to change status on this set?'),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            'Change': function () {
                $(this).dialog('close');
                var url = '../menus/db_menu_disk.php?action=publish_set&online=' + action + '&menu_sets_id=' + str;
                location.href = url;
            },
            Cancel: function () {
                $(this).dialog('close');
            }
        }
    });
}

function DeleteCredits (MenuDiskCreditsId, MenuDiskId) {
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
                    data: 'action=delete_menu_disk_credits&menu_disk_credits_id=' + MenuDiskCreditsId + '&menu_disk_id=' + MenuDiskId,
                    type: 'POST',
                    dataType: 'html',
                    // Code to run if the request succeeds;
                    success: function (html) {
                        var ReturnHtml = html.split('[BRK]');
                        $('#menu_credit_list').html(ReturnHtml[0]);
                        OSDMessageDisplay(ReturnHtml[1]);
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

function DeleteTitleCredits (MenuDiskTitleId, IndId, AuthorTypeId) {
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
                    data: 'action=delete_menu_disk_title_credits&menu_disk_title_id=' + MenuDiskTitleId + '&author_type_id=' + AuthorTypeId + '+&ind_id=' + IndId,
                    type: 'POST',
                    dataType: 'html',
                    // Code to run if the request succeeds;
                    success: function (html) {
                        var ReturnHtml = html.split('[BRK]');
                        $('#author_list').html(ReturnHtml[0]);
                        OSDMessageDisplay(ReturnHtml[1]);
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

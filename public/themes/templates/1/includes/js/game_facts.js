/*!
 * game_facts.js
 */
window.FactDeleteConfirmation = function (gameId, factId, gameName) {
    $('#JSGenericModal').dialog({
        title: 'Delete Fact',
        open: $('#JSGenericModalText').text('Are you sure you want to delete this Fact?'),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            'Delete Fact': function () {
                $(this).dialog('close');
                FactDelete(gameId, factId, gameName);
            },
            Cancel: function () {
                $(this).dialog('close');
            }
        }
    });
}
function FactDelete (gameId, factId, gameName) {
    $.ajaxQueue({
        // The URL for the request
        url: 'db_games_facts.php',
        data: 'fact_id=' + factId + '&game_id=' + gameId + '&game_name=' + gameName + '&action=fact_delete',
        type: 'POST',
        dataType: 'html',
        // Code to run if the request succeeds;
        success: function (html) {
            var returnHtml = html.split('[BRK]');
            $('#add_facts_list').html(returnHtml[0]);
            window.OSDMessageDisplay(returnHtml[1]);
        }
    });
}

window.GameFactEdit = function (factId, gameId) {
    $.ajax({
        // The URL for the request
        url: 'ajax_game_facts.php',
        data: 'fact_id=' + factId + '&game_id=' + gameId + '&action=game_fact_edit_view',
        type: 'GET',
        dataType: 'html',
        // Code to run if the request succeeds;
        success: function (html) {
            var ReturnHtml = html.split('[BRK]');
            $('#JSGameFact_' + factId).html(ReturnHtml[0]);
            $('#JSGameFactEdit_' + factId).html(ReturnHtml[1]);
        }
    });
}

window.deletescreen = function (factId, screenshotId, gameId) {
    $('#JSGenericModal').dialog({
        title: 'Delete Screenshot',
        open: $('#JSGenericModalText').text('Are you sure you want to delete the screenshot?'),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            'Delete': function () {
                $(this).dialog('close');
                screenshotDelete(factId, screenshotId, gameId);
            },
            Cancel: function () {
                $(this).dialog('close');
            }
        }
    });
}

function screenshotDelete (factId, screenshotId, gameId) {
    $.ajaxQueue({
        // The URL for the request
        url: 'db_games_facts.php',
        data: 'fact_id=' + factId + '&game_id=' + gameId + '&screenshot_id=' + screenshotId + '&action=delete_screenshot',
        type: 'POST',
        dataType: 'html',
        // Code to run if the request succeeds;
        success: function (html) {
            var returnHtml = html.split('[BRK]');
            $('#add_facts_list').html(returnHtml[0]);
            window.OSDMessageDisplay(returnHtml[1]);
        }
    });
}

$(function () {
    $('input:file[id=file_upload2]').change(function () {
        document.getElementById('file_upload_fact_screenshots2').value = 'file(s) selected';
    });
});

/*!
 * game_review.js
 */

$(document).ready(function () {
    $('select[name=game_create]').altAutocomplete();
    $('select[name=members]').altAutocomplete();
});



window.deletereview = function (reviewid, gameid) {
    $('#JSGenericModal').dialog({
        title: 'Delete',
        open: $('#JSGenericModalText').text('Are you sure you want to delete this review?'),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            'Delete': function () {
                $(this).dialog('close');
                url = 'db_games_review_edit.php?reviewid='+reviewid+'&game_id='+gameid+'&action=delete_review';
                location.href=url;
            },
            Cancel: function () {
                $(this).dialog('close');
            }
        }
    });
}
window.deleteSubmission = function (reviewid, gameid) {
    $('#JSGenericModal').dialog({
        title: 'Delete',
        open: $('#JSGenericModalText').text('Are you sure you want to delete this review?'),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            'Delete': function () {
                $(this).dialog('close');
                url = 'db_games_review_edit.php?reviewid='+reviewid+'&game_id='+gameid+'&action=delete_submission';
                location.href=url;
            },
            Cancel: function () {
                $(this).dialog('close');
            }
        }
    });
}
window.move_to_comment = function (reviewid, gameid) {
    $('#JSGenericModal').dialog({
        title: 'Move',
        open: $('#JSGenericModalText').text('Are you sure you want to move this review to the comments section? Some content will be deleted in the moving process.'),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            'Move': function () {
                $(this).dialog('close');
                url = 'db_games_review_edit.php?reviewid='+reviewid+'&game_id='+gameid+'&action=move_to_comment';
                location.href=url;
            },
            Cancel: function () {
                $(this).dialog('close');
            }
        }
    });
}
window.deletecomment = function (game_id,reviewid,screenshot_id) {
    $('#JSGenericModal').dialog({
        title: 'Delete',
        open: $('#JSGenericModalText').text('Are you sure you want to delete this comment?'),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            'Delete': function () {
                $(this).dialog('close');
                url = 'db_games_review_edit.php?game_id='+game_id+'&reviewid='+reviewid+'&screenshot_id='+screenshot_id+'&action=delete_comment';
                location.href=url;
            },
            Cancel: function () {
                $(this).dialog('close');
            }
        }
    });
}

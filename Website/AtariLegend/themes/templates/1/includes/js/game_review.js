/*!
 * game_review.js
 */
window.openTab = function (evt, tabName, screenshotsNr) {
    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName('tabcontent');
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = 'none';
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName('tablinks');
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(' active', '');
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(tabName).style.display = 'block';
    evt.currentTarget.className += ' active';

    // al the java code for the filling of the fields in the preview tab!
    if (tabName === 'preview') {
        // get the date field
        var day = document.getElementsByName('Date_Day')[0].value;
        document.getElementById('review_preview_date').innerHTML = day;
        document.getElementById('review_preview_date').innerHTML += '-';
        var month = document.getElementsByName('Date_Month')[0].value;
        document.getElementById('review_preview_date').innerHTML += month;
        document.getElementById('review_preview_date').innerHTML += '-';
        var year = document.getElementsByName('Date_Year')[0].value;
        document.getElementById('review_preview_date').innerHTML += year;

        // graphics
        var graphics = document.getElementsByName('graphics')[0].value;
        if (!isNaN(graphics)) {
            document.getElementById('games_preview_review_graphics').innerHTML = graphics;
        } else { document.getElementById('games_preview_review_graphics').innerHTML = 'please enter a number'; }
        // sound
        var sound = document.getElementsByName('sound')[0].value;
        if (!isNaN(sound)) {
            document.getElementById('games_preview_review_sound').innerHTML = sound;
        } else { document.getElementById('games_preview_review_sound').innerHTML = 'please enter a number'; }
        // gameplay
        var gameplay = document.getElementsByName('gameplay')[0].value;
        if (!isNaN(gameplay)) {
            document.getElementById('games_preview_review_gameplay').innerHTML = gameplay;
        } else { document.getElementById('games_preview_review_gameplay').innerHTML = 'please enter a number'; }
        // overall
        var overall = document.getElementsByName('conclusion')[0].value;
        if (!isNaN(overall)) {
            document.getElementById('games_preview_review_overall').innerHTML = overall;
        } else { document.getElementById('games_preview_review_overall').innerHTML = 'please enter a number'; }

        var user = document.getElementById('member_select');
        var strUser = user.options[user.selectedIndex].text;
        document.getElementById('review_preview_user').innerHTML = strUser;

        // Do all the preps for the actual review text!
        var review = document.getElementsByName('textfield')[0].value;
        review = previewText(review);
        document.getElementById('review_preview_text').innerHTML = review;

        // get the screenshots data
        for (i = 1; i <= screenshotsNr; i++) {
            var string = 'comment_';
            var stringComment = string.concat(i);
            var comment = document.getElementById(stringComment).value;

            if (comment === '') {
                var string3 = 'output_';
                var stringOutput = string3.concat(i);
                var output = document.getElementById(stringOutput);
                output.style.display = 'none';
            } else {
                var string2 = 'preview_comment_';
                var stringPreviewComment = string2.concat(i);
                document.getElementById(stringPreviewComment).innerHTML = comment;

                var string4 = 'output_';
                var stringOutput2 = string4.concat(i);
                var output2 = document.getElementById(stringOutput2);
                output2.style.display = 'inline';
            }
        }
    }
}

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
                var url = 'db_games_review.php?reviewid=' + reviewid + '&game_id=' + gameid + '&action=delete_review';
                location.href = url;
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
                var url = 'db_games_review.php?reviewid=' + reviewid + '&game_id=' + gameid + '&action=delete_submission';
                location.href = url;
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
                var url = 'db_games_review.php?reviewid=' + reviewid + '&game_id=' + gameid + '&action=move_to_comment';
                location.href = url;
            },
            Cancel: function () {
                $(this).dialog('close');
            }
        }
    });
}
window.deletecomment = function (gameId, reviewId, screenshotId) {
    $('#JSGenericModal').dialog({
        title: 'Delete',
        open: $('#JSGenericModalText').text('Are you sure you want to delete this comment?'),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            'Delete': function () {
                $(this).dialog('close');
                var url = 'db_games_review.php?game_id=' + gameId + '&reviewid=' + reviewId + '&screenshot_id=' + screenshotId + '&action=delete_comment';
                location.href = url;
            },
            Cancel: function () {
                $(this).dialog('close');
            }
        }
    });
}

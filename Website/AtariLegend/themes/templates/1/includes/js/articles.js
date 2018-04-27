/*!
 * articles.js
 * http://www.atarilegend.com
 *
 */

window.onload = function () {
    $('.article_main_text').dotdotdot({ // This is the script to truncate the preview of the reviews
        //  configuration goes here

        /*  The text to add as ellipsis. */
        ellipsis: '... ',

        /*  How to cut off the text/html: 'word'/'letter'/'children' */
        wrap: 'word',

        /*  Wrap-option fallback to 'letter' for long words */
        fallbackToLetter: false,

        /*  jQuery-selector for the element to keep and put after the ellipsis. */
        after: null,

        /*  Whether to update the ellipsis: true/'window' */
        watch: window,

        /*  Optionally set a max-height, can be a number or function.
            If null, the height will be measured. */
        height: null,

        /*  Deviation for the height-option. */
        tolerance: 0,

        /*  Callback function that is fired after the ellipsis is added,
            receives two parameters: isTruncated(boolean), orgContent(string). */
        callback: function (isTruncated, orgContent) {},

        lastCharacter: {

            /*  Remove these characters from the end of the truncated text. */
            remove: [ ' ', ',', ';', '.', '!', '?' ],

            /*  Don't add an ellipsis if this array contains
                the last character of the truncated text. */
            noEllipsis: []
        }
    });
};

$(document).ready(function () {
    $('select[name=members]').altAutocomplete();
});

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
        document.getElementById('article_preview_date').innerHTML = day;
        document.getElementById('article_preview_date').innerHTML += '-';
        var month = document.getElementsByName('Date_Month')[0].value;
        document.getElementById('article_preview_date').innerHTML += month;
        document.getElementById('article_preview_date').innerHTML += '-';
        var year = document.getElementsByName('Date_Year')[0].value;
        document.getElementById('article_preview_date').innerHTML += year;

        var user = document.getElementById('member_select');
        var strUser = user.options[user.selectedIndex].text;
        document.getElementById('article_preview_user').innerHTML = strUser;

        // Do all the preps for the intro text!
        var intro = document.getElementsByName('textintro')[0].value;
        intro = previewText(intro);
        document.getElementById('article_preview_intro').innerHTML = intro;

        // Do all the preps for the actual article text!
        var article = document.getElementsByName('textfield')[0].value;
        article = previewText(article);
        document.getElementById('article_preview_text').innerHTML = article;

        // get the screenshots data
        for (i = 1; i <= screenshotsNr; i++) {
            var string = 'comment_';
            var stringComment = string.concat(i);
            var comment = document.getElementById(stringComment).value;

            var string2 = 'preview_comment_';
            var stringPreviewComment = string2.concat(i);
            document.getElementById(stringPreviewComment).innerHTML = comment;

            var string3 = 'output_';
            var stringOutput2 = string3.concat(i);
            var output2 = document.getElementById(stringOutput2);
            output2.style.display = 'inline';
        }
    }
}

// Delete the comments and the article
window.deletecomment = function (str, str2) {
    $('#JSGenericModal').dialog({
        title: 'Delete screenshot?',
        open: $('#JSGenericModalText').text('Are you sure you want to delete the screenshot with its comment?'),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            'Delete': function () {
                $(this).dialog('close');
                $.ajaxQueue({
                    // The URL for the request
                    url: 'db_articles.php',
                    data: 'article_id=' + str2 + '&screenshot_id=' + str + '&action=delete_screenshot_comment',
                    type: 'POST',
                    dataType: 'html',
                    // Code to run if the request succeeds;
                    success: function (html) {
                        var returnHtml = html.split('[BRK]');
                        $('#article_screenshot_list').html(returnHtml[0]);
                        window.OSDMessageDisplay(returnHtml[1]);
                        document.getElementById('screenshot_add_to_article').reset();
                    }
                });
            },
            Cancel: function () {
                $(this).dialog('close');
            }
        }
    });
}

// delete the article
window.deletearticle = function (str) {
    $('#JSGenericModal').dialog({
        title: 'Delete article?',
        open: $('#JSGenericModalText').text('Are you sure you want to delete this article?'),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            'Delete': function () {
                $(this).dialog('close');
                var url = 'db_articles.php?action=delete_article&article_id=' + str;
                location.href = url;
            },
            Cancel: function () {
                $(this).dialog('close');
            }
        }
    });
}

// open the screenshot selection box
window.popArticleAddScreenshots = function (str) {
    if (str === '') {
        $('#article_expand_screenshots').html('');
    } else {
        $.ajaxQueue({
            // The URL for the request
            url: '../articles/ajax_addscreenshots_article.php',
            data: 'article_id=' + str,
            type: 'GET',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                $('#article_expand_screenshots').html(html);
                $('#screenshot_link').html('<a onclick="closeAddScreenshots(' + str + ')" style="cursor: pointer;" class="left_nav_link"><i class="fa fa-minus-square-o" aria-hidden="true"></i> Add screenshots</a>');
            }
        });
    }
}

// close the screenshot selection box
window.closeAddScreenshots = function (str) {
    document.getElementById('article_expand_screenshots').innerHTML = '';
    document.getElementById('screenshot_link').innerHTML = '<a onclick="popArticleAddScreenshots(' + str + ')" style="cursor: pointer;" class="left_nav_link"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Add screenshots</a>';
}

// Save the screenshots to the article
window.addScreenshottoArticle = function (articleId, styleDir) {
    if (articleId === '') {
        $('#article_screenshot_list').html('');
    } else {
        var form = $('#screenshot_add_to_article')[0];
        var formValues = new FormData(form);
        $.ajax({
            // The URL for the request
            url: '../articles/db_articles.php?action2=add_screens',
            data: formValues,
            type: 'POST',
            contentType: false,
            processData: false,
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                var returnHtml = html.split('[BRK]');
                $('#article_screenshot_list').html(returnHtml[0]);
                window.OSDMessageDisplay(returnHtml[1]);
                document.getElementById('screenshot_add_to_article').reset();
            }
        });
    }
}

// the code for the screenshot selector
window.myFunction = function () {
    $('input:file[id=file_upload]').change(function () {
        document.getElementById('file_upload_game_screenshots').value = 'file(s) selected';
    });

    $('input:file[id=file_upload2]').change(function () {
        document.getElementById('file_upload_game_file').value = $(this).val();
    });
}

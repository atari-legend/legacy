/*!
 * trivia.js
 */

window.DidyouknowdeleteConfirmation = function (triviaId) {
    $('#JSGenericModal').dialog({
        title: 'Delete Quote',
        open: $('#JSGenericModalText').text('Are you sure you want to delete this Quote?'),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            'Delete Quote': function () {
                $(this).dialog('close');
                DidyouknowDelete(triviaId);
            },
            Cancel: function () {
                $(this).dialog('close');
            }
        }
    });
}
function DidyouknowDelete (triviaId) {
    $.ajaxQueue({
        // The URL for the request
        url: 'db_trivia.php',
        data: 'action=did_you_know_delete&trivia_id=' + triviaId,
        type: 'POST',
        dataType: 'html',
        // Code to run if the request succeeds;
        success: function (html) {
            var returnHtml = html.split('[BRK]');
            $('#add_trivia_list').html(returnHtml[0]);
            window.OSDMessageDisplay(returnHtml[1]);
            document.getElementById('trivia').reset();
        }
    });
}

window.DidyouknowEdit = function (triviaId) {
    $.ajax({
        // The URL for the request
        url: 'ajax_trivia_quotes.php',
        data: 'action=did_you_know_edit_view&trivia_id=' + triviaId,
        type: 'GET',
        dataType: 'html',
        // Code to run if the request succeeds;
        success: function (html) {
            var ReturnHtml = html.split('[BRK]');
            $('#JSDidYouKnow_' + triviaId).html(ReturnHtml[0]);
            $('#JSDidYouKnowEdit_' + triviaId).html(ReturnHtml[1]);
        }
    });
}

window.DidyouknowUpdate = function (triviaId) {
    var form = $('#JSTrivia' + triviaId).serialize() + '&action=update_trivia';
    $.ajax({
        // The URL for the request
        url: 'db_trivia.php',
        data: form,
        type: 'POST',
        dataType: 'html',
        // Code to run if the request succeeds;
        success: function (html) {
            var ReturnHtml = html.split('[BRK]');
            $('#JSDidYouKnow_' + triviaId).html(ReturnHtml[0]);
            $('#JSDidYouKnowEdit_' + triviaId).html(ReturnHtml[1]);
            window.OSDMessageDisplay('Trivia updated!');
        }
    });
}

window.EditTriviaQuote = function (triviaQuoteId) {
    $.ajax({
        // The URL for the request
        url: 'ajax_trivia_quotes.php',
        data: 'action=edit_trivia_quote&trivia_quote_id=' + triviaQuoteId,
        type: 'GET',
        dataType: 'html',
        // Code to run if the request succeeds;
        success: function (html) {
            var ReturnHtml = html.split('[BRK]');
            $('#JSTrivia_' + triviaQuoteId).html(ReturnHtml[0]);
            $('#JSTriviaEdit_' + triviaQuoteId).html(ReturnHtml[1]);
        }
    });
}

window.TriviaQuoteUpdate = function (triviaQuoteId) {
    var form = $('#JSTrivia' + triviaQuoteId).serialize() + '&action=edit_trivia_quote';
    $.ajax({
        // The URL for the request
        url: 'db_trivia.php',
        data: form,
        type: 'POST',
        dataType: 'html',
        // Code to run if the request succeeds;
        success: function (html) {
            var ReturnHtml = html.split('[BRK]');
            $('#STrivia_' + triviaQuoteId).html(ReturnHtml[0]);
            $('#JSTriviaEdit_' + triviaQuoteId).html(ReturnHtml[1]);
            window.OSDMessageDisplay('Trivia updated!');
        }
    });
}

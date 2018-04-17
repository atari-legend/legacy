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
            var returnHtml = html.split('[BRK]');
            $('#add_trivia_list').html(returnHtml[0]);
            window.OSDMessageDisplay(returnHtml[1]);
            document.getElementById('trivia').reset();
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
            var returnHtml = html.split('[BRK]');
            $('#add_quote_list').html(returnHtml[0]);
            window.OSDMessageDisplay(returnHtml[1]);
            document.getElementById('triviaquote').reset();
        }
    });
}

window.TriviaQuoteDeleteConfirmation = function (triviaQuoteId) {
    $('#JSGenericModal').dialog({
        title: 'Delete Trivia',
        open: $('#JSGenericModalText').text('Are you sure you want to delete this Quote?'),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            'Delete Quote': function () {
                $(this).dialog('close');
                TriviaQuoteDelete(triviaQuoteId);
            },
            Cancel: function () {
                $(this).dialog('close');
            }
        }
    });
}

function TriviaQuoteDelete (triviaQuoteId) {
    $.ajaxQueue({
        // The URL for the request
        url: 'db_trivia.php',
        data: 'action=delete_trivia_quote&trivia_quote_id=' + triviaQuoteId,
        type: 'POST',
        dataType: 'html',
        // Code to run if the request succeeds;
        success: function (html) {
            var returnHtml = html.split('[BRK]');
            $('#add_quote_list').html(returnHtml[0]);
            window.OSDMessageDisplay(returnHtml[1]);
            document.getElementById('triviaquote').reset();
        }
    });
}

window.SpotlightdeleteConfirmation = function (spotlightId) {
    $('#JSGenericModal').dialog({
        title: 'Delete spotlight',
        open: $('#JSGenericModalText').text('Are you sure you want to delete this spotlight entry?'),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            'Delete': function () {
                $(this).dialog('close');
                SpotlightDelete(spotlightId);
            },
            Cancel: function () {
                $(this).dialog('close');
            }
        }
    });
}

function SpotlightDelete (spotlightId) {
    $.ajaxQueue({
        // The URL for the request
        url: 'db_trivia.php',
        data: 'action=spotlight_delete&spotlight_id=' + spotlightId,
        type: 'POST',
        dataType: 'html',
        // Code to run if the request succeeds;
        success: function (html) {
            var returnHtml = html.split('[BRK]');
            $('#spotlight_list').html(returnHtml[0]);
            window.OSDMessageDisplay(returnHtml[1]);
            document.getElementById('spotlight').reset();
        }
    });
}

window.SpotlightEdit = function (spotlightId) {
    $.ajax({
        // The URL for the request
        url: 'ajax_trivia_quotes.php',
        data: 'action=spotlight_edit_view&spotlight_id=' + spotlightId,
        type: 'GET',
        dataType: 'html',
        // Code to run if the request succeeds;
        success: function (html) {
            var ReturnHtml = html.split('[BRK]');
            $('#JSSpotlight_' + spotlightId).html(ReturnHtml[0]);
            $('#JSSpotlightEdit_' + spotlightId).html(ReturnHtml[1]);
        }
    });
}

window.SpotlightUpdate = function (spotlightId) {
    var form = $('#JSTrivia' + spotlightId).serialize() + '&action=update_spotlight';
    $.ajax({
        // The URL for the request
        url: 'db_trivia.php',
        data: form,
        type: 'POST',
        dataType: 'html',
        // Code to run if the request succeeds;
        success: function (html) {
            var returnHtml = html.split('[BRK]');
            $('#spotlight_list').html(returnHtml[0]);
            window.OSDMessageDisplay(returnHtml[1]);
            document.getElementById('spotlight').reset();
        }
    });
}

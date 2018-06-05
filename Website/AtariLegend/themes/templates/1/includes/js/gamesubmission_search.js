$(document).ready(function () {
    function SubmissionSearch () {
        var formValues = $('#JSCpanelGamesubmissionsSearchForm').serialize();

        $.ajaxQueue({
            // The URL for the request
            url: '../games/ajax_submission_games_search.php',
            data: formValues,
            type: 'GET',
            dataType: 'html',

            // Code to run if the request succeeds;
            // the response is passed to the function
            success: function (html) {
                $('#game_submission_list').html(html);
            }
        });
    }

    $('#JSCpanelAuthorBrowse').change(function () {
        SubmissionSearch();
    });

    $('select[name=submsission_searchYear]').change(function () {
        SubmissionSearch();
    });

    $('select[name=submsission_searchMonth]').change(function () {
        SubmissionSearch();
    });

    $('select[name=submsission_searchhDay]').change(function () {
        SubmissionSearch();
    });

    $('#JSDone').change(function () {
        SubmissionSearch();
    });

    $('#JSOpen').change(function () {
        SubmissionSearch();
    });
});

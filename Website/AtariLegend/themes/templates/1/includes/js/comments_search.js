$(document).ready(function () {
    function CommentsSearch () {
        var formValues = $('#JSCpanelCommentsSearchForm').serialize();

        $.ajaxQueue({
            // The URL for the request
            url: '../administration/ajax_comments_search.php',
            data: formValues,
            type: 'GET',
            dataType: 'html',

            // Code to run if the request succeeds;
            // the response is passed to the function
            success: function (html) {
                $('#column_center_cpanel').html(html);
            }
        });
    }

    $('#JSCpanelAuthorBrowse').change(function () {
        CommentsSearch();
    });

    $('select[name=comments_searchYear]').change(function () {
        CommentsSearch();
    });

    $('select[name=comments_searchMonth]').change(function () {
        CommentsSearch();
    });

    $('select[name=comments_searchDay]').change(function () {
        CommentsSearch();
    });
});

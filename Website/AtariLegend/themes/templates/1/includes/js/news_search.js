$(document).ready(function () {
    function NewsSearch () {
        var formValues = $('#JSCpanelNewsSearchForm').serialize();

        $.ajaxQueue({
            // The URL for the request
            url: '../news/ajax_news_search.php',
            data: formValues,
            type: 'GET',
            dataType: 'html',

            // Code to run if the request succeeds;
            // the response is passed to the function
            success: function (html) {
                $('#news_edit_list').html(html);
            }
        });
    }

    $('#JSCpanelNewsSearch').keyup(function () {
        var value = $(this).val();
        if (value.length >= 3 || value === '') {
            NewsSearch();
        }
    });

    $('#JSCpanelAuthorBrowse').change(function () {
        NewsSearch();
    });

    $('select[name=news_searchYear]').change(function () {
        NewsSearch();
    });

    $('select[name=news_searchMonth]').change(function () {
        NewsSearch();
    });

    $('select[name=news_searchDay]').change(function () {
        NewsSearch();
    });
});

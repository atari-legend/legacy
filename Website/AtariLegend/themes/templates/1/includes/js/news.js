$(document).ready(function () {
    // Edit News Function
    $('.jsNewsWrapper').on('click', '.jsNewsEditButton', function () {
        var newsId = $(this).data('news-id');
        var jsNewsTextBoxId = 'jsNewsTextBox'.concat(newsId);
        $.ajaxQueue({
            // The URL for the request
            url: 'ajax_news_approve_edit.php',
            data: 'action=get_newsapprove_text&news_id=' + newsId,
            type: 'GET',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                $('#' + jsNewsTextBoxId).html(html);
                listenSaveButton();
            }
        });
    })
    // Edit News Function dropdown item
    $('.jsNewsWrapper').on('click', '.jsNewsEditDropdownItem', function () {
        var newsId = $(this).data('news-id');
        var jsNewsTextBoxId = 'jsNewsTextBox'.concat(newsId);
        $.ajaxQueue({
            // The URL for the request
            url: 'ajax_news_approve_edit.php',
            data: 'action=get_newsapprove_text&news_id=' + newsId,
            type: 'GET',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                $('#' + jsNewsTextBoxId).html(html);
                listenSaveButton();
            }
        });
    })
    // Edit Save News Function
    function listenSaveButton () {
        $('.jsNewsWrapper').on('click', '.jsNewsEditSaveButton', function () {
            var newsId = $(this).data('news-id');
            var jsNewsTextBoxId = 'jsNewsTextBox'.concat(newsId);
            var newsText = $('#' + jsNewsTextBoxId + ' > #jsNewsText').val();

            $.ajaxQueue({
                // The URL for the request
                url: 'ajax_news_approve_edit.php',
                data: 'action=save_news_text&news_id=' + newsId + '&news_text=' + newsText,
                type: 'POST',
                dataType: 'html',
                // Code to run if the request succeeds;
                success: function (html) {
                    var returnHtml = html.split('[BRK]');
                    $('#' + jsNewsTextBoxId).html(returnHtml[0]);
                    window.OSDMessageDisplay(returnHtml[1]);
                }
            });
        })
    }
    // Delete Submission Function
    $('.jsNewsWrapper').on('click', '.jsNewsDeleteButton', function () {
        var newsId = $(this).data('news-id');
        $('#JSGenericModal').dialog({
            title: 'Delete Submission',
            open: $('#JSGenericModalText').text('Are you sure you want to delete this submission?'),
            resizable: false,
            height: 200,
            modal: true,
            buttons: {
                'Delete': function () {
                    $(this).dialog('close');
                    $.ajaxQueue({
                        // The URL for the request
                        url: 'db_news.php',
                        data: 'action=delete_submission&news_id=' + newsId,
                        type: 'POST',
                        dataType: 'html',
                        // Code to run if the request succeeds;
                        success: function (html) {
                            $('#jsNewsId' + newsId).html('');
                            window.OSDMessageDisplay(html);
                        }
                    });
                },
                Cancel: function () {
                    $(this).dialog('close');
                }
            }
        });
    })
    // Delete Comment Function in dropdown
    $('.jsNewsWrapper').on('click', '.jsNewsDeleteDropdownItem', function () {
        var newsId = $(this).data('news-id');
        $('#JSGenericModal').dialog({
            title: 'Delete Submission',
            open: $('#JSGenericModalText').text('Are you sure you want to delete this submission?'),
            resizable: false,
            height: 200,
            modal: true,
            buttons: {
                'Delete': function () {
                    $(this).dialog('close');
                    $.ajaxQueue({
                        // The URL for the request
                        url: 'db_news.php',
                        data: 'action=delete_submission&news_id=' + newsId,
                        type: 'POST',
                        dataType: 'html',
                        // Code to run if the request succeeds;
                        success: function (html) {
                            $('#jsNewsId' + newsId).html('');
                            window.OSDMessageDisplay(html);
                        }
                    });
                },
                Cancel: function () {
                    $(this).dialog('close');
                }
            }
        });
    })

    $(window).scroll(function () {
        if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
            var lastTimestamp = $('.comments_post_box:last').attr('id');
            loadMoreData(lastTimestamp);
        }
    });

    $('.jsCommentsWrapper').on('click', '.comments_button_dropdown', function () {
        var dropdownId = $(this).data('dropdown-id');
        $('#dropdown_box' + dropdownId).toggle('.dropdown_show');
    })

    function loadMoreData (lastTimestamp) {
        var view = $('#view').html();
        if (view === 'users_comments') {
            var userId = $('.jsUserCommentsLink:first').data('user-id');
        }
        $.ajaxQueue({
            // The URL for the request
            url: 'ajax_comments.php',
            data: 'action=autoload&view=' + view + '&last_timestamp=' + lastTimestamp + '&user_id=' + userId,
            type: 'GET',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                $('.infinite-item:last').append(html);
            }
        });
    }
})

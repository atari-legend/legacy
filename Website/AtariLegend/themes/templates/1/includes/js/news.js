$(document).ready(function () {
    $('select[name=members]').altAutocomplete();

    // ***********************
    // NEWS APPROVE BUTTONS //
    // ***********************

    // Edit News Function
    $('.jsNewsWrapper').on('click', '.jsNewsEditButton', function () {
        var newsId = $(this).data('news-id');
        var jsNewsEditBoxId = 'jsNewsEditBox'.concat(newsId);
        $.ajaxQueue({
            // The URL for the request
            url: 'ajax_news_approve_edit.php',
            data: 'action=get_newsapprove_text&news_id=' + newsId,
            type: 'GET',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                $('#' + jsNewsEditBoxId).html(html);
            }
        });
    })
    // Edit News Function dropdown item
    $('.jsNewsWrapper').on('click', '.jsNewsEditDropdownItem', function () {
        var newsId = $(this).data('news-id');
        var jsNewsEditBoxId = 'jsNewsEditBox'.concat(newsId);
        $.ajaxQueue({
            // The URL for the request
            url: 'ajax_news_approve_edit.php',
            data: 'action=get_newsapprove_text&news_id=' + newsId,
            type: 'GET',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                $('#' + jsNewsEditBoxId).html(html);
            }
        });
    })
    // Edit Save News Function
    $('.jsNewsWrapper').on('click', '.jsNewsEditSaveButton', function () {
        var newsId = $(this).data('news-id');
        var jsNewsEditBox = 'jsNewsEditBox'.concat(newsId);
        var newsText = $('#' + jsNewsEditBox + ' > #jsNewsText').val();
        newsText = newsText.replace(/\n\r?/g, '<br />');
        var newsHeadline = $('#' + jsNewsEditBox + ' > #JsHeadlineText').val();
        var newsUserId = $('#' + jsNewsEditBox + ' > #member_select').val();
        var newsImageId = $('#' + jsNewsEditBox + ' > #news_images_select').val();

        var dateDay = newsId + 'Date_Day';
        var dateMonth = newsId + 'Date_Month';
        var dateYear = newsId + 'Date_Year';

        var day = document.getElementById(dateDay).value;
        var month = document.getElementById(dateMonth).value;
        var year = document.getElementById(dateYear).value;

        $.ajaxQueue({
            // The URL for the request
            url: 'db_news.php',
            data: 'action=save_news_text&news_id=' + newsId + '&news_text=' + newsText + '&news_headline=' + newsHeadline + '&news_userid=' + newsUserId + '&news_image_id=' + newsImageId + '&news_day=' + day + '&news_month=' + month + '&news_year=' + year,
            type: 'POST',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                var returnHtml = html.split('[BRK]');
                $('#news_submission_list').html(returnHtml[0]);
                window.OSDMessageDisplay(returnHtml[1]);
                document.getElementById('post').reset();
            },
            error: function (xhr, status, error) {
            }
        });
    })
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
                            var returnHtml = html.split('[BRK]');
                            $('#news_submission_list').html(returnHtml[0]);
                            window.OSDMessageDisplay(returnHtml[1]);
                            document.getElementById('post').reset();
                        }
                    });
                },
                Cancel: function () {
                    $(this).dialog('close');
                }
            }
        });
    })
    // Delete submission Function in dropdown
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
                            var returnHtml = html.split('[BRK]');
                            $('#news_submission_list').html(returnHtml[0]);
                            window.OSDMessageDisplay(returnHtml[1]);
                            document.getElementById('post').reset();
                        }
                    });
                },
                Cancel: function () {
                    $(this).dialog('close');
                }
            }
        });
    })
    // Approve Submission Function
    $('.jsNewsWrapper').on('click', '.jsNewsApproveButton', function () {
        var newsId = $(this).data('news-id');
        $('#JSGenericModal').dialog({
            title: 'Approve Submission',
            open: $('#JSGenericModalText').text('Are you sure you want to approve this submission?'),
            resizable: false,
            height: 200,
            modal: true,
            buttons: {
                'Approve': function () {
                    $(this).dialog('close');
                    $.ajaxQueue({
                        // The URL for the request
                        url: 'db_news.php',
                        data: 'action=approve_submission&news_submission_id=' + newsId,
                        type: 'POST',
                        dataType: 'html',
                        // Code to run if the request succeeds;
                        success: function (html) {
                            var returnHtml = html.split('[BRK]');
                            $('#news_submission_list').html(returnHtml[0]);
                            window.OSDMessageDisplay(returnHtml[1]);
                            document.getElementById('post').reset();
                        }
                    });
                },
                Cancel: function () {
                    $(this).dialog('close');
                }
            }
        });
    })
    // Approve submission Function in dropdown
    $('.jsNewsWrapper').on('click', '.jsNewsApproveDropdownItem', function () {
        var newsId = $(this).data('news-id');
        $('#JSGenericModal').dialog({
            title: 'Approve Submission',
            open: $('#JSGenericModalText').text('Are you sure you want to approve this submission?'),
            resizable: false,
            height: 200,
            modal: true,
            buttons: {
                'Approve': function () {
                    $(this).dialog('close');
                    $.ajaxQueue({
                        // The URL for the request
                        url: 'db_news.php',
                        data: 'action=approve_submission&news_submission_id=' + newsId,
                        type: 'POST',
                        dataType: 'html',
                        // Code to run if the request succeeds;
                        success: function (html) {
                            var returnHtml = html.split('[BRK]');
                            $('#news_submission_list').html(returnHtml[0]);
                            window.OSDMessageDisplay(returnHtml[1]);
                            document.getElementById('post').reset();
                        }
                    });
                },
                Cancel: function () {
                    $(this).dialog('close');
                }
            }
        });
    })

    // ******************
    // NEWS EDIT BUTTONS
    // ******************
    // Edit News Function
    $('.jsNewsWrapper').on('click', '.jsNewsPostEditButton', function () {
        var newsId = $(this).data('news-id');
        var jsNewsEditBoxId = 'jsNewsEditBox'.concat(newsId);
        $.ajaxQueue({
            // The URL for the request
            url: 'ajax_news_post_edit.php',
            data: 'action=get_newspost_text&news_id=' + newsId,
            type: 'GET',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                $('#' + jsNewsEditBoxId).html(html);
            }
        });
    })
    // Edit News Function dropdown item
    $('.jsNewsWrapper').on('click', '.jsNewsPostEditDropdownItem', function () {
        var newsId = $(this).data('news-id');
        var jsNewsEditBoxId = 'jsNewsEditBox'.concat(newsId);
        $.ajaxQueue({
            // The URL for the request
            url: 'ajax_news_post_edit.php',
            data: 'action=get_newspost_text&news_id=' + newsId,
            type: 'GET',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                $('#' + jsNewsEditBoxId).html(html);
            }
        });
    })
    // Edit Save News Function
    $('.jsNewsWrapper').on('click', '.jsNewsPostEditSaveButton', function () {
        var newsId = $(this).data('news-id');
        var jsNewsEditBox = 'jsNewsEditBox'.concat(newsId);
        var newsText = $('#' + jsNewsEditBox + ' > #jsNewsText').val();
        newsText = newsText.replace(/\n\r?/g, '<br />');
        var newsHeadline = $('#' + jsNewsEditBox + ' > #JsHeadlineText').val();
        var newsUserId = $('#' + jsNewsEditBox + ' > #member_select').val();
        var newsImageId = $('#' + jsNewsEditBox + ' > #news_images_select').val();

        var dateDay = newsId + 'Date_Day';
        var dateMonth = newsId + 'Date_Month';
        var dateYear = newsId + 'Date_Year';

        var day = document.getElementById(dateDay).value;
        var month = document.getElementById(dateMonth).value;
        var year = document.getElementById(dateYear).value;

        $.ajaxQueue({
            // The URL for the request
            url: 'db_news.php',
            data: 'action=save_news_post_text&news_id=' + newsId + '&news_text=' + newsText + '&news_headline=' + newsHeadline + '&news_userid=' + newsUserId + '&news_image_id=' + newsImageId + '&news_day=' + day + '&news_month=' + month + '&news_year=' + year,
            type: 'POST',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                var returnHtml = html.split('[BRK]');
                $('#' + jsNewsEditBox).html(returnHtml[0]);
                window.OSDMessageDisplay(returnHtml[1]);
            },
            error: function (xhr, status, error) {
            }
        });
    })
    // Delete news Function
    $('.jsNewsWrapper').on('click', '.jsNewsPostDeleteButton', function () {
        var newsId = $(this).data('news-id');
        $('#JSGenericModal').dialog({
            title: 'Delete News Post',
            open: $('#JSGenericModalText').text('Are you sure you want to delete this news post?'),
            resizable: false,
            height: 200,
            modal: true,
            buttons: {
                'Delete': function () {
                    $(this).dialog('close');
                    $.ajaxQueue({
                        // The URL for the request
                        url: 'db_news.php',
                        data: 'action=delete_news&news_id=' + newsId,
                        type: 'POST',
                        dataType: 'html',
                        // Code to run if the request succeeds;
                        success: function (html) {
                            var begin = html.startsWith('You');
                            if (begin) {
                            } else {
                                $('#jsNewsId' + newsId).html('');
                            }
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
    // Delete news Function in dropdown
    $('.jsNewsWrapper').on('click', '.jsNewsPostDeleteDropdownItem', function () {
        var newsId = $(this).data('news-id');
        $('#JSGenericModal').dialog({
            title: 'Delete News Post',
            open: $('#JSGenericModalText').text('Are you sure you want to delete this news post?'),
            resizable: false,
            height: 200,
            modal: true,
            buttons: {
                'Delete': function () {
                    $(this).dialog('close');
                    $.ajaxQueue({
                        // The URL for the request
                        url: 'db_news.php',
                        data: 'action=delete_news&news_id=' + newsId,
                        type: 'POST',
                        dataType: 'html',
                        // Code to run if the request succeeds;
                        success: function (html) {
                            var begin = html.startsWith('You');
                            if (begin) {
                            } else {
                                $('#jsNewsId' + newsId).html('');
                            }
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

    $('.jsNewsWrapper').on('click', '.news_button_dropdown', function () {
        var dropdownId = $(this).data('dropdown-id');
        $('#dropdown_box' + dropdownId).toggle('.dropdown_show');
    })

    $(window).scroll(function () {
        if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
            var lastTimestamp = $('.news_post_box:last').attr('id');
            loadMoreData(lastTimestamp);
        }
    });

    function loadMoreData (lastTimestamp) {
        var userId = $('#JSCpanelAuthorBrowse option:selected').val();
        var newsSearch = $('#JSCpanelNewsSearch').val();

        $.ajaxQueue({
            // The URL for the request
            url: 'ajax_news_edit.php',
            data: 'action=autoload&last_timestamp=' + lastTimestamp + '&user_id=' + userId + '&newssearch=' + newsSearch,
            type: 'GET',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                $('.infinite-item:last').append(html);
            }
        });
    }
})

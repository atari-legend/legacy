$(document).ready(function () {
    $('#comments_all').click(function () {
        $.ajaxQueue({
            // The URL for the request
            url: 'ajax_comments.php',
            data: 'view=comments_all',
            type: 'GET',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                $('.jsCommentsWrapper').html(html);
            }
        });
    })
    $('#comments_game_comments').click(function () {
        $.ajaxQueue({
            // The URL for the request
            url: 'ajax_comments.php',
            data: 'view=comments_game_comments',
            type: 'GET',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                $('.jsCommentsWrapper').html(html);
            }
        });
    })
    $('#comments_game_review_comments').click(function () {
        $.ajaxQueue({
            // The URL for the request
            url: 'ajax_comments.php',
            data: 'view=comments_game_review_comments',
            type: 'GET',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                $('.jsCommentsWrapper').html(html);
            }
        });
    })
    $('#comments_interview_comments').click(function () {
        $.ajaxQueue({
            // The URL for the request
            url: 'ajax_comments.php',
            data: 'view=comments_interview_comments',
            type: 'GET',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                $('.jsCommentsWrapper').html(html);
            }
        });
    })
    $('.jsCommentsWrapper').on('click', '.jsUserCommentsLink', function () {
        var view = 'users_comments';
        var userId = $(this).data('user-id');
        $.ajaxQueue({
            // The URL for the request
            url: 'ajax_comments.php',
            data: 'view=' + view + '&user_id=' + userId,
            type: 'GET',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                $('.jsCommentsWrapper').html(html);
            }
        });
    })
    // Edit Comment Function
    $('.jsCommentsWrapper').on('click', '.jsCommentsEditButton', function () {
        var commentsId = $(this).data('comments-id');
        var commentType = $(this).data('comment-type');
        var jsCommentTextBoxId = 'jsCommentTextBox'.concat(commentsId);
        $.ajaxQueue({
            // The URL for the request
            url: 'ajax_comments_edit.php',
            data: 'action=get_comment_text&comments_id=' + commentsId + '&comment_type=' + commentType,
            type: 'GET',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                $('#' + jsCommentTextBoxId).html(html);
                // listenSaveButton();
            }
        });
    })
    // Edit Comment Function dropdown item
    $('.jsCommentsWrapper').on('click', '.jsCommentsEditDropdownItem', function () {
        var commentsId = $(this).data('comments-id');
        var commentType = $(this).data('comment-type');
        var jsCommentTextBoxId = 'jsCommentTextBox'.concat(commentsId);
        $.ajaxQueue({
            // The URL for the request
            url: 'ajax_comments_edit.php',
            data: 'action=get_comment_text&comments_id=' + commentsId + '&comment_type=' + commentType,
            type: 'GET',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                $('#' + jsCommentTextBoxId).html(html);
                // listenSaveButton();
            }
        });
    })
    // Edit Save Comment Function
    $('.jsCommentsWrapper').on('click', '.jsCommentsEditSaveButton', function () {
        var commentsId = $(this).data('comments-id');
        var commentType = $(this).data('comment-type');
        var jsCommentTextBoxId = 'jsCommentTextBox'.concat(commentsId);
        var commentText = $('#' + jsCommentTextBoxId + ' > #jsCommentText').val();

        $.ajaxQueue({
            // The URL for the request
            url: 'ajax_comments_edit.php',
            data: 'action=save_comment_text&comments_id=' + commentsId + '&comment_text=' + commentText + '&comment_type=' + commentType,
            type: 'POST',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                var returnHtml = html.split('[BRK]');
                $('#' + jsCommentTextBoxId).html(returnHtml[0]);
                window.OSDMessageDisplay(returnHtml[1]);
            }
        });
    })
    // Delete Comment Function
    $('.jsCommentsWrapper').on('click', '.jsCommentsDeleteButton', function () {
        var commentsId = $(this).data('comments-id');
        $('#JSGenericModal').dialog({
            title: 'Delete Comment',
            open: $('#JSGenericModalText').text('Are you sure you want to delete this comment?'),
            resizable: false,
            height: 200,
            modal: true,
            buttons: {
                'Delete': function () {
                    $(this).dialog('close');
                    $.ajaxQueue({
                        // The URL for the request
                        url: 'db_comments.php',
                        data: 'action=delete&comments_id=' + commentsId,
                        type: 'POST',
                        dataType: 'html',
                        // Code to run if the request succeeds;
                        success: function (html) {
                            var begin = html.startsWith('You');
                            if (begin) {
                            } else {
                                $('#jsCommentId' + commentsId).html('');
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
    // Delete Comment Function in dropdown
    $('.jsCommentsWrapper').on('click', '.jsCommentsDeleteDropdownItem', function () {
        var commentsId = $(this).data('comments-id');
        $('#JSGenericModal').dialog({
            title: 'Delete Comment',
            open: $('#JSGenericModalText').text('Are you sure you want to delete this comment?'),
            resizable: false,
            height: 200,
            modal: true,
            buttons: {
                'Delete': function () {
                    $(this).dialog('close');
                    $.ajaxQueue({
                        // The URL for the request
                        url: 'db_comments.php',
                        data: 'action=delete&comments_id=' + commentsId,
                        type: 'POST',
                        dataType: 'html',
                        // Code to run if the request succeeds;
                        success: function (html) {
                            var begin = html.startsWith('You');
                            if (begin) {
                            } else {
                                $('#jsCommentId' + commentsId).html('');
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

/*!
 * game_submission.js
 */
$(document).ready(function () {
    // Approve submission Function (move to 'done' status)
    $('.jsSubmissionWrapper').on('click', '.jsSubmissionApproveButton', function () {
        var submissionId = $(this).data('submission-id');
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
                        url: 'db_games_submissions.php',
                        data: 'action=update_submission&submit_id=' + submissionId,
                        type: 'POST',
                        dataType: 'html',
                        // Code to run if the request succeeds;
                        success: function (html) {
                            var returnHtml = html.split('[BRK]');
                            $('#game_submission_list').html(returnHtml[0]);
                            window.OSDMessageDisplay(returnHtml[1]);
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
    $('.jsSubmissionWrapper').on('click', '.jsSubmissionApproveDropdownItem', function () {
        var submissionId = $(this).data('submission-id');
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
                        url: 'db_games_submissions.php',
                        data: 'action=update_submission&submit_id=' + submissionId,
                        type: 'POST',
                        dataType: 'html',
                        // Code to run if the request succeeds;
                        success: function (html) {
                            var returnHtml = html.split('[BRK]');
                            $('#game_submission_list').html(returnHtml[0]);
                            window.OSDMessageDisplay(returnHtml[1]);
                        }
                    });
                },
                Cancel: function () {
                    $(this).dialog('close');
                }
            }
        });
    })
    // Delete Submission Function
    $('.jsSubmissionWrapper').on('click', '.jsSubmissionDeleteButton', function () {
        var submissionId = $(this).data('submission-id');
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
                        url: 'db_games_submissions.php',
                        data: 'action=delete_submission&submit_id=' + submissionId,
                        type: 'POST',
                        dataType: 'html',
                        // Code to run if the request succeeds;
                        success: function (html) {
                            var returnHtml = html.split('[BRK]');
                            $('#game_submission_list').html(returnHtml[0]);
                            window.OSDMessageDisplay(returnHtml[1]);
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
    $('.jsSubmissionWrapper').on('click', '.jsSubmissionDeleteDropdownItem', function () {
        var submissionId = $(this).data('submission-id');
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
                        url: 'db_games_submissions.php',
                        data: 'action=delete_submission&submit_id=' + submissionId,
                        type: 'POST',
                        dataType: 'html',
                        // Code to run if the request succeeds;
                        success: function (html) {
                            var returnHtml = html.split('[BRK]');
                            $('#game_submission_list').html(returnHtml[0]);
                            window.OSDMessageDisplay(returnHtml[1]);
                        }
                    });
                },
                Cancel: function () {
                    $(this).dialog('close');
                }
            }
        });
    })
    // Delete Submission Function
    $('.jsSubmissionWrapper').on('click', '.jsSubmissionMoveButton', function () {
        var submissionId = $(this).data('submission-id');
        $('#JSGenericModal').dialog({
            title: 'Delete Submission',
            open: $('#JSGenericModalText').text('Are you sure you want to move this submission to the comments section?'),
            resizable: false,
            height: 200,
            modal: true,
            buttons: {
                'Move': function () {
                    $(this).dialog('close');
                    $.ajaxQueue({
                        // The URL for the request
                        url: 'db_games_submissions.php',
                        data: 'action=move_submission_tocomment&submit_id=' + submissionId,
                        type: 'POST',
                        dataType: 'html',
                        // Code to run if the request succeeds;
                        success: function (html) {
                            var returnHtml = html.split('[BRK]');
                            $('#game_submission_list').html(returnHtml[0]);
                            window.OSDMessageDisplay(returnHtml[1]);
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
    $('.jsSubmissionWrapper').on('click', '.jsSubmissionCommentDropdownItem', function () {
        var submissionId = $(this).data('submission-id');
        $('#JSGenericModal').dialog({
            title: 'Delete Submission',
            open: $('#JSGenericModalText').text('Are you sure you want to move this submission to the comments section?'),
            resizable: false,
            height: 200,
            modal: true,
            buttons: {
                'Move': function () {
                    $(this).dialog('close');
                    $.ajaxQueue({
                        // The URL for the request
                        url: 'db_games_submissions.php',
                        data: 'action=move_submission_tocomment&submit_id=' + submissionId,
                        type: 'POST',
                        dataType: 'html',
                        // Code to run if the request succeeds;
                        success: function (html) {
                            var returnHtml = html.split('[BRK]');
                            $('#game_submission_list').html(returnHtml[0]);
                            window.OSDMessageDisplay(returnHtml[1]);
                        }
                    });
                },
                Cancel: function () {
                    $(this).dialog('close');
                }
            }
        });
    })

    $('.jsSubmissionWrapper').on('click', 'submission_button_dropdown', function () {
        var dropdownId = $(this).data('dropdown-id');
        $('#dropdown_box' + dropdownId).toggle('.dropdown_show');
    })

    $(window).scroll(function () {
        if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
            var lastTimestamp = $('.submission_post_box:last').attr('id');
            loadMoreData(lastTimestamp);
        }
    });

    function loadMoreData (lastTimestamp) {
        var done = $('#JSdone').html();
        $.ajaxQueue({
            // The URL for the request
            url: 'ajax_submission_games.php',
            data: 'action=autoload&last_timestamp=' + lastTimestamp + '&done=' + done,
            type: 'GET',
            dataType: 'html',
            // Code to run if the request succeeds;
            success: function (html) {
                $('.infinite-item:last').append(html);
            }
        });
    }
})

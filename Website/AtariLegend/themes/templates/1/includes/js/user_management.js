$(document).ready(function () {
    function UserSearch () {
        var formValues = $('#user_search').serialize();

        $.ajaxQueue({
            // The URL for the request
            url: 'ajax_user_management.php',
            data: formValues,
            type: 'GET',
            dataType: 'html',

            // Code to run if the request succeeds;
            // the response is passed to the function
            success: function (html) {
                $('#ajax_usersearch').html(html);
            }
        });
    }

    $('#jsUserBrowse').change(function () {
        UserSearch();
    });
    $('#js_user_search').keyup(function () {
        var value = $(this).val();
        if (value.length >= 3 || value === '') {
            UserSearch();
        }
    });
    $('#no_comments').change(function () {
        if ($(this).is(':checked')) {
            $('#with_comments').prop('checked', false);
        }
        UserSearch();
    });
    $('#with_comments').change(function () {
        if ($(this).is(':checked')) {
            $('#no_comments').prop('checked', false);
        }
        UserSearch();
    });
    $('#no_submissions').change(function () {
        if ($(this).is(':checked')) {
            $('#with_submissions').prop('checked', false);
        }
        UserSearch();
    });
    $('#with_submissions').change(function () {
        if ($(this).is(':checked')) {
            $('#no_submissions').prop('checked', false);
        }
        UserSearch();
    });
    $('#no_email').change(function () {
        if ($(this).is(':checked')) {
            $('#with_email').prop('checked', false);
        }
        UserSearch();
    });
    $('#with_email').change(function () {
        if ($(this).is(':checked')) {
            $('#no_email').prop('checked', false);
        }
        UserSearch();
    });
    $('#no_news').change(function () {
        if ($(this).is(':checked')) {
            $('#with_news').prop('checked', false);
        }
        UserSearch();
    });
    $('#with_news').change(function () {
        if ($(this).is(':checked')) {
            $('#no_news').prop('checked', false);
        }
        UserSearch();
    });
    $('#no_links').change(function () {
        if ($(this).is(':checked')) {
            $('#with_links').prop('checked', false);
        }
        UserSearch();
    });
    $('#with_links').change(function () {
        if ($(this).is(':checked')) {
            $('#no_links').prop('checked', false);
        }
        UserSearch();
    });
    $('#no_interviews').change(function () {
        if ($(this).is(':checked')) {
            $('#with_interviews').prop('checked', false);
        }
        UserSearch();
    });
    $('#with_interviews').change(function () {
        if ($(this).is(':checked')) {
            $('#no_interviews').prop('checked', false);
        }
        UserSearch();
    });
    $('#no_review').change(function () {
        if ($(this).is(':checked')) {
            $('#with_review').prop('checked', false);
        }
        UserSearch();
    });
    $('#with_review').change(function () {
        if ($(this).is(':checked')) {
            $('#no_review').prop('checked', false);
        }
        UserSearch();
    });
    $('#not_admin').change(function () {
        if ($(this).is(':checked')) {
            $('#is_admin').prop('checked', false);
        }
        UserSearch();
    });
    $('#is_admin').change(function () {
        if ($(this).is(':checked')) {
            $('#not_admin').prop('checked', false);
        }
        UserSearch();
    });
    $('#last_visit').change(function () {
        UserSearch();
    });
});

$(document).ajaxComplete(function () {
    UserlistFunction();
});

$(document).ready(function () {
    UserlistFunction();
});

function UserlistFunction () {
    // select all checkboxes in list
    $('#user_select_all').click(function () {
        $('.user_checkbox').prop('checked', $(this).prop('checked'));
    });

    // Are you sure question Delete
    $('#user_list_action').change(function () {
        if ($(this).val() === 'delete_user') {
            $('#JSGenericModal').dialog({
                title: 'Delete Users?',
                open: $('#JSGenericModalText').text('These users will be permanently deleted. Are you sure?'),
                resizable: false,
                height: 200,
                modal: true,
                buttons: {
                    'Delete': function () {
                        $(this).dialog('close');
                        UserModify();
                    },
                    Cancel: function () {
                        $(this).dialog('close');
                    }
                }
            });
        }
        if ($(this).val() === 'deactivate_user') {
            $('#JSGenericModal').dialog({
                title: 'Deactivate Users?',
                open: $('#JSGenericModalText').text('These users will be deactivated. Are you sure?'),
                resizable: false,
                height: 200,
                modal: true,
                buttons: {
                    'Deactivate': function () {
                        $(this).dialog('close');
                        UserModify();
                    },
                    Cancel: function () {
                        $(this).dialog('close');
                    }
                }
            });
        }
        if ($(this).val() === 'activate_user') {
            $('#JSGenericModal').dialog({
                title: 'Activate Users?',
                open: $('#JSGenericModalText').text('These users will be activated. Are you sure?'),
                resizable: false,
                height: 200,
                modal: true,
                buttons: {
                    'Activate': function () {
                        $(this).dialog('close');
                        UserModify();
                    },
                    Cancel: function () {
                        $(this).dialog('close');
                    }
                }
            });
        }
        if ($(this).val() === 'email_user') {
            $('#email_fields').css('display', 'block');
            sendEmail();
        }
    });
}

function UserModify () {
    var formValues = $('#user_list').serialize();
    $.ajaxQueue({
        url: 'db_user_management.php',
        data: formValues,
        type: 'POST',
        dataType: 'text',
        // Code to run if the request succeeds;
        success: function (text) {
            window.OSDMessageDisplay(text);
            // Reload userlist
            var formValues = $('#user_search').serialize();
            $.ajaxQueue({
                url: 'ajax_user_management.php',
                data: formValues,
                type: 'GET',
                dataType: 'html',
                // Code to run if the request succeeds;
                success: function (html) {
                    $('#ajax_usersearch').html(html);
                }
            });
        }
    });
}
function sendEmail () {
    $('#jsEmailBtn').click(function () {
        EmailSent();
    });

    function EmailSent () {
        $('#JSGenericModal').dialog({
            title: 'Email users?',
            open: $('#JSGenericModalText').text('Email users?'),
            resizable: false,
            height: 200,
            modal: true,
            buttons: {
                'Email user(s)': function () {
                    $(this).dialog('close');
                    var formValues = $('#user_list').serialize() + '&action=email_user';
                    $.ajaxQueue({
                        // The URL for the request
                        url: 'db_user_management.php',
                        data: formValues,
                        type: 'POST',
                        dataType: 'html',

                        // Code to run if the request succeeds;
                        // the response is passed to the function
                        success: function (html) {
                            window.OSDMessageDisplay(html);
                            $('#email_fields').css('display', 'none');
                        }
                    });
                },
                Cancel: function () {
                    $(this).dialog('close');
                    $('#email_fields').css('display', 'none');
                }
            }
        });
    }
}

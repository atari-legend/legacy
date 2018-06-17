window.GameSearch = (function () {
    function GameSearch () {
        var formValues = $('#JSCpanelGameSearchForm').serialize();

        $.ajaxQueue({
            // The URL for the request
            url: '../games/ajax_game_search.php',
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

    function addNewGame () {
        var JSnewgame = $('#JSNewgameName').val();
        if (JSnewgame === '') {
            alert('Please fill in a game name');
        } else {
            $('#JSGenericModal').dialog({
                title: 'Add new game?',
                open: $('#JSGenericModalText').text('Are you sure you want to insert this game into the database?'),
                resizable: false,
                height: 200,
                modal: true,
                buttons: {
                    'Add': function () {
                        $(this).dialog('close');
                        var url = '../games/db_games_detail.php?newgame=' + JSnewgame + '&action=insert_game';
                        location.href = url;
                    },
                    Cancel: function () {
                        $(this).dialog('close');
                    }
                }
            });
        }
    }
    $('#JSResetButton').click(function () {
        $('#JSCpanelGameSearchForm').trigger('reset');
        $('#JSCpanelGameBrowse').val('num').prop('selected', true);
        GameSearch();
    })
    $('#JSNewgameButton').click(function () {
        addNewGame();
    })

    $('#JSCpanelGameBrowse').change(function () {
        GameSearch();
    });
    $('#JSCpanelPublisherBrowse').change(function () {
        GameSearch();
    });
    $('#JSCpanelDeveloperBrowse').change(function () {
        GameSearch();
    });
    $('#JSCpanelYearBrowse').change(function () {
        GameSearch();
    });
    $('#JSCpanelGameSearch').keyup(function () {
        var value = $(this).val();
        if (value.length >= 3 || value === '') {
            $('#JSCpanelGameBrowse').val('1');
            GameSearch();
        }
    });

    window.JSPublisherSelect = function (publisherId) {
        $('#JSCpanelPublisherBrowse').val(publisherId).prop('selected', true);
        $('#JSCpanelGameBrowse').val('-').prop('selected', true);
        $('#JSCpanelDeveloperBrowse').val('-').prop('selected', true);
        $('#JSCpanelYearBrowse').val('-').prop('selected', true);
        GameSearch();
    };
    window.JSDeveloperSelect = function (developerId) {
        $('#JSCpanelDeveloperBrowse').val(developerId).prop('selected', true);
        $('#JSCpanelGameBrowse').val('-').prop('selected', true);
        $('#JSCpanelPublisherBrowse').val('-').prop('selected', true);
        $('#JSCpanelYearBrowse').val('-').prop('selected', true);
        GameSearch();
    };
    window.JSYearSelect = function (yearId) {
        $('#JSCpanelYearBrowse').val(yearId).prop('selected', true);
        $('#JSCpanelGameBrowse').val('-').prop('selected', true);
        $('#JSCpanelPublisherBrowse').val('-').prop('selected', true);
        $('#JSCpanelDeveloperBrowse').val('-').prop('selected', true);
        GameSearch();
    };
    $('#JSfalcon_only').change(function () {
        if ($(this).is(':checked')) {
            $('#JSste_enhanced').prop('checked', false);
            $('#JSste_only').prop('checked', false);
        }
        GameSearch();
    });
    $('#JSfalcon_enhanced').change(function () {
        if ($(this).is(':checked')) {
            $('#JSste_only').prop('checked', false);
        }
        GameSearch();
    });
    $('#JSfalcon_rgb').change(function () {
        if ($(this).is(':checked')) {
            $('#JSste_only').prop('checked', false);
        }
        GameSearch();
    });
    $('#JSfalcon_vga').change(function () {
        if ($(this).is(':checked')) {
            $('#JSste_only').prop('checked', false);
        }
        GameSearch();
    });
    $('#JSste_only').change(function () {
        if ($(this).is(':checked')) {
            $('JSfalcon_enhanced').prop('checked', false);
            $('#JSfalcon_only').prop('checked', false);
            $('#JSfalcon_rgb').prop('checked', false);
            $('#JSfalcon_vga').prop('checked', false);
        }
        GameSearch();
    });
    $('#JSste_enhanced').change(function () {
        if ($(this).is(':checked')) {
            $('#JSfalcon_only').prop('checked', false);
        }
        GameSearch();
    });
    $('#JScommercial').change(function () {
        if ($(this).is(':checked')) {
            $('#JSfree').prop('checked', false);
        }
        GameSearch();
    });
    $('#JSfree').change(function () {
        if ($(this).is(':checked')) {
            $('#JScommercial').prop('checked', false);
        }
        GameSearch();
    });
    $('#JSarcade').change(function () {
        GameSearch();
    });
    $('#JSdevelopment').change(function () {
        GameSearch();
    });
    $('#JSwanted').change(function () {
        GameSearch();
    });
    $('#JSunreleased').change(function () {
        GameSearch();
    });
    $('#JSunfinished').change(function () {
        GameSearch();
    });
    $('#JSmonochrome').change(function () {
        GameSearch();
    });
    $('#JSseuck').change(function () {
        GameSearch();
    });
    $('#JSstos').change(function () {
        GameSearch();
    });
    $('#JSstac').change(function () {
        GameSearch();
    });
    $('#JSboxscan').change(function () {
        GameSearch();
    });
    $('#JSscreenshot').change(function () {
        GameSearch();
    });

    return {
        GameSearch: GameSearch
    }
})();

$(document).ready(function () {
    function GameSearch () {
        var formValues = $('#JSCpanelGameSearchForm').serialize();

        $.ajaxQueue({
            // The URL for the request
            url: 'ajax_game_search.php',
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

    $('#JSCpanelGameBrowse').change(function () {
        GameSearch();
    });
    $('#JSCpanelGameSearch').keyup(function () {
        var value = $(this).val();
        if (value.length >= 3 || value === '') {
            $('#JSCpanelGameBrowse').val('1');
            GameSearch();
        }
    });
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
    $('#JSfree').change(function () {
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
});

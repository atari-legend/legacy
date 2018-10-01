/*!
 * game_config.js
 */
$(document).ready(function () {
    $('.tabs').tabs();

    $('select[name=engine_select]').change(function () {
        hideShow('engine');
    });

    $('select[name=programming_language_select]').change(function () {
        hideShow('programming_language');
    });

    $('select[name=genre_select]').change(function () {
        hideShow('genre');
    });

    $('select[name=port_select]').change(function () {
        hideShow('port');
    });

    $('select[name=individual_role_select]').change(function () {
        hideShow('individual_role');
    });

    $('select[name=developer_role_select]').change(function () {
        hideShow('developer_role');
    });

    $('select[name=control_select]').change(function () {
        hideShow('control');
    });

    $('select[name=resolution_select]').change(function () {
        hideShow('resolution');
    });

    $('select[name=system_select]').change(function () {
        hideShow('system');
    });

    $('select[name=emulator_select]').change(function () {
        hideShow('emulator');
    });

    $('select[name=trainer_option_select]').change(function () {
        hideShow('trainer_option');
    });
    $('select[name=memory_select]').change(function () {
        hideShow('memory');
    });
    $('select[name=tos_select]').change(function () {
        hideShow('tos');
    });
});

function hideShow (type) {
    var select = '#' + type + '_select';
    var edit = '#' + type + '_edit';
    var mod = '#' + type + '_mod';
    var del = '#' + type + '_del';
    var inputEdit = 'input[name=' + type + '_edit]';
    var inputEditId = 'input[name=' + type + '_id_edit]';
    var selected = '#' + type + '_select option:selected';

    if ($(select).val() === '') {
        $(edit).hide();
        $(mod).hide();
        $(del).hide();
    } else {
        $(edit).show();
        $(mod).show();
        $(del).show();
    }
    $(inputEdit).val($(selected).text());
    $(inputEditId).val($(selected).val());
}

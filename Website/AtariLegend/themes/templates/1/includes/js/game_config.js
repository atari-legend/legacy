/*!
 * game_config.js
 */
$(document).ready(function () {
    $('.tabs').tabs();
    $('select[name=engine_select]').change(function () {
        hideShow('engine');
        $('input[name=engine_edit]').val($('#engine_select option:selected').text());
        $('input[name=engine_id_edit]').val($('#engine_select option:selected').val());
    });

    $('select[name=programming_language_select]').change(function () {
        hideShow('programming_language');
        $('input[name=programming_language_edit]').val($('#programming_language_select option:selected').text());
        $('input[name=programming_language_id_edit]').val($('#programming_language_select option:selected').val());
    });

    $('select[name=genre_select]').change(function () {
        hideShow('genre');
        $('input[name=genre_edit]').val($('#genre_select option:selected').text());
        $('input[name=genre_id_edit]').val($('#genre_select option:selected').val());
    });

    $('select[name=port_select]').change(function () {
        hideShow('port');
        $('input[name=port_edit]').val($('#port_select option:selected').text());
        $('input[name=port_id_edit]').val($('#port_select option:selected').val());
    });

    $('select[name=individual_role_select]').change(function () {
        hideShow('individual_role');
        $('input[name=individual_role_edit]').val($('#individual_role_select option:selected').text());
        $('input[name=individual_role_id_edit]').val($('#individual_role_select option:selected').val());
    });

    $('select[name=developer_role_select]').change(function () {
        hideShow('developer_role');
        $('input[name=developer_role_edit]').val($('#developer_role_select option:selected').text());
        $('input[name=developer_role_id_edit]').val($('#developer_role_select option:selected').val());
    });
});

function hideShow (type) {
    var select = '#' + type + '_select';
    var edit = '#' + type + '_edit';
    var mod = '#' + type + '_mod';
    var del = '#' + type + '_del';

    if ($(select).val() === '') {
        $(edit).hide();
        $(mod).hide();
        $(del).hide();
    } else {
        $(edit).show();
        $(mod).show();
        $(del).show();
    }
}

window.DeleteEngine = function () {
    var id = document.getElementById('engine_id_edit').value;
    location.href = '../games/db_games_config.php?action=delete_engine&engine_id=' + id;
}

window.ModifyEngine = function () {
    var id = document.getElementById('engine_id_edit').value;
    var name = document.getElementById('engine_edit').value;
    location.href = '../games/db_games_config.php?action=modify_engine&engine_id=' + id + '&engine_name=' + name;
}

window.DeleteProgrammingLanguage = function () {
    var id = document.getElementById('programming_language_id_edit').value;
    location.href = '../games/db_games_config.php?action=delete_programming_language&programming_language_id=' + id;
}

window.ModifyProgrammingLanguage = function () {
    var id = document.getElementById('programming_language_id_edit').value;
    var name = document.getElementById('programming_language_edit').value;
    location.href = '../games/db_games_config.php?action=modify_programming_language&programming_language_id=' + id + '&programming_language_name=' + name;
}

window.DeleteGenre = function () {
    var id = document.getElementById('genre_id_edit').value;
    location.href = '../games/db_games_config.php?action=delete_genre&genre_id=' + id;
}

window.ModifyGenre = function () {
    var id = document.getElementById('genre_id_edit').value;
    var name = document.getElementById('genre_edit').value;
    location.href = '../games/db_games_config.php?action=modify_genre&genre_id=' + id + '&genre_name=' + name;
}

window.DeletePort = function () {
    var id = document.getElementById('port_id_edit').value;
    location.href = '../games/db_games_config.php?action=delete_port&port_id=' + id;
}

window.ModifyPort = function () {
    var id = document.getElementById('port_id_edit').value;
    var name = document.getElementById('port_edit').value;
    location.href = '../games/db_games_config.php?action=modify_port&port_id=' + id + '&port_name=' + name;
}

window.DeleteIndividualRole = function () {
    var id = document.getElementById('individual_role_id_edit').value;
    location.href = '../games/db_games_config.php?action=delete_individual_role&individual_role_id=' + id;
}

window.ModifyIndividualRole = function () {
    var id = document.getElementById('individual_role_id_edit').value;
    var name = document.getElementById('individual_role_edit').value;
    location.href = '../games/db_games_config.php?action=modify_individual_role&individual_role_id=' + id + '&individual_role_name=' + name;
}

window.DeleteDeveloperRole = function () {
    var id = document.getElementById('developer_role_id_edit').value;
    location.href = '../games/db_games_config.php?action=delete_developer_role&developer_role_id=' + id;
}

window.ModifyDeveloperRole = function () {
    var id = document.getElementById('developer_role_id_edit').value;
    var name = document.getElementById('developer_role_edit').value;
    location.href = '../games/db_games_config.php?action=modify_developer_role&developer_role_id=' + id + '&developer_role_name=' + name;
}

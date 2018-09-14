/*!
 * game_config.js
 */
$(document).ready(function () {
    $('.tabs').tabs();
    $('select[name=engine_select]').change(function () {
        if ($('#engine_select').val() === '') {
            $('#engine_edit').hide();
            $('#engine_mod').hide();
            $('#engine_del').hide();
        } else {
            $('#engine_edit').show();
            $('#engine_mod').show();
            $('#engine_del').show();
        }
        $('input[name=engine_edit]').val($('#engine_select option:selected').text());
        $('input[name=engine_id_edit]').val($('#engine_select option:selected').val());
    });

    $('select[name=programming_language_select]').change(function () {
        if ($('#programming_language_select').val() === '') {
            $('#programming_language_edit').hide();
            $('#programming_language_mod').hide();
            $('#programming_language_del').hide();
        } else {
            $('#programming_language_edit').show();
            $('#programming_language_mod').show();
            $('#programming_language_del').show();
        }
        $('input[name=programming_language_edit]').val($('#programming_language_select option:selected').text());
        $('input[name=programming_language_id_edit]').val($('#programming_language_select option:selected').val());
    });

    $('select[name=genre_select]').change(function () {
        if ($('#genre_select').val() === '') {
            $('#genre_edit').hide();
            $('#genre_mod').hide();
            $('#genre_del').hide();
        } else {
            $('#genre_edit').show();
            $('#genre_mod').show();
            $('#genre_del').show();
        }
        $('input[name=genre_edit]').val($('#genre_select option:selected').text());
        $('input[name=genre_id_edit]').val($('#genre_select option:selected').val());
    });

    $('select[name=port_select]').change(function () {
        if ($('#port_select').val() === '') {
            $('#port_edit').hide();
            $('#port_mod').hide();
            $('#port_del').hide();
        } else {
            $('#port_edit').show();
            $('#port_mod').show();
            $('#port_del').show();
        }
        $('input[name=port_edit]').val($('#port_select option:selected').text());
        $('input[name=port_id_edit]').val($('#port_select option:selected').val());
    });

    $('select[name=individual_role_select]').change(function () {
        if ($('#individual_role_select').val() === '') {
            $('#individual_role_edit').hide();
            $('#individual_role_mod').hide();
            $('#individual_role_del').hide();
        } else {
            $('#individual_role_edit').show();
            $('#individual_role_mod').show();
            $('#individual_role_del').show();
        }
        $('input[name=individual_role_edit]').val($('#individual_role_select option:selected').text());
        $('input[name=individual_role_id_edit]').val($('#individual_role_select option:selected').val());
    });

    $('select[name=developer_role_select]').change(function () {
        if ($('#developer_role_select').val() === '') {
            $('#developer_role_edit').hide();
            $('#developer_role_mod').hide();
            $('#developer_role_del').hide();
        } else {
            $('#developer_role_edit').show();
            $('#developer_role_mod').show();
            $('#developer_role_del').show();
        }
        $('input[name=developer_role_edit]').val($('#developer_role_select option:selected').text());
        $('input[name=developer_role_id_edit]').val($('#developer_role_select option:selected').val());
    });

    $('select[name=language_select]').change(function () {
        if ($('#language_select').val() === '') {
            $('#language_edit').hide();
            $('#language_mod').hide();
            $('#language_del').hide();
        } else {
            $('#language_edit').show();
            $('#language_mod').show();
            $('#language_del').show();
        }
        $('input[name=language_edit]').val($('#language_select option:selected').text());
        $('input[name=language_id_edit]').val($('#language_select option:selected').val());
    });
});

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

window.DeleteLanguage = function () {
    var id = document.getElementById('language_id_edit').value;
    location.href = '../games/db_games_config.php?action=delete_language&language_id=' + id;
}

window.ModifyLanguage = function () {
    var id = document.getElementById('language_id_edit').value;
    var name = document.getElementById('language_edit').value;
    location.href = '../games/db_games_config.php?action=modify_language&language_id=' + id + '&language_name=' + name;
}

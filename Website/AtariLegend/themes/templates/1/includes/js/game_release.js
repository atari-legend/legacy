/*!
 * game_release.js
 */
$(document).ready(function () {
    $('select[name=pub_dev_id]').altAutocomplete();
    $('select[name=distributor_id]').altAutocomplete();
    $('select[name=crew_id]').altAutocomplete();
});

window.add_scan_desc = function (field) {
    var input;
    var button;

    input = 'file_upload_game_scan' + field;
    button = 'file_upload2' + field;
    document.getElementById(input).value = $('input:file[id=' + button + ']').val();
}

window.add_file_desc = function (field) {
    var input;
    var button;

    input = 'file_upload_game_detail' + field;
    button = 'file_upload' + field;
    document.getElementById(input).value = $('input:file[id=' + button + ']').val();
}

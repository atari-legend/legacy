/*!
 * game_release.js
 */
$(document).ready(function () {
    $('select[name=pub_dev_id]').altAutocomplete();
    $('select[name=distributor_id]').altAutocomplete();
    $('.tabs').tabs();
});

$(function () {
    $('input:file[id=file_upload]').change(function () {
        document.getElementById('file_upload_game_detail').value = $(this).val();
    });
});

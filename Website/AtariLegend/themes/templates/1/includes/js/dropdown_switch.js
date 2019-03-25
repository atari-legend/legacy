/*!
 * dropdown_switch.js
 */

/* script needed for the autocompletion search engine */
$(document).ready(function () {
    $('.autocompleted').each(function () {
        var extraParam = $(this).attr('data-autocomplete-param');
        $(this).autocomplete({
            source: '../../../php/includes/autocomplete.php?extraParams=' + extraParam,
            minLength: 2
        });
    });
});

/* Switch from input to dropdown */
window.dropdown = function (input, dropdown, inputText, dropdownText) {
    var JSinput = document.getElementById(input);
    JSinput.style.display = 'none';

    var JSdropdown = document.getElementById(dropdown);
    JSdropdown.style.display = 'inline';

    var JSinputText = document.getElementById(inputText);
    JSinputText.style.display = 'none';

    var JSdropdownText = document.getElementById(dropdownText);
    JSdropdownText.style.display = 'inline';
}

window.input = function (input, dropdown, inputText, dropdownText) {
    var JSinput = document.getElementById(input);
    JSinput.style.display = 'inline';

    var JSdropdown = document.getElementById(dropdown);
    JSdropdown.style.display = 'none';

    var JSinputText = document.getElementById(inputText);
    JSinputText.style.display = 'inline';

    var JSdropdownText = document.getElementById(dropdownText);
    JSdropdownText.style.display = 'none';
}

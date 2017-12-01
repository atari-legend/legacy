(function ($) {
    /**
     * jQuery plugin to provide an alternative auto-completed input
     * field to an existing select dropdown */
    $.fn.altAutocomplete = function () {
        this.each(function () {
            // Get all attributes on our <select> tag
            var selectElement = $(this),
                selectName = selectElement.attr('name'),
                // Currently selected label and value
                selectedLabel = selectElement.find(':selected').text(),
                // Various attribute we need to perform the auto-complete:
                // - the Ajax endpoint
                completeEndpoint = selectElement.data('alt-autocomplete-endpoint'),
                // - Which element is used to toggle between select / input mode
                toggleControl = selectElement.data('alt-autocomplete-toggle'),
                // Generate an ID for the auto-completed input based on the select name
                displaySelectId = selectName + '-autocomplete-display';

            // Some select are initialized with '-'. We don't want to display
            // this in input mode, so clear it
            if (selectedLabel === '-') {
                selectedLabel = '';
            }

            // Setup the autocomplete input field
            var autocompleteDisplayInput = $('<input type="text" class="ui-widget-inline standard_tile_input_small" id="' + displaySelectId + '" value="' + selectedLabel + '">');
            autocompleteDisplayInput
                .autocomplete({
                    source: completeEndpoint,
                    minLength: 2,
                    select: function (evt, ui) {
                        // Synchronize the <input> value with the <select> one

                        // When a selection is chosen, update the input
                        // with the label, and select the correct <option>
                        // within the <select>
                        $(this).val(ui.item.label);
                        selectElement.val(ui.item.value).trigger('change');
                        return false;
                    }
                })
                .insertAfter(selectElement);

            // Synchronize the <select> value with the <input> one
            selectElement.change(function () {
                // If the <select> changes, update the autocomplete input value
                // with label of the currently selected value
                autocompleteDisplayInput.val($(this).find('option:selected').text());
            });

            // Setup the toggle button
            $(toggleControl).click(function () {
                // When the toggle is clicked, show/hide the
                // <select> and autocompleted <input>
                // toggleClass() will set the class if it's not set, or remove it if it's set
                autocompleteDisplayInput.toggleClass('ui-widget-inline').toggleClass('ui-widget-hidden');
                selectElement.toggleClass('ui-widget-inline').toggleClass('ui-widget-hidden');

                // Update the 'title' of the toggle button to show
                // the right one depending on what's currently displayed
                if (autocompleteDisplayInput.is(':visible')) {
                    $(this).attr('title', 'Click for dropdown mode');
                } else {
                    $(this).attr('title', 'Click for autocompleted input field mode');
                }
            });

            // Everything is ready, now hide our <select> by default
            selectElement.toggleClass('ui-widget-hidden');
        });
    };
}(jQuery));

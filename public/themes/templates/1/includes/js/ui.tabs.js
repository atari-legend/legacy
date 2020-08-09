(function ($) {
    /**
     * jQuery plugin to manage simple tabs */
    $.fn.tabs = function () {
        this.each(function () {
            // Get the root of our tabs
            var tabRoot = $(this),
                // Get all our tab buttons
                allTabButtons = tabRoot.find('li'),
                // Get all the ID of the content panes
                allTabsIds = allTabButtons.map(function () {
                    return $(this).find('a').attr('href');
                });

            // Whenever a tab is clicked...
            allTabButtons.click(function () {
                // Remove the active class from all buttons
                allTabButtons.removeClass('active');
                // ...and set the one that was clicked on active
                $(this).addClass('active');

                // Then remove the active class from all content panes
                $.each(allTabsIds, function (i, id) {
                    $(id).removeClass('active');
                });
                // Find out the target content pane, and mark it active
                var targetTabId = $(this).find('a').attr('href');
                $(targetTabId).addClass('active');

                // Prevent the click event on the anchor to be processed
                return false;
            });
        });
    }
}(jQuery));

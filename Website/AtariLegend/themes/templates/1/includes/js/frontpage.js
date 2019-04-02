/*!
 * frontpage.js
 * http://www.atarilegend.com
 *
 */

// The intro move up script
window.initFadeUp = function () {
    $('.animsition').animsition({
        inClass: 'fade-in-up',
        outClass: 'fade-out-up',
        inDuration: 1500,
        outDuration: 800,
        linkElement: '.animsition-link',
        // e.g. linkElement: 'a:not([target="_blank"]):not([href^="#"])'
        loading: true,
        loadingParentElement: 'body', // animsition wrapper element
        loadingClass: 'animsition-loading',
        loadingInner: '', // e.g '<img src="loading.svg" />'
        timeout: false,
        timeoutCountdown: 5000,
        onLoadEvent: true,
        browser: [ 'animation-duration', '-webkit-animation-duration' ],
        // "browser" option allows you to disable the "animsition" in case the css property in the array is not supported by your browser.
        // The default setting is to disable the "animsition" in a browser that does not support "animation-duration".
        overlay: false,
        overlayClass: 'animsition-overlay-slide',
        overlayParentElement: 'body',
        transition: function (url) { window.location.href = url; }
    });
}

// This script is needed for the animation in the welcome tile -->
jQuery(document).ready(function ($) {
    var _SlideshowTransitions = [
    // Fade
        { $Duration: 3000, $Opacity: 2 }
    ];

    var options = {
        $AutoPlay: true,
        // [Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
        $AutoPlaySteps: 1,
        // [Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
        $AutoPlayInterval: 5000,
        // [Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
        $PauseOnHover: 1,
        // [Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1
        $ArrowKeyNavigation: true,
        // [Optional] Allows keyboard (arrow key) navigation or not, default value is false
        $SlideDuration: 500,
        // [Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
        $MinDragOffsetToSlide: 20,
        // [Optional] Minimum drag offset to trigger slide , default value is 20
        $SlideSpacing: 0,
        // [Optional] Space between each slide in pixels, default value is 0
        $DisplayPieces: 1,
        // [Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
        $ParkingPosition: 0,
        // [Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
        $UISearchMode: 1,
        // [Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
        $PlayOrientation: 1,
        // [Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
        $DragOrientation: 3,
        // [Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)
        $SlideshowOptions: {
        // [Optional] Options to specify and enable slideshow or not
            $Class: $JssorSlideshowRunner$,
            // [Required] Class to create instance of slideshow
            $Transitions: _SlideshowTransitions,
            // [Required] An array of slideshow transitions to play slideshow
            $TransitionsOrder: 1,
            // [Optional] The way to choose transition to play slide, 1 Sequence, 0 Random
            $ShowLink: true
            // [Optional] Whether to bring slide link on top of the slider when slideshow is running, default value is false
        },

        $BulletNavigatorOptions: {
        // [Optional] Options to specify and enable navigator or not
            $Class: $JssorBulletNavigator$,
            // [Required] Class to create navigator instance
            $ChanceToShow: 2,
            // [Required] 0 Never, 1 Mouse Over, 2 Always
            $AutoCenter: 1,
            // [Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
            $Steps: 1,
            // [Optional] Steps to go for each navigation request, default value is 1
            $Lanes: 1,
            // [Optional] Specify lanes to arrange items, default value is 1
            $SpacingX: 10,
            // [Optional] Horizontal space between each item in pixel, default value is 0
            $SpacingY: 10,
            // [Optional] Vertical space between each item in pixel, default value is 0
            $Orientation: 1
            // [Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
        },

        $ArrowNavigatorOptions: {
            $Class: $JssorArrowNavigator$,
            // [Requried] Class to create arrow navigator instance
            $ChanceToShow: 2,
            // [Required] 0 Never, 1 Mouse Over, 2 Always
            $Steps: 1
            // [Optional] Steps to go for each navigation request, default value is 1
        }
    };

    var jssorSlider1 = new $JssorSlider$('welcome', options);

    // responsive code begin
    // you can remove responsive code if you don't want the slider scales while window resizes
    window.ScaleSlider = function () {
        var paddingWidth;
        if ($(window).width() < 1495) {
            paddingWidth = -20;
        } else {
            // reserve blank width for margin+padding: margin+padding-left (10) + margin+padding-right (10)
            paddingWidth = -0;
        }

        // minimum width should reserve for text
        var minReserveWidth = 300;

        var parentElement = jssorSlider1.$Elmt.parentNode;

        // evaluate parent container width
        var parentWidth = parentElement.clientWidth;

        if (parentWidth) {
            // exclude blank width
            var availableWidth = parentWidth - paddingWidth;

            // calculate slider width as 70% of available width
            var sliderWidth = availableWidth * 0.7;

            // slider width is maximum 600
            sliderWidth = Math.min(sliderWidth, 845);

            // slider width is minimum 200
            sliderWidth = Math.max(sliderWidth, 200);
            var clearFix = 'none';

            // evaluate free width for text, if the width is less than minReserveWidth then fill parent container
            if (availableWidth - sliderWidth < minReserveWidth) {
                // set slider width to available width
                sliderWidth = availableWidth;

                // slider width is minimum 200
                sliderWidth = Math.max(sliderWidth, 200);

                clearFix = 'both';
            }

            // clear fix for safari 3.1, chrome 3
            $('#clearFixDiv').css('clear', clearFix);

            jssorSlider1.$ScaleWidth(sliderWidth);
        } else {
            window.setTimeout(ScaleSlider, 30);
        }
    }
    ScaleSlider();

    $(window).bind('load', ScaleSlider);
    $(window).bind('resize', ScaleSlider);
    $(window).bind('orientationchange', ScaleSlider);
    // responsive code end
});   

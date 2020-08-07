/*!
 * game.js
 */

// script used for the jquery screenshot and boxscan slider
window.initJSsor = function (nbScreenshots, nbBoxscans, nbReleasScans) {
    var vRows = 2, vAlign = 171;

    if (nbScreenshots < 10) {
        vRows = 1;
        vAlign = 209
    }

    // screenshot slider code
    var jssor1SlideshowTransitions = [
        { $Duration: 1200, $Opacity: 2 }
    ];

    var jssor1Options = {
        $AutoPlay: 1,
        $SlideshowOptions: {
            $Class: $JssorSlideshowRunner$,
            $Transitions: jssor1SlideshowTransitions,
            $TransitionsOrder: 1
        },
        $ArrowNavigatorOptions: {
            $Class: $JssorArrowNavigator$
        },
        $BulletNavigatorOptions: {
            $Class: $JssorBulletNavigator$
        },
        $ThumbnailNavigatorOptions: {
            $Class: $JssorThumbnailNavigator$,
            $Rows: vRows,
            $Align: vAlign,
            $SpacingX: 5,
            $SpacingY: 5,
            $Orientation: 2
        }
    };

    if (nbScreenshots > 0) {
        var jssor1Slider = new $JssorSlider$('jssor_1', jssor1Options);
    }

    if (nbBoxscans > 0 || nbReleasScans > 0) {
        // boxscan slider code
        var jssor2Options = {
            $AutoPlay: 1,
            $FillMode: 5,
            $SlideshowOptions: {
                $Class: $JssorSlideshowRunner$,
                $Transitions: jssor1SlideshowTransitions,
                $TransitionsOrder: 1
            },
            $ArrowNavigatorOptions: {
                $Class: $JssorArrowNavigator$
            },
            $ThumbnailNavigatorOptions: {
                $Class: $JssorThumbnailNavigator$,
                $Cols: 4,
                $Align: 400
            }
        };

        var jssor2Slider = new $JssorSlider$('jssor_2', jssor2Options);
    }

    // region responsive code begin
    window.ScaleSlider = function () {
        if (nbScreenshots > 0) {
            // for screenshots
            var containerElement = jssor1Slider.$Elmt.parentNode;
            var containerWidth = containerElement.clientWidth;
            if (containerWidth) {
                var MAX_WIDTH = 960;

                var expectedWidth = containerWidth;

                if (MAX_WIDTH) {
                    expectedWidth = Math.min(MAX_WIDTH, expectedWidth);
                }

                jssor1Slider.$ScaleWidth(expectedWidth);
            } else {
                window.setTimeout(window.ScaleSlider, 30);
            }
        }

        if (nbBoxscans > 0 || nbReleasScans > 0) {
        // for boxscans
            var containerElement2 = jssor2Slider.$Elmt.parentNode;
            var containerWidth2 = containerElement2.clientWidth;
            if (containerWidth2) {
                var MAX_WIDTH2 = 480;
                var expectedWidth2 = containerWidth2;

                if (MAX_WIDTH2) {
                    expectedWidth2 = Math.min(MAX_WIDTH2, expectedWidth2);
                }

                jssor2Slider.$ScaleWidth(expectedWidth2);
            } else {
                window.setTimeout(window.ScaleSlider, 30);
            }
        }
    }

    window.ScaleSlider();
    $(window).bind('load', window.ScaleSlider);
    $(window).bind('resize', window.ScaleSlider);
    $(window).bind('orientationchange', window.ScaleSlider);
    // endregion responsive code end

    // API $Play, $Pause
    window.Play = function () {
        jssor1Slider.$Play();
    }

    window.Pause = function () {
        jssor1Slider.$Pause();
    }

    $('#play_jssor1').click(window.Play);
    $('#pause_jssor1').click(window.Pause);

    if (nbBoxscans > 0 || nbReleasScans > 0) {
        window.Play_box = function () {
            jssor2Slider.$Play();
        }

        window.Pause_box = function () {
            jssor2Slider.$Pause();
        }

        $('#play_jssor2').click(window.Play_box);
        $('#pause_jssor2').click(window.Pause_box);
    }
}

// This is the script to truncate the preview of the reviews-->
jQuery(document).ready(function () {
    $('.game_details_review_preview_text').dotdotdot({
        //  configuration goes here

        /*  The text to add as ellipsis. */
        ellipsis: '... ',

        /*  How to cut off the text/html: 'word'/'letter'/'children' */
        wrap: 'word',

        /*  Wrap-option fallback to 'letter' for long words */
        fallbackToLetter: false,

        /*  jQuery-selector for the element to keep and put after the ellipsis. */
        after: null,

        /*  Whether to update the ellipsis: true/'window' */
        watch: window,

        /*  Optionally set a max-height, can be a number or function.
            If null, the height will be measured. */
        height: null,

        /*  Deviation for the height-option. */
        tolerance: 0,

        /*  Callback function that is fired after the ellipsis is added,
            receives two parameters: isTruncated(boolean), orgContent(string). */
        callback: function (isTruncated, orgContent) {},

        lastCharacter: {
            /*  Remove these characters from the end of the truncated text. */
            remove: [ ' ', ',', ';', '.', '!', '?' ],

            /*  Don't add an ellipsis if this array contains
                the last character of the truncated text. */
            noEllipsis: []
        }
    });
});

/* This is the game submission file selector code for the large submission tile */
$(function () {
    $('input:file[id=file_upload]').change(function () {
        document.getElementById('file_upload_game_screenshots').value = 'file(s) selected';
    });
});

/* This is the game submission file selector code for the medium submission tile */
$(function () {
    $('input:file[id=file_upload_medium]').change(function () {
        document.getElementById('file_upload_game_screenshots_medium').value = 'file(s) selected';
    });
});

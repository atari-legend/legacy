/*!
 * dotdotdot.js
 * http://www.atarilegend.com
 *
 */
window.initDot = function (field) {
    $(field).dotdotdot({ // This is the script to truncate the preview of the reviews
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
};

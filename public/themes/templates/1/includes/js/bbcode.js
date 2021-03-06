/***************************************************************************
*                                bbcode.js
*                            --------------------------
*   begin                : Thursday, November 2, 2017
*   copyright            : (C) 2017 Atari Legend
*   actual update        : created this file
*
*   Id: forms_al.js, v0.10 2017/11/02 21:39 STG
***************************************************************************

****************************************************************************************
*This file contains JS functions used at AL
****************************************************************************************
*/

/* START all the code for the text functions - BBCODE */
var clientPC = navigator.userAgent.toLowerCase(); // Get client info
var clientVer = parseInt(navigator.appVersion); // Get browser version

var is_ie = ((clientPC.indexOf('msie') != -1) && (clientPC.indexOf('opera') == -1));
var is_nav = ((clientPC.indexOf('mozilla') != -1) && (clientPC.indexOf('spoofer') == -1) &&
                (clientPC.indexOf('compatible') == -1) && (clientPC.indexOf('opera') == -1) &&
                (clientPC.indexOf('webtv') == -1) && (clientPC.indexOf('hotjava') == -1));
var is_moz = 0;

var is_win = ((clientPC.indexOf('win') != -1) || (clientPC.indexOf('16bit') != -1));
var is_mac = (clientPC.indexOf('mac') != -1);

// Define the bbCode tags
bbtags = new Array(
    '[b]', '[/b]', '[i]', '[/i]', '[u]', '[/u]', '[url=http://www.yourlink.com]',
    '[/url]', '[email]', '[/email]', '[hotspotUrl=#]', '[/hotspotUrl]', '[hotspot=]',
    '[/hotspot]', '[frontpage]', '[/frontpage]', '[screenstar]', '[/screenstar]',
    '[game=1234]', '[/game]', '[review=1234]', '[/review]', '[interview=1234]',
    '[/interview]', '[article=1234]', '[/article]', '[developer=1234]', '[/developer]',
    '[releaseYear]', '[/releaseYear]', '[publisher=1234]', '[/publisher]',
    '[individual=1234]', '[/individual]');
bbcode = new Array();
imageTag = false;

function bbstyle (bbnumber, bbname) {
    var txtarea = eval('document.post.' + bbname);

    txtarea.focus();
    donotinsert = false;
    theSelection = false;
    bblast = 0;

    if (bbnumber == -1) { // Close all open tags & default button names
        while (bbcode[0]) {
            butnumber = bbcode.pop() - 1;
            txtarea.value += bbtags[butnumber + 1];
            buttext = eval('document.post.addbbcode' + butnumber + '.value');
            eval('document.post.addbbcode' + butnumber + '.value ="' + buttext.substr(0, (buttext.length - 1)) + '"');
        }
        imageTag = false; // All tags are closed including image tags :D
        txtarea.focus();
        return;
    }

    if ((clientVer >= 4) && is_ie && is_win) {
        theSelection = document.selection.createRange().text; // Get text selection
        if (theSelection) {
            // Add tags around selection
            document.selection.createRange().text = bbtags[bbnumber] + theSelection + bbtags[bbnumber + 1];
            txtarea.focus();
            theSelection = '';
            return;
        }
    } else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0)) {
        mozWrap(txtarea, bbtags[bbnumber], bbtags[bbnumber + 1]);
        return;
    }

    // Find last occurance of an open tag the same as the one just clicked
    for (i = 0; i < bbcode.length; i++) {
        if (bbcode[i] == bbnumber + 1) {
            bblast = i;
            donotinsert = true;
        }
    }

    if (donotinsert) {		// Close all open tags up to the one just clicked & default button names
        while (bbcode[bblast]) {
            butnumber = bbcode.pop() - 1;
            txtarea.value += bbtags[butnumber + 1];
            buttext = eval('document.post.addbbcode' + butnumber + '.value');
            eval('document.post.addbbcode' + butnumber + '.value ="' + buttext.substr(0, (buttext.length - 1)) + '"');
            imageTag = false;
        }
        txtarea.focus();
        return;
    } else { // Open tags
        if (imageTag && (bbnumber != 14)) {		// Close image tag before adding another
            txtarea.value += bbtags[15];
            lastValue = bbcode.pop() - 1;	// Remove the close image tag from the list
            document.post.addbbcode14.value = 'Img';	// Return button back to normal state
            imageTag = false;
        }

        // Open tag
        txtarea.value += bbtags[bbnumber];
        if ((bbnumber == 14) && (imageTag == false)) imageTag = 1; // Check to stop additional tags after an unclosed image tag
        bbcode.push(bbnumber + 1);
        eval('document.post.addbbcode' + bbnumber + '.value += "*"');
        txtarea.focus();
        return;
    }
    storeCaret(txtarea);
}

// From http://www.massless.org/mozedit/
function mozWrap (txtarea, open, close) {
    var selLength = txtarea.textLength;
    var selStart = txtarea.selectionStart;
    var selEnd = txtarea.selectionEnd;
    if (selEnd == 1 || selEnd == 2) { selEnd = selLength; }

    var s1 = (txtarea.value).substring(0, selStart);
    var s2 = (txtarea.value).substring(selStart, selEnd)
    var s3 = (txtarea.value).substring(selEnd, selLength);
    txtarea.value = s1 + open + s2 + close + s3;
}

// Insert at Claret position. Code from
// http://www.faqts.com/knowledge_base/view.phtml/aid/1052/fid/130
function storeCaret (textEl) {
    if (textEl.createTextRange) textEl.caretPos = document.selection.createRange().duplicate();
}

// This function is used for the 'on the fly' previews of interviews and reviews
function previewText (text) {
    frontBaseUrl = window.AL_FRONT_URL || '';
    text = text.replace(/</g, '&lt;').replace(/>/g, '&gt;');
    text = text.replace(/\n\r?/g, '<br />');
    text = text.replaceAll('[b]', '<b>');
    text = text.replaceAll('[/b]', '</b>');
    text = text.replaceAll('[u]', '<u>');
    text = text.replaceAll('[/u]', '</u>');
    text = text.replaceAll('[i]', '<i>');
    text = text.replaceAll('[/i]', '</i>');
    text = text.replaceAll('[url=', '<a href=');
    text = text.replaceAll('[/url]', '</a>');
    text = text.replaceAll('[email=', '<a href=mailto:');
    text = text.replaceAll('[/email]', '</a>');
    text = text.replaceAll('[screenstar]', '');
    text = text.replaceAll('[/screenstar]', '');
    text = text.replaceAll('[frontpage]', '');
    text = text.replaceAll('[/frontpage]', '');
    for (i = 0; i < 60; i++) {
        var hotspotUrl = '[hotspotUrl=#';
        var hotspotUrl_output = hotspotUrl.concat(i);
        var hotspotUrl_final = hotspotUrl_output.concat(']');
        var nameUrl = '<a href=#';
        var nameUrl_output = nameUrl.concat(i);
        var nameUrl_final = nameUrl_output.concat(' class=standard_tile_link_black>');
        text = text.replaceAll(hotspotUrl_final, nameUrl_final);
        var hotspot = '[hotspot=';
        var hotspot_output = hotspot.concat(i);
        var hotspot_final = hotspot_output.concat(']');
        var name = '<a name=';
        var name_output = name.concat(i);
        var name_final = name_output.concat('>');
        text = text.replaceAll(hotspot_final, name_final);
    }
    text = text.replaceAll('[/hotspotUrl]', '</a>');
    text = text.replaceAll('[/hotspot]', '</a>');

    text = text.replace(/\[game=([0-9]+)\]/ig, '<a href="'+frontBaseUrl+'/games/$1">');
    text = text.replace(/\[\/game\]/ig, '</a>');

    text = text.replace(/\[review=([0-9]+)\]/ig, '<a href="'+frontBaseUrl+'/reviews/$1">');
    text = text.replace(/\[\/review\]/ig, '</a>');

    text = text.replace(/\[interview=([0-9]+)\]/ig, '<a href="'+frontBaseUrl+'/interviews/$1">');
    text = text.replace(/\[\/interview\]/ig, '</a>');

    text = text.replace(/\[article=([0-9]+)\]/ig, '<a href="'+frontBaseUrl+'/articles/$1">');
    text = text.replace(/\[\/article\]/ig, '</a>');

    text = text.replace(/\[developer=([0-9]+)\]/ig, '<a href="'+frontBaseUrl+'/games/search?developer_id=$1">');
    text = text.replace(/\[\/developer\]/ig, '</a>');

    text = text.replace(/\[publisher=([0-9]+)\]/ig, '<a href="'+frontBaseUrl+'/games/search?publisher_id=$1">');
    text = text.replace(/\[\/publisher\]/ig, '</a>');

    text = text.replace(/\[individual=([0-9]+)\]/ig, '<a href="'+frontBaseUrl+'/games/search?individual_id=$1">');
    text = text.replace(/\[\/individual\]/ig, '</a>');

    text = text.replace(/\[releaseYear\]([0-9]+)/ig, '<a href="'+frontBaseUrl+'/games/search?year_id=$1">$1');
    text = text.replace(/\[\/releaseYear\]/ig, '</a>');

    text = text.replaceAll(']', ' class=standard_tile_link_black>');
    return text;
}

String.prototype.replaceAll = function (str1, str2, ignore) {
    return this.replace(new RegExp(str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g, '\\$&'), (ignore ? 'gi' : 'g')), (typeof (str2) === 'string') ? str2.replace(/\$/g, '$$$$') : str2);
}
/* END all the code for the text functions - BBCODE */

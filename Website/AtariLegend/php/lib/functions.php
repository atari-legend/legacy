<?php
/***************************************************************************
 *                                functions.php
 *                            --------------------------
 *   begin                : Monday, 26 January, 2004
 *   copyright            : (C) 2003 Atari Legend
 *   email                : maarten.martens@freebel.net
 *   actual update        :
 *
 *   Id: functions.php,v 0.10 2004/01/26 00:55 silver
 *   Id: functions.php,v 0.20 2016/08/17 STG - Added change log function
 *
 ***************************************************************************/

const MIME_TYPES_TO_EXT = array(
    "image/jpeg" => "jpg",
    "image/png" => "png",
    "image/x-png" => "png"
);

function InsertALCode($alcode) {
    $alcode = preg_replace(
        "#\[color\=(\#[0-9A-F]{0,6}|[A-z]+)\](.*)\[\/color\]#Ui",
        "<span style=\"color: $1;\">$2</span>", $alcode
    );
    //$alcode = eregi_replace("\\[style=([^\\[]*)\\]","<span class=\"\\1\">",$alcode);
    //$alcode = str_replace("[/style]", "</span>", $alcode);
    $alcode = preg_replace("(\[size=(.+?)\](.+?)\[\/size\])is", "<span style=\"font-size: $1px\">$2</span>", $alcode);
    $alcode = preg_replace("#\[font\=(.*)\](.*)\[\/font\]#Ui", "<span style=\"font-family: $1;\">$2</span>", $alcode);
    $alcode = preg_replace("#\[align\=(.*)\](.*)\[\/align\]#Ui", "<span style=\" $1;\">$2</span>", $alcode);
    $alcode = str_replace("[move]", "<marquee>", $alcode);
    $alcode = str_replace("[/move]", "</marquee>", $alcode);
    $alcode = str_replace("[hr]", "<hr>", $alcode);
    $alcode = str_replace("[img]", "<img src=\"", $alcode);
    $alcode = str_replace("[/img]", "\" alt=''>", $alcode);
    $alcode = str_replace("[sub]", "<sub>", $alcode);
    $alcode = str_replace("[/sub]", "</sub>", $alcode);
    $alcode = str_replace("[tt]", "<tt>", $alcode);
    $alcode = str_replace("[/tt]", "</tt>", $alcode);
    $alcode = str_replace("[sup]", "<sup>", $alcode);
    $alcode = str_replace("[/sup]", "</sup>", $alcode);
    $alcode = str_replace("[screenstar]", "", $alcode);
    $alcode = str_replace("[/screenstar]", "", $alcode);
    $alcode = str_replace("[frontpage]", "", $alcode);
    $alcode = str_replace("[/frontpage]", "", $alcode);
    $alcode = preg_replace("#\[b\](.+?)\[/b\]#is", "<b>\\1</b>", $alcode);
    $alcode = preg_replace("#\[i\](.+?)\[/i\]#is", "<i>\\1</i>", $alcode);
    $alcode = preg_replace("#\[u\](.+?)\[/u\]#is", "<u>\\1</u>", $alcode);
    $alcode = preg_replace("#\[s\](.+?)\[/s\]#is", "<s>\\1</s>", $alcode);
    $alcode = str_replace("[*]", "<li>", $alcode);
    $alcode = str_replace("[list]", "<ul>", $alcode);
    $alcode = str_replace("[/list]", "</ul>", $alcode);
    $alcode = preg_replace("#\[email\=(.*)\](.*)\[\/email\]#Ui", "<a href=\"mailto: $1\">$2</a>", $alcode);
    $alcode = preg_replace("#\[email\](.*)\[\/email\]#Ui", "<a href=\"mailto: $1\">$1</a>", $alcode);
    $alcode = preg_replace("#\[hotspot\=(.*)\](.*)\[\/hotspot\]#Ui", "<a name=\"$1\">$2</a>", $alcode);
    $alcode = str_replace("[quote]", "<blockquote><span class=\"12px\">quote:</span><hr>", $alcode);
    $alcode = str_replace("[/quote]", "<hr></blockquote>", $alcode);
    $alcode = str_replace("[code]", "<blockquote><pre>", $alcode);
    $alcode = str_replace("[/code]", "</pre></blockquote>", $alcode);
    $alcode = preg_replace("#\[url\](www\..+)\[\/url\]#i", "[url=http://$1]$1[/url]", $alcode);
    $alcode = preg_replace("#\[url\=(www\..+)\](.*)\[\/url\]#i", "[url=http://$1]$2[/url]", $alcode);
    $alcode = preg_replace(
        "#\[url\=(.*)\](.*)\[\/url\]#Ui", "<a href=\"$1\" class=\"standard_tile_link_black\">$2</a>",
        $alcode
    );
    $alcode = preg_replace(
        "#\[url\](.*)\[\/url\]#Ui",
        "<a href=\"$1\" class=\"standard_tile_link_black\">$1</a>",
        $alcode
    );
    $alcode = preg_replace(
        "#\[hotspotUrl\=(.*)\](.*)\[\/hotspotUrl\]#Ui",
        "<a href=\"$1\" class=\"standard_tile_link_black\">$2</a>",
        $alcode
    );
    $alcode = preg_replace(
        "#(^|[\n ])([\w]+?://.*?[^ \"\n\r\t<]*)#is",
        "\\1<a href=\"\\2\" target=\"_blank\" class=\"standard_tile_link_black\">\\2</a>",
        $alcode
    );
    $alcode = preg_replace(
        "#(^|[\n ])((www|ftp)\.[\w\-]+\.[\w\-.\~]+(?:/[^ \"\t\n\r<]*)?)#is",
        "\\1<a href=\"http://\\2\" target=\"_blank\" class=\"standard_tile_link_black\">\\2</a>",
        $alcode
    );

    return $alcode;
}

function BBCode($Text) {
    // Replace any html brackets with HTML Entities to prevent executing HTML or script
    // Don't use strip_tags here because it breaks [url] search by replacing & with amp
    $Text = str_replace("<", "&lt", $Text);
    $Text = str_replace(">", "&gt", $Text);

    // Set up the parameters for a URL search string
    $URLSearchString  = " a-zA-Z0-9\:\/\-\?\&\.\=\_\~\#\'";
    // Set up the parameters for a MAIL search string
    $MAILSearchString = $URLSearchString . " a-zA-Z0-9\.@";

    // Perform URL Search
    $Text = preg_replace(
        "/\[url\]([$URLSearchString]*)\[\/url\]/",
        '<a href="$1" target="_blank" class="standard_tile_link_black">$1</a>',
        $Text
    );
    $Text = preg_replace(
        "(\[url\=([$URLSearchString]*)\](.+?)\[/url\])",
        '<a href="$1" target="_blank" class="standard_tile_link_black">$2</a>',
        $Text
    );

    // Perform MAIL Search
    $Text = preg_replace("(\[mail\]([$MAILSearchString]*)\[/mail\])", '<a href="mailto:$1">$1</a>', $Text);
    $Text = preg_replace("/\[mail\=([$MAILSearchString]*)\](.+?)\[\/mail\]/", '<a href="mailto:$1">$2</a>', $Text);

    // Check for bold text
    $Text = preg_replace("(\[b\](.+?)\[\/b])is", '<span style="font-weight:bold;">$1</span>', $Text);

    // Check for Italics text
    $Text = preg_replace("(\[i\](.+?)\[\/i\])is", '<span style="font-style: italic;">$1</span>', $Text);

    // Check for Underline text
    $Text = preg_replace("(\[u\](.+?)\[\/u\])is", '<span style="text-decoration: underline;">$1</span>', $Text);

    // Check for strike-through text
    $Text = preg_replace("(\[s\](.+?)\[\/s\])is", '<span class="strikethrough">$1</span>', $Text);

    // Check for over-line text
    $Text = preg_replace("(\[o\](.+?)\[\/o\])is", '<span class="overline">$1</span>', $Text);

    // Check for colored text
    $Text = preg_replace("(\[color=(.+?)\](.+?)\[\/color\])is", "<span style=\"color: $1\">$2</span>", $Text);

    // Check for sized text
    $Text = preg_replace("(\[size=(.+?)\](.+?)\[\/size\])is", "<span style=\"font-size: $1px\">$2</span>", $Text);

    // Check for list text
    $Text = preg_replace("/\[list\](.+?)\[\/list\]/is", '<ul class="listbullet">$1</ul>', $Text);
    $Text = preg_replace("/\[list=1\](.+?)\[\/list\]/is", '<ul class="listdecimal">$1</ul>', $Text);
    $Text = preg_replace("/\[list=i\](.+?)\[\/list\]/s", '<ul class="listlowerroman">$1</ul>', $Text);
    $Text = preg_replace("/\[list=I\](.+?)\[\/list\]/s", '<ul class="listupperroman">$1</ul>', $Text);
    $Text = preg_replace("/\[list=a\](.+?)\[\/list\]/s", '<ul class="listloweralpha">$1</ul>', $Text);
    $Text = preg_replace("/\[list=A\](.+?)\[\/list\]/s", '<ul class="listupperalpha">$1</ul>', $Text);
    $Text = str_replace("[*]", "<li>", $Text);

    // Check for font change text
    $Text = preg_replace("(\[font=(.+?)\](.+?)\[\/font\])", "<span style=\"font-family: $1;\">$2</span>", $Text);

    // Declare the format for [code] layout
    $CodeLayout = '<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="quotecodeheader"> Code:</td>
                        </tr>
                        <tr>
                            <td class="codebody">$1</td>
                        </tr>
                   </table>';
    // Check for [code] text
    $Text       = preg_replace("/\[code\](.+?)\[\/code\]/is", "$CodeLayout", $Text);

    // Declare the format for [quote] layout
    $QuoteLayout = '<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="quotecodeheader"> Quote:</td>
                        </tr>
                        <tr>
                            <td class="quotebody">$1</td>
                        </tr>
                   </table>';

    // Check for [code] text
    $Text = preg_replace("/\[quote\](.+?)\[\/quote\]/is", "$QuoteLayout", $Text);

    // Images
    // [img]pathtoimage[/img]
    $Text = preg_replace("/\[img\](.+?)\[\/img\]/", '<img src="$1">', $Text);

    // [img=widthxheight]image source[/img]
    $Text = preg_replace("/\[img\=([0-9]*)x([0-9]*)\](.+?)\[\/img\]/", '<img src="$3" height="$2" width="$1">', $Text);

    // urls without using the url tag
    $Text = preg_replace(
        "#(^|[\n ])([\w]+?://.*?[^ \"\n\r\t<]*)#is",
        "\\1<a href=\"\\2\" target=\"_blank\" class=\"standard_tile_link\">\\2</a>",
        $Text
    );

    $Text = preg_replace(
        "#(^|[\n ])((www|ftp)\.[\w\-]+\.[\w\-.\~]+(?:/[^ \"\t\n\r<]*)?)#is",
        "\\1<a href=\"http://\\2\" target=\"_blank\" class=\"standard_tile_link\">\\2</a>",
        $Text
    );

    return $Text;
}

function InsertSmillies($alcode) {
    $alcode = str_replace(
        ":-D", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_biggrin.gif\">",
        $alcode
    );
    $alcode = str_replace(
        ":)", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_smile.gif\">",
        $alcode
    );
    $alcode = str_replace(
        ":(", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_sad.gif\">",
        $alcode
    );
    $alcode = str_replace(
        "8O", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_eek.gif\">",
        $alcode
    );
    $alcode = str_replace(
        ":?", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_confused.gif\">",
        $alcode
    );
    $alcode = str_replace(
        " 8)", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_cool.gif\">",
        $alcode
    );
    $alcode = str_replace(
        ":x", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_mad.gif\">",
        $alcode
    );
    $alcode = str_replace(
        ":P", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_razz.gif\">",
        $alcode
    );
    $alcode = str_replace(
        ":oops:", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_redface.gif\">",
        $alcode
    );
    $alcode = str_replace(
        ":evil:", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_evil.gif\">",
        $alcode
    );
    $alcode = str_replace(
        ":twisted:", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_twisted.gif\">",
        $alcode
    );
    $alcode = str_replace(
        ":roll:", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_rolleyes.gif\">",
        $alcode
    );
    $alcode = str_replace(
        ":frown:", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_frown.gif\">",
        $alcode
    );
    $alcode = str_replace(
        ":|", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_neutral.gif\">",
        $alcode
    );
    $alcode = str_replace(
        ":mrgreen:", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_mrgreen.gif\">",
        $alcode
    );
    $alcode = str_replace(
        ":o", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_surprised.gif\">",
        $alcode
    );
    $alcode = str_replace(
        ":lol:", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_lol.gif\">",
        $alcode
    );
    $alcode = str_replace(
        ":cry:", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_cry.gif\">",
        $alcode
    );
    $alcode = str_replace(
        ";)", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_wink.gif\">",
        $alcode
    );
    $alcode = str_replace(
        ":wink:", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_wink.gif\">",
        $alcode
    );
    $alcode = str_replace(
        ":!:", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_exclaim.gif\">",
        $alcode
    );
    $alcode = str_replace(
        ":arrow:", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_arrow.gif\">",
        $alcode
    );
    $alcode = str_replace(
        ":?:", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_question.gif\">",
        $alcode
    );
    $alcode = str_replace(
        ":idea:", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_idea.gif\">",
        $alcode
    );
    return $alcode;
}

function RemoveSmillies($alcode) {
    $alcode = str_replace(":-D", "", $alcode);
    $alcode = str_replace(":)", "", $alcode);
    $alcode = str_replace(":(", "", $alcode);
    $alcode = str_replace("8O", "", $alcode);
    $alcode = str_replace(":?", "", $alcode);
    $alcode = str_replace(" 8)", "", $alcode);
    $alcode = str_replace(":x", "", $alcode);
    $alcode = str_replace(":P", "", $alcode);
    $alcode = str_replace(":oops:", "", $alcode);
    $alcode = str_replace(":evil:", "", $alcode);
    $alcode = str_replace(":twisted:", "", $alcode);
    $alcode = str_replace(":roll:", "", $alcode);
    $alcode = str_replace(":frown:", "", $alcode);
    $alcode = str_replace(":|", "", $alcode);
    $alcode = str_replace(":mrgreen:", "", $alcode);
    $alcode = str_replace(":o", "", $alcode);
    $alcode = str_replace(":lol:", "", $alcode);
    $alcode = str_replace(":cry:", "", $alcode);
    $alcode = str_replace(";)", "", $alcode);
    $alcode = str_replace(":wink:", "", $alcode);
    $alcode = str_replace(":!:", "", $alcode);
    $alcode = str_replace(":arrow:", "", $alcode);
    $alcode = str_replace(":?:", "", $alcode);
    $alcode = str_replace(":idea:", "", $alcode);
    return $alcode;
}

function get_username_from_id($submitted) {
    global $mysqli;
    $result = $mysqli->query("SELECT userid FROM users WHERE user_id = $submitted") or die("Query failed");
    if ($result->num_rows == 0) {
        return 0;
    } else {
        $query_data = $result->fetch_array(MYSQLI_BOTH);
        return $query_data['userid'];
    }
}

function date_to_timestamp($date_Year, $date_Month, $date_Day) {
    $timestamp = mktime(0, 0, 0, $date_Month, $date_Day, $date_Year);
    return $timestamp;
}

function filter($entry) {
    // Filter out strange characters like ^, $, &, change "it's" to "its"
    static $drop_char_match = array('^', '$', '&', '(', ')', '<', '>', '`', '"', '|', ',', '@', '_', '?', '%', '-',
        '~', '+', '.', '[', ']', '{', '}', ':', '\\', '/', '=', '#', '\'', ';', '!');
    static $drop_char_replace = array('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',
        '', '', '', '', '', '', '', '', '', '', '');

    for ($i = 0; $i < count($drop_char_match); $i++) {
        $entry = str_replace($drop_char_match[$i], $drop_char_replace[$i], $entry);
    }
    return $entry;
}

function search($entry) {
    // search for strange characters like ^, $, &, change "it's" to "its"
    static $drop_char_match = array('^', '$', '&', '(', ')', '<', '>', '`', '"', '|', ',', '@', '_', '?', '%', '-', '~',
         '+', '.', '[', ']', '{', '}', ':', '\\', '/', '=', '#', '\'', ';', '!');

    $count = 0;

    for ($i = 0; $i < count($drop_char_match); $i++) {
        if ($count == 0) {
            $count = substr_count($entry, $drop_char_match[$i]);
        }
    }
    return $count;
}

function az_dropdown_value($entry) {
    $entry = array(
        'num',
        'a',
        'b',
        'c',
        'd',
        'e',
        'f',
        'g',
        'h',
        'i',
        'j',
        'k',
        'l',
        'm',
        'n',
        'o',
        'p',
        'q',
        'r',
        's',
        't',
        'u',
        'v',
        'w',
        'x',
        'y',
        'z'
    );

    return $entry;
}

function az_dropdown_output($entry) {
    $entry = array(
        '0-9',
        'A',
        'B',
        'C',
        'D',
        'E',
        'F',
        'G',
        'H',
        'I',
        'J',
        'K',
        'L',
        'M',
        'N',
        'O',
        'P',
        'Q',
        'R',
        'S',
        'T',
        'U',
        'V',
        'W',
        'X',
        'Y',
        'Z'
    );

    return $entry;
}

function statistics_stack() {
    global $mysqli;

    //**************************
    // Get all the random stats
    //**************************

    // START - NUMBER OF GAMES IN ARCHIVE
    $query     = $mysqli->query("SELECT COUNT(*) AS count FROM game");
    $gamecount = $query->fetch_array(MYSQLI_BOTH);
    $stack[]   = "$gamecount[count] games in archive";

    // END - NUMBER OF GAMES IN ARCHIVE

    mysqli_free_result($query);

    // START - RELEASE STATS
    $query     = $mysqli->query("SELECT COUNT(id) AS count FROM game_release");
    $game_releases = $query->fetch_array(MYSQLI_BOTH);
    $stack[]   = "$game_releases[count] releases in archive";

    // END - RELEASE STATS

    mysqli_free_result($query);

    // START - COUNT GAME SCREENSHOTS IN ARCHIVE
    $query           = $mysqli->query("SELECT COUNT(*) AS count FROM screenshot_game");
    $gamescreencount = $query->fetch_array(MYSQLI_BOTH);
    $stack[]         = "$gamescreencount[count] game screenshots in archive";

    // END - COUNT GAME SCREENSHOTS IN ARCHIVE

    mysqli_free_result($query);

    // START - COUNT HOW MANY GAMES HAS SCREENSHOT
    $query       = $mysqli->query("SELECT COUNT(DISTINCT game_id) AS count FROM screenshot_game");
    $screencount = $query->fetch_array(MYSQLI_BOTH);
    $stack[]     = "$screencount[count] games have screenshots";

    // END - COUNT HOW MANY GAMES HAS SCREENSHOT

    mysqli_free_result($query);

    // START - COUNT COMPANIES IN ARCHIVE
    $query   = $mysqli->query("SELECT COUNT(*) AS count FROM pub_dev");
    $pubdev  = $query->fetch_array(MYSQLI_BOTH);
    $stack[] = "$pubdev[count] companies in the archive";

    // END - COUNT COMPANIES IN ARCHIVE

    mysqli_free_result($query);

    // START - COUNT HOW MANY GAMES HAS PUBLISHER ASSIGNED
    $query     = $mysqli->query("SELECT COUNT(distinct id) AS count FROM game_release WHERE pub_dev_id != 0");
    $publisher = $query->fetch_array(MYSQLI_BOTH);
    $stack[]   = "$publisher[count] games have a publisher assigned";

    // END - COUNT HOW MANY GAMES HAS PUBLISHER ASSIGNED

    //mysqli_free_result($query);

    // START - COUNT HOW MANY GAMES HAS DEVELOPER ASSIGNED
    $query     = $mysqli->query("SELECT COUNT(DISTINCT game_id) AS count FROM game_developer");
    $developer = $query->fetch_array(MYSQLI_BOTH);
    $stack[]   = "$developer[count] games have a developer assigned";

    // END - COUNT HOW MANY GAMES HAS DEVELOPER ASSIGNED

    mysqli_free_result($query);

    // START - COUNT HOW MANY GAMES HAS BOXSCANS
    $query   = $mysqli->query("SELECT COUNT(DISTINCT game_id) AS count FROM game_boxscan");
    $boxscan = $query->fetch_array(MYSQLI_BOTH);
    $stack[] = "$boxscan[count] games have boxscans assigned";

    // END - COUNT HOW MANY GAMES HAS BOXSCANS

    mysqli_free_result($query);

    // START - COUNT HOW MANY GAMES HAS CATEGORIES SET
    $query         = $mysqli->query("SELECT COUNT(DISTINCT game_id) AS count FROM game_genre_cross");
    // Special case here due to the migration from game_categories to game_genre
    // This fails until the DB update script is run because the game_genre_cross
    // table doesn't exist. It prevents accessing the site and CPANEL, preventing
    // to run the DB update script... So just handle the error and skip this line
    // of stats until the DB update script is run and the table exists.
    if ($query) {
        $game_genre    = $query->fetch_array(MYSQLI_BOTH);
        $stack[]       = "$game_genre[count] games have a genre set";
        mysqli_free_result($query);
    }
    // END - COUNT HOW MANY GAMES HAS CATEGORIES SET

    // START - COUNT HOW MANY GAMES HAS DOWNLOAD
    // To do

    // START - GAME REVIEW STATS
    $query       = $mysqli->query("SELECT COUNT(DISTINCT game_id) AS count FROM review_game");
    $review_game = $query->fetch_array(MYSQLI_BOTH);
    $stack[]     = "$review_game[count] games have been reviewed";

    // END - GAME REVIEW STATS

    mysqli_free_result($query);

    // START - USER STATS
    $query   = $mysqli->query("SELECT COUNT(user_id) AS count FROM users");
    $users   = $query->fetch_array(MYSQLI_BOTH);
    $stack[] = "$users[count] registered users";

    // END - USER STATS

    mysqli_free_result($query);

    // START - ARTICLE STATS
    $query        = $mysqli->query("SELECT COUNT(DISTINCT article_id) AS count FROM article_main");
    $article_main = $query->fetch_array(MYSQLI_BOTH);
    $stack[]      = "$article_main[count] articles in archive";

    // END - ARTICLE STATS

    mysqli_free_result($query);

    // START - LINKS STATS
    $query   = $mysqli->query("SELECT COUNT(website_id) AS count FROM website");
    $website = $query->fetch_array(MYSQLI_BOTH);
    $stack[] = "$website[count] links in archive";

    // END - LINKS STATS

    mysqli_free_result($query);

    // START - music STATS
    $query   = $mysqli->query("SELECT COUNT(DISTINCT game_id) AS count FROM game_music");
    $music   = $query->fetch_array(MYSQLI_BOTH);
    $stack[] = "$music[count] games have music attached";

    // END - music STATS

    mysqli_free_result($query);

    // START - music STATS
    $query   = $mysqli->query("SELECT COUNT(music_id) AS count FROM game_music");
    $music   = $query->fetch_array(MYSQLI_BOTH);
    $stack[] = "$music[count] gamemusic files are uploaded";

    // END - music STATS

    return $stack;
}

//This function will create a change log table entry according to its parameters. In the db* files, with every DB
// transaction, this function is called. The table is used for the change log section of the cpanel.
function create_log_entry($section, $section_id, $subsection, $subsection_id, $action, $user_id) {
    global $mysqli;

    $log_time = date_to_timestamp(date('Y'), date('m'), date('d'));

    //  Everything we do for the GAMES SECTION
    if ($section == 'Games') {
        if ($subsection == 'Submission') {
            // get game id
            $query_game_id = "SELECT game_id FROM game_submitinfo WHERE game_submitinfo_id = '$section_id'";
            $result = $mysqli->query($query_game_id) or die("getting game name failed");
            $query_data = $result->fetch_array(MYSQLI_BOTH);
            $section_id = $query_data['game_id'];
            $subsection_id = $query_data['game_id'];
        }

        //  get the game name
        $query_game = "SELECT game_name FROM game WHERE game_id = '$section_id'";
        $result = $mysqli->query($query_game) or die("getting game name failed");
        $query_data   = $result->fetch_array(MYSQLI_BOTH);
        $section_name = $query_data['game_name'];

        if ($subsection == 'Game' or $subsection == 'File' or $subsection == 'Screenshot' or $subsection == 'Mag score'
            or $subsection == 'Box back' or $subsection == 'Box front' or $subsection == 'Review'
            or $subsection == 'Review comment' or $subsection == 'Music' or $subsection == 'Submission'
            or $subsection == 'Fact' or $subsection == 'Sound hardware') {
            $subsection_name = $section_name;
        }

        if ($subsection == 'AKA') {
            //  get the AKA name
            $query_aka = "SELECT aka_name FROM game_aka WHERE game_aka_id = '$subsection_id'";
            $result = $mysqli->query($query_aka) or die("getting aka name failed");
            $query_data      = $result->fetch_array(MYSQLI_BOTH);
            $subsection_name = $query_data['aka_name'];
            $subsection_id   = $section_id;
        }

        if ($subsection == 'Creator') {
            if ($action == 'Delete') {
                //  get the ind name & id
                $query_ind = "SELECT individuals.ind_id,
                                     individuals.ind_name FROM individuals
                                     LEFT JOIN game_author ON ( individuals.ind_id = game_author.ind_id )
                                     WHERE game_author.game_author_id = '$subsection_id'";
                $result = $mysqli->query($query_ind) or die("getting ind name failed");
                $query_data      = $result->fetch_array(MYSQLI_BOTH);
                $subsection_name = $query_data['ind_name'];
                $subsection_id   = $query_data['ind_id'];
            } else {
                //  get the ind name
                $query_ind = "SELECT ind_name FROM individuals WHERE ind_id = '$subsection_id'";
                $result = $mysqli->query($query_ind) or die("getting ind name failed");
                $query_data      = $result->fetch_array(MYSQLI_BOTH);
                $subsection_name = $query_data['ind_name'];
            }
        }

        if ($subsection == 'Publisher' or $subsection == 'Developer') {
            //  get the pub/dev name
            $query_pubdev = "SELECT pub_dev_name FROM pub_dev WHERE pub_dev_id = '$subsection_id'";
            $result = $mysqli->query($query_pubdev) or die("getting pub/dev name failed");
            $query_data      = $result->fetch_array(MYSQLI_BOTH);
            $subsection_name = $query_data['pub_dev_name'];
        }

        if ($subsection == 'Year') {
            die("The table game_year has been deprecated and should not be used anymore");
        }

        if ($subsection == 'Similar') {
            if ($action == 'Delete') {
                // get the cross id
                $query_cross = "SELECT game_similar_cross FROM game_similar WHERE game_similar_id = '$subsection_id'";
                $result = $mysqli->query($query_cross) or die("getting cross failed");
                $query_data    = $result->fetch_array(MYSQLI_BOTH);
                $subsection_id = $query_data['game_similar_cross'];
            }
            //  get the game name
            $query_game = "SELECT game_name FROM game WHERE game_id = '$subsection_id'";
            $result = $mysqli->query($query_game) or die("getting game name failed");
            $query_data      = $result->fetch_array(MYSQLI_BOTH);
            $subsection_name = $query_data['game_name'];
            $subsection_id   = $section_id;
        }

        if ($subsection == 'Comment') {
            //get game_id and game_user_comments_id
            $query_user_comment = "SELECT game_user_comments.game_id,
                                          game_user_comments.game_user_comments_id,
                                          game.game_name
                                          FROM game_user_comments
                                          LEFT JOIN game ON ( game.game_id = game_user_comments.game_id )
                                          WHERE game_user_comments.comment_id = '$subsection_id'";

            $result = $mysqli->query($query_user_comment) or die("getting user comments id failed");
            $query_data      = $result->fetch_array(MYSQLI_BOTH);
            $subsection_id   = $query_data['game_user_comments_id'];
            $section_id      = $query_data['game_id'];
            $section_name    = $query_data['game_name'];
            $subsection_name = $query_data['game_name'];
        }
    }

    //  Everything we do for the GAMES SERIES SECTION
    if ($section == 'Game series') {
        if ($subsection == 'Game') {
            if ($action == 'Delete') {
                //get the game_id and game_series_id
                $query_series = "SELECT game_id, game_series_id FROM game_series_cross
                    WHERE game_series_cross_id = '$subsection_id'";
                $result = $mysqli->query($query_series) or die("getting series info failed");
                $query_data    = $result->fetch_array(MYSQLI_BOTH);
                $subsection_id = $query_data['game_id'];
                $section_id    = $query_data['game_series_id'];
            }

            //  get the game name
            $query_game = "SELECT game_name FROM game WHERE game_id = '$subsection_id'";
            $result = $mysqli->query($query_game) or die("getting game name failed");
            $query_data      = $result->fetch_array(MYSQLI_BOTH);
            $subsection_name = $query_data['game_name'];
        }

        //  get the name of the series
        $query_series = "SELECT game_series_name FROM game_series WHERE game_series_id = '$section_id'";
        $result = $mysqli->query($query_series) or die("getting series name failed");
        $query_data   = $result->fetch_array(MYSQLI_BOTH);
        $section_name = $query_data['game_series_name'];

        if ($subsection == 'Series') {
            $subsection_name = $section_name;
        }
    }

    //  Everything we do for the Trivia SECTION
    if ($section == 'Trivia') {
        if ($subsection == 'DYK' or $subsection == 'Quote' or $subsection == 'Spotlight') {
            $subsection_name = ("Trivia ID " . $subsection_id);
            $section_name    = ("Trivia ID " . $subsection_id);
        }
    }

    //  Everything we do for the LINKS section
    if ($section == 'Links') {
        // Get the website name
        $query_website = "SELECT website_name FROM website WHERE website_id = '$section_id'";
        $result = $mysqli->query($query_website) or die("getting website name failed");
        $query_data   = $result->fetch_array(MYSQLI_BOTH);
        $section_name = $query_data['website_name'];

        if ($subsection == 'Link') {
            $subsection_name = $section_name;
        }

        if ($subsection == 'Category') {
            // Get the category name
            $query_cat = "SELECT website_category_name FROM website_category
                WHERE website_category_id = '$subsection_id'";
            $result = $mysqli->query($query_cat) or die("getting category name failed");
            $query_data      = $result->fetch_array(MYSQLI_BOTH);
            $subsection_name = $query_data['website_category_name'];
        }

        if ($subsection == 'Link submit') {
            // Get the submitted link
            $query_link =  "SELECT website_name FROM website_validate WHERE website_id = $subsection_id";
            $result = $mysqli->query($query_link) or die("getting submitted link name failed: ".$mysqli->error);
            $query_data = $result->fetch_array(MYSQLI_BOTH);
            $section_name = $query_data['website_name'];
            $subsection_name = $query_data['website_name'];
        }
    }

    //  Everything we do for the LINKS CATEGORY section
    if ($section == 'Links cat') {
        // Get the category name
        $query_cat = "SELECT website_category_name FROM website_category WHERE website_category_id = '$section_id'";
        $result = $mysqli->query($query_cat) or die("getting category name failed");
        $query_data   = $result->fetch_array(MYSQLI_BOTH);
        $section_name = $query_data['website_category_name'];

        if ($subsection == 'Category') {
            $subsection_name = $section_name;
        }
    }

    //  Everything we do for the COMPANY section
    if ($section == 'Company') {
        // Get the company name
        $query_comp = "SELECT pub_dev_name FROM pub_dev WHERE pub_dev_id = '$section_id'";
        $result = $mysqli->query($query_comp) or die("getting comp name failed");
        $query_data   = $result->fetch_array(MYSQLI_BOTH);
        $section_name = $query_data['pub_dev_name'];

        if ($subsection == 'Company' or $subsection == 'Logo') {
            $subsection_name = $section_name;
        }
    }

    //  Everything we do for the Individual section
    if ($section == 'Individuals') {
        if ($subsection == 'Nickname') {
            if ($action == 'Delete') {
                // we need to get the ind id
                $query_ind = "SELECT ind_id FROM individual_nicks WHERE individual_nicks_id = '$section_id'";
                $result = $mysqli->query($query_ind) or die("getting individual id failed");
                $query_data    = $result->fetch_array(MYSQLI_BOTH);
                $section_id    = $query_data['ind_id'];
                $subsection_id = $query_data['ind_id'];
            }
        }

        // Get the individual name
        $query_ind = "SELECT ind_name FROM individuals WHERE ind_id = '$section_id'";
        $result = $mysqli->query($query_ind) or die("getting individual name failed");
        $query_data   = $result->fetch_array(MYSQLI_BOTH);
        $section_name = $query_data['ind_name'];

        if ($subsection == 'Individual' or $subsection == 'Image' or $subsection == 'Nickname') {
            $subsection_name = $section_name;
        }
    }

    //  Everything we do for the AUTHor TYPE section
    if ($section == 'Author type') {
        // get the author type name
        $query_author = "SELECT author_type_info FROM author_type WHERE author_type_id = '$section_id'";
        $result = $mysqli->query($query_author) or die("getting author type name failed");
        $query_data   = $result->fetch_array(MYSQLI_BOTH);
        $section_name = $query_data['author_type_info'];

        if ($subsection == 'Author type') {
            $subsection_name = $section_name;
        }
    }

    //  Everything we do for the INTERVIEW section
    if ($section == 'Interviews') {
        if ($subsection == 'Interview') {
            if ($action == 'Update' or $action == 'Delete') {
                //we need to get the individual id
                $query_ind = "SELECT ind_id FROM interview_main WHERE interview_id = '$section_id'";
                $result = $mysqli->query($query_ind) or die("getting ind id failed");
                $query_data = $result->fetch_array(MYSQLI_BOTH);
                $section_id = $query_data['ind_id'];
            }
        }

        if ($subsection == 'Screenshots') {
            if ($action == 'Insert' or $action == 'Delete') {
                //we need to get the individual id
                $query_ind = "SELECT ind_id FROM interview_main WHERE interview_id = '$section_id'";
                $result = $mysqli->query($query_ind) or die("getting ind id failed");
                $query_data = $result->fetch_array(MYSQLI_BOTH);
                $section_id = $query_data['ind_id'];
            }
        }

        // get the name of the person that is interviewed
        $query_ind = "SELECT ind_name FROM individuals WHERE ind_id = '$section_id'";
        $result = $mysqli->query($query_ind) or die("getting ind name failed");
        $query_data   = $result->fetch_array(MYSQLI_BOTH);
        $section_name = $query_data['ind_name'];

        if ($subsection == 'Interview' or $subsection == 'Screenshots') {
            $subsection_name = $section_name;
        }

        if ($subsection == 'Comment') {
            //get game_id and interview_user_comments_id
            $query_user_comment = "SELECT interview_user_comments.interview_id,
                interview_user_comments.interview_user_comments_id,
                individuals.ind_name
                FROM interview_user_comments
                LEFT JOIN interview_main ON ( interview_user_comments.interview_id = interview_main.interview_id )
                LEFT JOIN individuals on (interview_main.ind_id = individuals.ind_id)
                WHERE interview_user_comments.comment_id = '$subsection_id'";

            $result = $mysqli->query($query_user_comment) or die("getting user comments id failed");
            $query_data      = $result->fetch_array(MYSQLI_BOTH);
            $subsection_id   = $query_data['interview_user_comments_id'];
            $section_id      = $query_data['interview_id'];
            $section_name    = $query_data['ind_name'];
            $subsection_name = $query_data['ind_name'];
        }
    }

    //  Everything we do for the Review section
    if ($section == 'Reviews') {
        if ($subsection == 'Comment') {
            //get the game name
            $query_user_comment = "SELECT * FROM review_user_comments
                LEFT JOIN review_main ON (review_user_comments.review_id = review_main.review_id)
                LEFT JOIN review_game ON (review_main.review_id = review_game.review_id)
                LEFT JOIN game ON (game.game_id = review_game.game_id)
                WHERE review_user_comments.comment_id = '$subsection_id'";

            $result = $mysqli->query($query_user_comment) or die("getting user comments id failed");
            $query_data      = $result->fetch_array(MYSQLI_BOTH);
            $subsection_id   = $query_data['review_user_comments_id'];
            $section_id      = $query_data['review_id'];
            $section_name    = $query_data['game_name'];
            $subsection_name = $query_data['game_name'];
        }
    }

    //  Everything we do for the AUTHor TYPE section
    if ($section == 'News') {
        if ($subsection == 'News submit') {
            // get the headline
            $query_news = "SELECT news_headline FROM news_submission WHERE news_submission_id = '$section_id'";
            $result = $mysqli->query($query_news) or die("getting headline failed");
            $query_data   = $result->fetch_array(MYSQLI_BOTH);
            $section_name = $query_data['news_headline'];

            $subsection_name = $section_name;
        }

        if ($subsection == 'News item') {
            // get the headline
            $query_news = "SELECT news_headline FROM news WHERE news_id = '$section_id'";
            $result = $mysqli->query($query_news) or die("getting headline failed");
            $query_data   = $result->fetch_array(MYSQLI_BOTH);
            $section_name = $query_data['news_headline'];

            $subsection_name = $section_name;
        }

        if ($subsection == 'Image') {
            // get the image name
            $query_image = "SELECT news_image_name FROM news_image WHERE news_image_id = '$section_id'";
            $result = $mysqli->query($query_image) or die("getting image name failed");
            $query_data   = $result->fetch_array(MYSQLI_BOTH);
            $section_name = $query_data['news_image_name'];

            $subsection_name = $section_name;
        }
    }

    //  Everything we do for the Menu Set SECTION
    if ($section == 'Menu set') {
        //  get the menu set name
        $query_menu_Set = "SELECT menu_sets_name FROM menu_set WHERE menu_sets_id = '$section_id'";
        $result = $mysqli->query($query_menu_Set) or die("getting menu set name failed");
        $query_data   = $result->fetch_array(MYSQLI_BOTH);
        $section_name = $query_data['menu_sets_name'];

        if ($subsection == 'Menu set' or $subsection == 'Menu disk (multiple)') {
            $subsection_name = $section_name;
        }

        if ($subsection == 'Crew') {
            // get the name of the crew
            $query_crew = "SELECT crew_name FROM crew WHERE crew_id = '$subsection_id'";
            $result = $mysqli->query($query_crew) or die("getting crew name failed");
            $query_data      = $result->fetch_array(MYSQLI_BOTH);
            $subsection_name = $query_data['crew_name'];
        }

        if ($subsection == 'Individual') {
            // get the name of the crew
            $query_ind = "SELECT ind_name FROM individuals WHERE ind_id = '$subsection_id'";
            $result = $mysqli->query($query_ind) or die("getting individual name failed");
            $query_data      = $result->fetch_array(MYSQLI_BOTH);
            $subsection_name = $query_data['ind_name'];
        }

        if ($subsection == 'Menu type') {
            // get the name of the menu type
            $query_menu_type = "SELECT menu_types_text FROM menu_types_main
                WHERE menu_types_main_id = '$subsection_id'";
            $result = $mysqli->query($query_menu_type) or die("getting menu type name failed");
            $query_data      = $result->fetch_array(MYSQLI_BOTH);
            $subsection_name = $query_data['menu_types_text'];
        }

        if ($subsection == 'Menu disk') {
            // get the name of the menu disk
            $sql_menus = "SELECT menu_disk.menu_sets_id,
                                menu_set.menu_sets_name,
                                menu_disk.menu_disk_number,
                                menu_disk.menu_disk_letter,
                                menu_disk.menu_disk_version,
                                menu_disk.menu_disk_part
                                FROM menu_disk
                                LEFT JOIN menu_set ON (menu_disk.menu_sets_id = menu_set.menu_sets_id)
                                WHERE menu_disk.menu_disk_id = '$subsection_id'";

            $result_menus = $mysqli->query($sql_menus) or die("error in query disk name");

            while ($row = $result_menus->fetch_array(MYSQLI_BOTH)) {
                // Create Menu disk name
                $menu_disk_name = "$row[menu_sets_name] ";
                if (isset($row['menu_disk_number'])) {
                    $menu_disk_name .= "$row[menu_disk_number]";
                }
                if (isset($row['menu_disk_letter'])) {
                    $menu_disk_name .= "$row[menu_disk_letter]";
                }
                if (isset($row['menu_disk_part'])) {
                    if (is_numeric($row['menu_disk_part'])) {
                        $menu_disk_name .= " part $row[menu_disk_part]";
                    } else {
                        $menu_disk_name .= "$row[menu_disk_part]";
                    }
                }
            }
            $subsection_name = $menu_disk_name;
        }
    }

    //  Everything we do for the CREW SECTION
    if ($section == 'Crew') {
        // get the name of the crew
        $query_crew = "SELECT crew_name FROM crew WHERE crew_id = '$section_id'";
        $result = $mysqli->query($query_crew) or die("getting crew name failed");
        $query_data   = $result->fetch_array(MYSQLI_BOTH);
        $section_name = $query_data['crew_name'];

        if ($subsection == 'Crew' or $subsection == 'Logo') {
            $subsection_name = $section_name;
        }

        if ($subsection == 'Subcrew') {
            if ($action == 'Delete') {
                // get the id's
                $query_crew = "SELECT * FROM sub_crew WHERE sub_crew_id = '$subsection_id'";
                $result = $mysqli->query($query_crew) or die("getting crew ids failed");
                $query_data    = $result->fetch_array(MYSQLI_BOTH);
                $subsection_id = $query_data['crew_id'];
                $section_id    = $query_data['parent_id'];

                // get the name of the crew
                $query_crew = "SELECT crew_name FROM crew WHERE crew_id = '$section_id'";
                $result = $mysqli->query($query_crew) or die("getting crew name failed");
                $query_data   = $result->fetch_array(MYSQLI_BOTH);
                $section_name = $query_data['crew_name'];
            }

            // get the name of the subcrew
            $query_crew = "SELECT crew_name FROM crew WHERE crew_id = '$subsection_id'";
            $result = $mysqli->query($query_crew) or die("getting crew name failed");
            $query_data      = $result->fetch_array(MYSQLI_BOTH);
            $subsection_name = $query_data['crew_name'];
        }

        if ($subsection == 'Member') {
            if ($action == 'Delete') {
                // get the id's
                $query_crew = "SELECT * FROM crew_individual WHERE crew_individual_id = '$subsection_id'";
                $result = $mysqli->query($query_crew) or die("getting crew ids failed");
                $query_data    = $result->fetch_array(MYSQLI_BOTH);
                $subsection_id = $query_data['ind_id'];
                $section_id    = $query_data['crew_id'];

                // get the name of the crew
                $query_crew = "SELECT crew_name FROM crew WHERE crew_id = '$section_id'";
                $result = $mysqli->query($query_crew) or die("getting crew name failed");
                $query_data   = $result->fetch_array(MYSQLI_BOTH);
                $section_name = $query_data['crew_name'];
            }

            $query_ind = "SELECT ind_name FROM individuals WHERE ind_id = '$subsection_id'";
            $result = $mysqli->query($query_ind) or die("getting ind name failed");
            $query_data      = $result->fetch_array(MYSQLI_BOTH);
            $subsection_name = $query_data['ind_name'];
        }

        if ($subsection == 'Nickname') {
            // get the id's
            $query_crew = "SELECT * FROM crew_individual WHERE crew_individual_id = '$subsection_id'";
            $result = $mysqli->query($query_crew) or die("getting crew ids failed");
            $query_data    = $result->fetch_array(MYSQLI_BOTH);
            $subsection_id = $query_data['ind_id'];
            $section_id    = $query_data['crew_id'];

            // get the name of the crew
            $query_crew = "SELECT crew_name FROM crew WHERE crew_id = '$section_id'";
            $result = $mysqli->query($query_crew) or die("getting crew name failed");
            $query_data   = $result->fetch_array(MYSQLI_BOTH);
            $section_name = $query_data['crew_name'];

            // get the name of the member
            $query_ind = "SELECT ind_name FROM individuals WHERE ind_id = '$subsection_id'";
            $result = $mysqli->query($query_ind) or die("getting ind name failed");
            $query_data      = $result->fetch_array(MYSQLI_BOTH);
            $subsection_name = $query_data['ind_name'];
        }
    }

    //  Everything we do for the MENU TYPE SECTION
    if ($section == 'Menu type') {
        // get the name of the menu type
        $query_menu_type = "SELECT menu_types_text FROM menu_types_main WHERE menu_types_main_id = '$section_id'";
        $result = $mysqli->query($query_menu_type) or die("getting menu type name failed");
        $query_data   = $result->fetch_array(MYSQLI_BOTH);
        $section_name = $query_data['menu_types_text'];

        if ($subsection == 'Menu type') {
            $subsection_name = $section_name;
        }
    }

    //  Everything we do for the MENU DISK
    if ($section == 'Menu disk') {
        // get the name of the menu disk
        $sql_menus = "SELECT menu_disk.menu_sets_id,
                            menu_set.menu_sets_name,
                            menu_disk.menu_disk_number,
                            menu_disk.menu_disk_letter,
                            menu_disk.menu_disk_version,
                            menu_disk.menu_disk_part
                            FROM menu_disk
                            LEFT JOIN menu_set ON (menu_disk.menu_sets_id = menu_set.menu_sets_id)
                            WHERE menu_disk.menu_disk_id = '$section_id'";

        $result_menus = $mysqli->query($sql_menus) or die("error in query disk name");

        while ($row = $result_menus->fetch_array(MYSQLI_BOTH)) {
            $section_id = $row['menu_sets_id'];

            // Create Menu disk name
            $menu_disk_name = "$row[menu_sets_name] ";
            if (isset($row['menu_disk_number'])) {
                $menu_disk_name .= "$row[menu_disk_number]";
            }
            if (isset($row['menu_disk_letter'])) {
                $menu_disk_name .= "$row[menu_disk_letter]";
            }
            if (isset($row['menu_disk_part'])) {
                if (is_numeric($row['menu_disk_part'])) {
                    $menu_disk_name .= " part $row[menu_disk_part]";
                } else {
                    $menu_disk_name .= "$row[menu_disk_part]";
                }
            }
        }

        $section_name = $menu_disk_name;

        if ($subsection == 'State') {
            // get the name of the menu type
            $query_menu_state = "SELECT menu_state FROM menu_disk_state WHERE state_id = '$subsection_id'";
            $result = $mysqli->query($query_menu_state) or die("getting menu state name failed");
            $query_data      = $result->fetch_array(MYSQLI_BOTH);
            $subsection_name = $query_data['menu_state'];
        }

        if ($subsection == 'Parent') {
            // get the name of the parent
            $sql_menus = "SELECT menu_disk.menu_sets_id,
                                menu_set.menu_sets_name,
                                menu_disk.menu_disk_number,
                                menu_disk.menu_disk_letter,
                                menu_disk.menu_disk_version,
                                menu_disk.menu_disk_part
                                FROM menu_disk
                                LEFT JOIN menu_set ON (menu_disk.menu_sets_id = menu_set.menu_sets_id)
                                WHERE menu_disk.menu_disk_id = '$subsection_id'";

            $result_menus = $mysqli->query($sql_menus) or die("error in query disk name");

            while ($row = $result_menus->fetch_array(MYSQLI_BOTH)) {
                // Create Menu disk name
                $menu_disk_name = "$row[menu_sets_name] ";
                if (isset($row['menu_disk_number'])) {
                    $menu_disk_name .= "$row[menu_disk_number]";
                }
                if (isset($row['menu_disk_letter'])) {
                    $menu_disk_name .= "$row[menu_disk_letter]";
                }
                if (isset($row['menu_disk_part'])) {
                    if (is_numeric($row['menu_disk_part'])) {
                        $menu_disk_name .= " part $row[menu_disk_part]";
                    } else {
                        $menu_disk_name .= "$row[menu_disk_part]";
                    }
                }
            }
            $subsection_name = $menu_disk_name;
        }

        if ($subsection == 'Year') {
            $subsection_name = $subsection_id;
        }

        if ($subsection == 'Menu disk' or $subsection == 'Screenshots' or $subsection == 'File') {
            $subsection_name = $section_name;
        }

        if ($subsection == 'Credits') {
            if ($action == 'Delete') {
                //get the ind id
                $query_ind = "SELECT ind_id FROM menu_disk_credits WHERE menu_disk_credits_id = '$subsection_id'";
                $result = $mysqli->query($query_ind) or die("getting individual name failed");
                $query_data    = $result->fetch_array(MYSQLI_BOTH);
                $subsection_id = $query_data['ind_id'];
            }

            // get the name of the individual
            $query_ind = "SELECT ind_name FROM individuals WHERE ind_id = '$subsection_id'";
            $result = $mysqli->query($query_ind) or die("getting individual name failed");
            $query_data      = $result->fetch_array(MYSQLI_BOTH);
            $subsection_name = $query_data['ind_name'];
        }

        if ($subsection == 'Nickname') {
            // get the individual id
            $query_ind = "SELECT ind_id FROM menu_disk_credits WHERE individual_nicks_id = '$subsection_id'";
            $result = $mysqli->query($query_ind) or die("getting individual name failed");
            $query_data = $result->fetch_array(MYSQLI_BOTH);
            $ind_id     = $query_data['ind_id'];

            //now get the individual name
            $query_ind = "SELECT ind_name FROM individuals WHERE ind_id = '$ind_id'";
            $result = $mysqli->query($query_ind) or die("getting individual name failed");
            $query_data      = $result->fetch_array(MYSQLI_BOTH);
            $subsection_name = $query_data['ind_name'];
        }

        if ($subsection == 'Game' or $subsection == 'Game doc') {
            //  get the game name
            $query_game = "SELECT game_name FROM game WHERE game_id = '$subsection_id'";
            $result = $mysqli->query($query_game) or die("getting game name failed");
            $query_data      = $result->fetch_array(MYSQLI_BOTH);
            $subsection_name = $query_data['game_name'];
        }

        if ($subsection == 'Demo') {
            //  get the demo name
            $query_demo = "SELECT demo_name FROM demo WHERE demo_id = '$subsection_id'";
            $result = $mysqli->query($query_demo) or die("getting demo name failed");
            $query_data      = $result->fetch_array(MYSQLI_BOTH);
            $subsection_name = $query_data['demo_name'];
        }

        if ($subsection == 'Tool' or $subsection == 'Tool doc') {
            //  get the tool name
            $query_tool = "SELECT tools_name FROM tools WHERE tools_id = '$subsection_id'";
            $result = $mysqli->query($query_tool) or die("getting tool name failed");
            $query_data      = $result->fetch_array(MYSQLI_BOTH);
            $subsection_name = $query_data['tools_name'];
        }

        if ($subsection == 'Doc type') {
            // get the name of the doc type
            $query_doc_type = "SELECT doc_type_name FROM doc_type WHERE doc_type_id = '$subsection_id'";
            $result = $mysqli->query($query_doc_type) or die("getting doc type name failed");
            $query_data      = $result->fetch_array(MYSQLI_BOTH);
            $subsection_name = $query_data['doc_type_name'];
        }

        if ($subsection == 'Software' or $subsection == 'Chain' or $subsection == 'Doc' or $subsection == 'Authors') {
            //get the type of software
            $query_soft = "SELECT menu_types_main_id FROM menu_disk_title WHERE menu_disk_title_id = '$subsection_id'";
            $result = $mysqli->query($query_soft) or die("getting menu_type failed");
            $query_data = $result->fetch_array(MYSQLI_BOTH);
            $type       = $query_data['menu_types_main_id'];

            //get the name of the software
            if ($type == '1') {
                //get the id of the game
                $query_game = "SELECT game_id FROM menu_disk_title_game WHERE menu_disk_title_id = '$subsection_id'";
                $result = $mysqli->query($query_game) or die("getting game id failed");
                $query_data    = $result->fetch_array(MYSQLI_BOTH);
                $subsection_id = $query_data['game_id'];

                //  get the game name
                $query_game = "SELECT game_name FROM game WHERE game_id = '$subsection_id'";
                $result = $mysqli->query($query_game) or die("getting game name failed");
                $query_data      = $result->fetch_array(MYSQLI_BOTH);
                $subsection_name = $query_data['game_name'];

                if ($subsection != 'Chain' and $subsection != 'Authors') {
                    $subsection = 'Game';
                }
            }

            if ($type == '2') {
                //get the id of the demo
                $query_demo = "SELECT demo_id FROM menu_disk_title_demo WHERE menu_disk_title_id = '$subsection_id'";
                $result = $mysqli->query($query_demo) or die("getting demo id failed");
                $query_data    = $result->fetch_array(MYSQLI_BOTH);
                $subsection_id = $query_data['demo_id'];

                //  get the demo name
                $query_demo = "SELECT demo_name FROM demo WHERE demo_id = '$subsection_id'";
                $result = $mysqli->query($query_demo) or die("getting demo name failed");
                $query_data      = $result->fetch_array(MYSQLI_BOTH);
                $subsection_name = $query_data['demo_name'];
                if ($subsection != 'Chain' and $subsection != 'Authors') {
                    $subsection = 'Demo';
                }
            }

            if ($type == '3') {
                //get the id of the tool
                $query_tool = "SELECT tools_id FROM menu_disk_title_tools WHERE menu_disk_title_id = '$subsection_id'";
                $result = $mysqli->query($query_tool) or die("getting toold id failed");
                $query_data    = $result->fetch_array(MYSQLI_BOTH);
                $subsection_id = $query_data['tools_id'];

                //  get the tool name
                $query_tool = "SELECT tools_name FROM tools WHERE tools_id = '$subsection_id'";
                $result = $mysqli->query($query_tool) or die("getting tool name failed");
                $query_data      = $result->fetch_array(MYSQLI_BOTH);
                $subsection_name = $query_data['tools_name'];
                if ($subsection != 'Chain' and $subsection != 'Authors') {
                    $subsection = 'Tool';
                }
            }

            if ($type == '6') {
                //get the doc cross id
                $query_game_doc = "SELECT doc_games_id FROM menu_disk_title_doc_games
                    WHERE menu_disk_title_id = '$subsection_id'";
                $result = $mysqli->query($query_game_doc) or die("getting doc_game_id failed");
                $query_data    = $result->fetch_array(MYSQLI_BOTH);
                $subsection_id = $query_data['doc_games_id'];

                //  get the game id
                $query_game_id = "SELECT game_id FROM doc_disk_game WHERE doc_disk_game_id = '$subsection_id'";
                $result = $mysqli->query($query_game_id) or die("getting game id failed");
                $query_data    = $result->fetch_array(MYSQLI_BOTH);
                $subsection_id = $query_data['game_id'];

                //  get the game name
                $query_game = "SELECT game_name FROM game WHERE game_id = '$subsection_id'";
                $result = $mysqli->query($query_game) or die("getting game name failed");
                $query_data      = $result->fetch_array(MYSQLI_BOTH);
                $subsection_name = $query_data['game_name'];

                if ($subsection == 'Authors') {
                } else {
                    $subsection      = 'Game doc';
                }

                if ($subsection_name == '') {
                    //get the doc cross id
                    $query_tool_doc = "SELECT doc_tools_id FROM menu_disk_title_doc_tools
                        WHERE menu_disk_title_id = '$subsection_id'";
                    $result = $mysqli->query($query_tool_doc) or die("getting doc_tools_id failed");
                    $query_data    = $result->fetch_array(MYSQLI_BOTH);
                    $subsection_id = $query_data['doc_tools_id'];

                    //get the id of the tool
                    $query_tool = "SELECT tools_id FROM menu_disk_title_tools
                        WHERE menu_disk_title_id = '$subsection_id'";
                    $result = $mysqli->query($query_tool) or die("getting toold id failed");
                    $query_data    = $result->fetch_array(MYSQLI_BOTH);
                    $subsection_id = $query_data['tools_id'];

                    //  get the tool name
                    $query_tool = "SELECT tools_name FROM tools WHERE tools_id = '$subsection_id'";
                    $result = $mysqli->query($query_tool) or die("getting tool name failed");
                    $query_data      = $result->fetch_array(MYSQLI_BOTH);
                    $subsection_name = $query_data['tools_name'];

                    if ($subsection == 'Authors') {
                    } else {
                        $subsection      = 'Tool doc';
                    }
                }
            }
        }
    }

    //  Everything we do for the Articles section
    if ($section == 'Articles') {
        if ($subsection == 'Article') {
            if ($action == 'Update' or $action == 'Delete' or $action == 'Insert') {
                //we need to get the title
                $query_title = "SELECT article_title FROM article_text WHERE article_id = '$section_id'";
                $result = $mysqli->query($query_title) or die("getting title failed");
                $query_data   = $result->fetch_array(MYSQLI_BOTH);
                $section_name = $query_data['article_title'];
            }
        }

        if ($subsection == 'Screenshots') {
            if ($action == 'Insert' or $action == 'Delete') {
                //we need to get the title
                $query_title = "SELECT article_title FROM article_text WHERE article_id = '$section_id'";
                $result = $mysqli->query($query_title) or die("getting title failed");
                $query_data   = $result->fetch_array(MYSQLI_BOTH);
                $section_name = $query_data['article_title'];
            }
        }

        if ($subsection == 'Article' or $subsection == 'Screenshots') {
            $subsection_name = $section_name;
        }

        if ($subsection == 'Comment') {
            //we need to get the title
            $query_user_comment = "SELECT article_user_comments.article_id,
                article_user_comments.article_user_comments_id,
                article_text.article_title
                FROM article_user_comments
                LEFT JOIN article_main ON ( article_user_comments.article_id = article_main.article_id )
                LEFT JOIN article_text on ( article_main.article_id = article_text.article_id )
                WHERE article_user_comments.comments_id = '$subsection_id'";

            $result = $mysqli->query($query_user_comment) or die("getting user comments id failed");
            $query_data      = $result->fetch_array(MYSQLI_BOTH);
            $section_id      = $query_data['article_id'];
            $section_name    = $query_data['article_title'];
            $subsection_name = $section_name;
        }
    }

    //  Everything we do for the ARTICLE TYPE SECTION
    if ($section == 'Article type') {
        // get the name of the article type
        $query_article_type = "SELECT article_type FROM article_type WHERE article_type_id = '$section_id'";
        $result = $mysqli->query($query_article_type) or die("getting article type name failed");
        $query_data   = $result->fetch_array(MYSQLI_BOTH);
        $section_name = $query_data['article_type'];

        if ($subsection == 'Article type') {
            $subsection_name = $section_name;
        }
    }

    //  Everything we do for the DOC TYPE SECTION
    if ($section == 'Doc type') {
        // get the name of the doc type
        $query_doc_type = "SELECT doc_type_name FROM doc_type WHERE doc_type_id = '$section_id'";
        $result = $mysqli->query($query_doc_type) or die("getting doc type name failed");
        $query_data   = $result->fetch_array(MYSQLI_BOTH);
        $section_name = $query_data['doc_type_name'];

        if ($subsection == 'Doc type') {
            $subsection_name = $section_name;
        }
    }

    //  Everything we do for the DOC CATEGORY SECTION
    if ($section == 'Doc category') {
        // get the name of the doc type
        $query_category_type = "SELECT doc_category_name FROM doc_category WHERE doc_category_id = '$section_id'";
        $result = $mysqli->query($query_category_type) or die("getting doc category name failed");
        $query_data   = $result->fetch_array(MYSQLI_BOTH);
        $section_name = $query_data['doc_category_name'];

        if ($subsection == 'Doc category') {
            $subsection_name = $section_name;
        }
    }

    //  Everything we do for the DOWNLOAD FORMAT SECTION
    if ($section == 'Format') {
        // get the name of the format
        $query_format = "SELECT format FROM format WHERE format_id = '$section_id'";
        $result = $mysqli->query($query_format) or die("getting format name failed");
        $query_data   = $result->fetch_array(MYSQLI_BOTH);
        $section_name = $query_data['format'];

        if ($subsection == 'Format') {
            $subsection_name = $section_name;
        }
    }

    //  Everything we do for the DOWNLOAD LINGO SECTION
    if ($section == 'Lingo') {
        // get the name of the lingo
        $query_lingo = "SELECT lingo_name FROM lingo WHERE lingo_id = '$section_id'";
        $result = $mysqli->query($query_lingo) or die("getting lingo name failed");
        $query_data   = $result->fetch_array(MYSQLI_BOTH);
        $section_name = $query_data['lingo_name'];

        if ($subsection == 'Lingo') {
            $subsection_name = $section_name;
        }
    }

    //  Everything we do for the DOWNLOAD OPTION SECTION
    if ($section == 'Option') {
        // get the name of the lingo
        $query_option = "SELECT download_option FROM download_options WHERE download_options_id = '$section_id'";
        $result = $mysqli->query($query_option) or die("getting option name failed");
        $query_data   = $result->fetch_array(MYSQLI_BOTH);
        $section_name = $query_data['download_option'];

        if ($subsection == 'Option') {
            $subsection_name = $section_name;
        }
    }

    //  Everything we do for the TOS VERSION SECTION
    if ($section == 'TOS') {
        // get the name of the lingo
        $query_tos = "SELECT tos_version FROM tos_version WHERE tos_version_id = '$section_id'";
        $result = $mysqli->query($query_tos) or die("getting tos name failed");
        $query_data   = $result->fetch_array(MYSQLI_BOTH);
        $section_name = $query_data['tos_version'];

        if ($subsection == 'TOS') {
            $subsection_name = $section_name;
        }
    }

    //  Everything we do for the TRAINER SECTION
    if ($section == 'Trainer') {
        // get the name of the trainer option
        $query_trainer = "SELECT trainer_options FROM trainer_options WHERE trainer_options_id = '$section_id'";
        $result = $mysqli->query($query_trainer) or die("getting trainer optione failed");
        $query_data   = $result->fetch_array(MYSQLI_BOTH);
        $section_name = $query_data['trainer_options'];

        if ($subsection == 'Trainer') {
            $subsection_name = $section_name;
        }
    }

    //  Everything we do for the DOWNLOADS EDIT SECTION
    if ($section == 'Downloads') {
        // get the name of the game
        $query_game = "SELECT * FROM game WHERE game_id = '$section_id'";
        $result = $mysqli->query($query_game) or die("getting game_name failed yooohoo");
        $query_data   = $result->fetch_array(MYSQLI_BOTH);
        $section_name = $query_data['game_name'];

        if ($subsection == 'Options') {
            // get the name of the option
            $query_option = "SELECT * FROM download_options WHERE download_options_id = '$subsection_id'";
            $result = $mysqli->query($query_option) or die("getting option failed");
            $query_data   = $result->fetch_array(MYSQLI_BOTH);
            $subsection_name = $query_data['download_option'];
            $subsection_id = $query_data['download_options_id'];
        }

        if ($subsection == 'TOS') {
            // get the name of the option
            $query_tos = "SELECT * FROM tos_version
                             WHERE tos_version_id = '$subsection_id'";
            $result = $mysqli->query($query_tos) or die("getting tos failed");
            $query_data   = $result->fetch_array(MYSQLI_BOTH);
            $subsection_name = $query_data['tos_version'];
            $subsection_id = $query_data['tos_version_id'];
        }

        if ($subsection == 'Details') {
            $subsection_name = $section_name;
        }

        if ($subsection == 'Menudisk') {
            $subsection_name = $section_name;
        }

        if ($subsection == 'Chain') {
            $subsection_name = $section_name;
        }

        if ($subsection == 'Trainer') {
            // get the name of the trainer option
            $query_trainer = "SELECT * FROM trainer_options
                             WHERE trainer_options_id = '$subsection_id'";
            $result = $mysqli->query($query_trainer) or die("getting trainer failed");
            $query_data   = $result->fetch_array(MYSQLI_BOTH);
            $subsection_name = $query_data['trainer_options'];
            $subsection_id = $query_data['trainer_options_id'];
        }

        if ($subsection == 'Crew') {
            // get the name of the trainer option
            $query_crew = "SELECT * FROM crew WHERE
                            crew_id = '$subsection_id'";
            $result = $mysqli->query($query_crew) or die("getting crew failed");
            $query_data   = $result->fetch_array(MYSQLI_BOTH);
            $subsection_name = $query_data['crew_name'];
        }

        if ($subsection == 'Authors') {
            // get the name of the author option
            $query_ind = "SELECT ind_name FROM individuals WHERE
                            ind_id = '$subsection_id'";
            $result = $mysqli->query($query_ind) or die("getting ind failed");
            $query_data   = $result->fetch_array(MYSQLI_BOTH);
            $subsection_name = $query_data['ind_name'];
        }
    }

    //  Everything we do for the BUG REPORT TYPE SECTION
    if ($section == 'Bug type') {
        // get the name of the type
        $query_type = "SELECT bug_report_type FROM bug_report_type WHERE bug_report_type_id = '$section_id'";
        $result = $mysqli->query($query_type) or die("getting type name failed");
        $query_data   = $result->fetch_array(MYSQLI_BOTH);
        $section_name = $query_data['bug_report_type'];

        if ($subsection == 'Bug type') {
            $subsection_name = $section_name;
        }
    }

    //  Everything we do for the BUG REPORT SECTION
    if ($section == 'Bug') {
        $subsection_name = ("Bug report ID " . $subsection_id);
        $section_name    = ("Bug report ID " . $subsection_id);
    }

    //  Everything we do for the GAMES CONFIG section
    if ($section == 'Games Config') {
        if ($subsection == 'Games Engine') {
            // Get the engine name
            $query = "SELECT name FROM engine WHERE id = '$section_id'";
            $result = $mysqli->query($query) or die("getting engine name failed");
            $query_data   = $result->fetch_array(MYSQLI_BOTH);
            $section_name = $query_data['name'];
        } elseif ($subsection == 'Programming Language') {
            // Get the programming language name
            $query = "SELECT name FROM programming_language WHERE id = '$section_id'";
            $result = $mysqli->query($query) or die("getting language name failed");
            $query_data   = $result->fetch_array(MYSQLI_BOTH);
            $section_name = $query_data['name'];
        } elseif ($subsection == 'Genre') {
            // Get the genre name
            $query = "SELECT name FROM game_genre WHERE id = '$section_id'";
            $result = $mysqli->query($query) or die("getting genre name failed");
            $query_data   = $result->fetch_array(MYSQLI_BOTH);
            $section_name = $query_data['name'];
        } elseif ($subsection == 'Port') {
            // Get the port name
            $query = "SELECT name FROM port WHERE id = '$section_id'";
            $result = $mysqli->query($query) or die("getting port name failed");
            $query_data   = $result->fetch_array(MYSQLI_BOTH);
            $section_name = $query_data['name'];
        } elseif ($subsection == 'Individual Role') {
            // Get the role name
            $query = "SELECT name FROM individual_role WHERE id = '$section_id'";
            $result = $mysqli->query($query) or die("getting role name failed");
            $query_data   = $result->fetch_array(MYSQLI_BOTH);
            $section_name = $query_data['name'];
        } elseif ($subsection == 'Developer Role') {
            // Get the role name
            $query = "SELECT role FROM developer_role WHERE id = '$section_id'";
            $result = $mysqli->query($query) or die("getting role name failed");
            $query_data   = $result->fetch_array(MYSQLI_BOTH);
            $section_name = $query_data['role'];
        } elseif ($subsection == 'Language') {
            // Get the language name
            $query = "SELECT name FROM language WHERE id = '$section_id'";
            $result = $mysqli->query($query) or die("getting language name failed");
            $query_data   = $result->fetch_array(MYSQLI_BOTH);
            $section_name = $query_data['name'];
        } elseif ($subsection == 'Control') {
            // Get the language name
            $query = "SELECT name FROM control WHERE id = '$section_id'";
            $result = $mysqli->query($query) or die("getting control type failed");
            $query_data   = $result->fetch_array(MYSQLI_BOTH);
            $section_name = $query_data['name'];
        } elseif ($subsection == 'Resolution') {
            // Get the resolution name
            $query = "SELECT name FROM resolution WHERE id = '$section_id'";
            $result = $mysqli->query($query) or die("getting resolution failed");
            $query_data   = $result->fetch_array(MYSQLI_BOTH);
            $section_name = $query_data['name'];
        } elseif ($subsection == 'System') {
            // Get the system name
            $query = "SELECT name FROM system WHERE id = '$section_id'";
            $result = $mysqli->query($query) or die("getting system failed");
            $query_data   = $result->fetch_array(MYSQLI_BOTH);
            $section_name = $query_data['name'];
        } elseif ($subsection == 'Emulator') {
            // Get the emulator name
            $query = "SELECT name FROM emulator WHERE id = '$section_id'";
            $result = $mysqli->query($query) or die("getting emulator failed");
            $query_data   = $result->fetch_array(MYSQLI_BOTH);
            $section_name = $query_data['name'];
        } elseif ($subsection == 'Trainer') {
            // Get the trainer option name
            $query = "SELECT name FROM trainer_option WHERE id = '$section_id'";
            $result = $mysqli->query($query) or die("getting trainer option failed");
            $query_data   = $result->fetch_array(MYSQLI_BOTH);
            $section_name = $query_data['name'];
        } elseif ($subsection == 'Memory') {
            // Get the memory amount
            $query = "SELECT memory FROM memory WHERE id = '$section_id'";
            $result = $mysqli->query($query) or die("getting memory amount failed");
            $query_data   = $result->fetch_array(MYSQLI_BOTH);
            $section_name = $query_data['memory'];
        } elseif ($subsection == 'Tos') {
            // Get the tos amount
            $query = "SELECT name FROM tos WHERE id = '$section_id'";
            $result = $mysqli->query($query) or die("getting tos version failed");
            $query_data   = $result->fetch_array(MYSQLI_BOTH);
            $section_name = $query_data['name'];
        } elseif ($subsection == 'Protection') {
            // Get the protection type
            $query = "SELECT name FROM copy_protection WHERE id = '$section_id'";
            $result = $mysqli->query($query) or die("getting copy protection failed");
            $query_data   = $result->fetch_array(MYSQLI_BOTH);
            $section_name = $query_data['name'];
        } elseif ($subsection == 'Disk Protection') {
            // Get the protection type
            $query = "SELECT name FROM disk_protection WHERE id = '$section_id'";
            $result = $mysqli->query($query) or die("getting disk protection failed");
            $query_data   = $result->fetch_array(MYSQLI_BOTH);
            $section_name = $query_data['name'];
        } elseif ($subsection == 'Enhancement') {
            // Get the Enhancement
            $query = "SELECT name FROM enhancement WHERE id = '$section_id'";
            $result = $mysqli->query($query) or die("getting enhancement failed");
            $query_data   = $result->fetch_array(MYSQLI_BOTH);
            $section_name = $query_data['name'];
        } elseif ($subsection == 'Media Type') {
            // Get the Enhancement
            $query = "SELECT name FROM media_type WHERE id = '$section_id'";
            $result = $mysqli->query($query) or die("getting media type failed");
            $query_data   = $result->fetch_array(MYSQLI_BOTH);
            $section_name = $query_data['name'];
        } elseif ($subsection == 'Media Scan Type') {
            // Get the Enhancement
            $query = "SELECT name FROM media_scan_type WHERE id = '$section_id'";
            $result = $mysqli->query($query) or die("getting media type failed");
        } elseif ($subsection == 'Sound hardware') {
            // Get the the hardware
            $query = "SELECT name FROM sound_hardware WHERE id = '$section_id'";
            $result = $mysqli->query($query) or die("getting sound hardware failed");
            $query_data   = $result->fetch_array(MYSQLI_BOTH);
            $section_name = $query_data['name'];
        } elseif ($subsection == 'Progress System') {
            // Get the the system
            $query = "SELECT name FROM game_progress_system WHERE id = '$section_id'";
            $result = $mysqli->query($query) or die("getting progress system failed");
            $query_data   = $result->fetch_array(MYSQLI_BOTH);
            $section_name = $query_data['name'];
        }
        $subsection_name = $section_name;
    }

    //Everything we do for GAME RELEASES
    if ($section == 'Game Release') {
        //  get the release name
        $query_game = "SELECT game_name FROM game WHERE game_id = '$section_id'";
        $result = $mysqli->query($query_game) or die("getting name failed");
        $query_data   = $result->fetch_array(MYSQLI_BOTH);
        $section_name = $query_data['game_name'];

        if ($subsection == 'Game Release' or $subsection == 'Release Info' or $subsection == 'Release AKA'
            or $subsection == 'Compatibility' or $subsection == 'Distributor'
            or $subsection == 'Scene' or $subsection == 'Memory Enhancement' or $subsection == 'Minimum Memory'
            or $subsection == 'Incompatible Memory' or $subsection == 'Incompatible TOS'
            or $subsection == 'Protection' or $subsection == 'Language' or $subsection == 'System Enhancement'
            or $subsection == 'Copy Protection' or $subsection == 'Disk Protection' or $subsection == 'Media'
            or $subsection == 'Dump' or $subsection == 'Media Scan' or $subsection == "Scan") {
            $subsection_name = $section_name;
        }

        if ($subsection == 'Distributor') {
            // get the distributor name
            $query_distributor = "SELECT * FROM pub_dev
                                  LEFT JOIN game_release_distributor
                                  ON (pub_dev.pub_dev_id = game_release_distributor.pub_dev_id)
                                  WHERE pub_dev.pub_dev_id = '$subsection_id'";
            $result = $mysqli->query($query_distributor) or die("getting name failed");
            $query_data   = $result->fetch_array(MYSQLI_BOTH);
            $subsection_name = $query_data['pub_dev_name'];
            $subsection_id = $query_data['game_release_id'];
        }
    }

    $section_name    = $mysqli->real_escape_string($section_name);
    $subsection_name = $mysqli->real_escape_string($subsection_name);

    $sql_log = $mysqli->query("INSERT INTO change_log
        (section, section_id, section_name, sub_section, sub_section_id, sub_section_name, user_id, action, timestamp)
        VALUES ('$section', '$section_id', '$section_name', '$subsection', '$subsection_id', '$subsection_name',
        '$user_id', '$action', '$log_time')") or die("Couldn't insert change log into database");
}

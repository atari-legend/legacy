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

//this is a test

function InsertALCode($alcode){
	$alcode = preg_replace("#\[color\=(\#[0-9A-F]{0,6}|[A-z]+)\](.*)\[\/color\]#Ui", "<span style=\"color: $1;\">$2</span>", $alcode);
	//$alcode = eregi_replace("\\[style=([^\\[]*)\\]","<span class=\"\\1\">",$alcode);
	//$alcode = str_replace("[/style]", "</span>", $alcode);
	$alcode = preg_replace("(\[size=(.+?)\](.+?)\[\/size\])is","<span style=\"font-size: $1px\">$2</span>",$alcode);
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
	$alcode = preg_replace( "#\[b\](.+?)\[/b\]#is", "<b>\\1</b>", $alcode );
	$alcode = preg_replace( "#\[i\](.+?)\[/i\]#is", "<i>\\1</i>", $alcode );
	$alcode = preg_replace( "#\[u\](.+?)\[/u\]#is", "<u>\\1</u>", $alcode );
	$alcode = preg_replace( "#\[s\](.+?)\[/s\]#is", "<s>\\1</s>", $alcode );
	$alcode = str_replace("[*]", "<li>", $alcode);
	$alcode = str_replace("[list]", "<ul>", $alcode);
	$alcode = str_replace("[/list]", "</ul>", $alcode);
	$alcode = preg_replace("#\[email\=(.*)\](.*)\[\/email\]#Ui", "<a href=\"mailto: $1\">$2</a>", $alcode);
	$alcode = preg_replace("#\[email\](.*)\[\/email\]#Ui", "<a href=\"mailto: $1\">$1</a>", $alcode);
	$alcode = preg_replace("#\[hotspot\=(.*)\](.*)\[\/hotspot\]#Ui", "<a name=\"$1\">$2</a>", $alcode);
	$alcode = str_replace("[quote]", "<blockquote><span class=\"12px\">quote:</span><hr>", $alcode);
	$alcode = str_replace("[/quote]", "<hr></blockquote>", $alcode);
	$alcode = str_replace("[code]","<blockquote><pre>",$alcode);
	$alcode = str_replace("[/code]","</pre></blockquote>",$alcode);
	$alcode = preg_replace("#\[url\](www\..+)\[\/url\]#i", "[url=http://$1]$1[/url]", $alcode);
	$alcode = preg_replace("#\[url\=(www\..+)\](.*)\[\/url\]#i", "[url=http://$1]$2[/url]", $alcode);
	$alcode = preg_replace("#\[url\=(.*)\](.*)\[\/url\]#Ui", "<a href=\"$1\" class=\"standard_tile_link_black\">$2</a>", $alcode);
	$alcode = preg_replace("#\[url\](.*)\[\/url\]#Ui", "<a href=\"$1\" class=\"standard_tile_link_black\">$1</a>", $alcode);
	$alcode = preg_replace("#\[hotspotUrl\=(.*)\](.*)\[\/hotspotUrl\]#Ui", "<a href=\"$1\" class=\"standard_tile_link_black\">$2</a>", $alcode);
	$alcode = preg_replace("#(^|[\n ])([\w]+?://.*?[^ \"\n\r\t<]*)#is", "\\1<a href=\"\\2\" target=\"_blank\" class=\"standard_tile_link_black\">\\2</a>", $alcode);
	$alcode = preg_replace("#(^|[\n ])((www|ftp)\.[\w\-]+\.[\w\-.\~]+(?:/[^ \"\t\n\r<]*)?)#is", "\\1<a href=\"http://\\2\" target=\"_blank\" class=\"standard_tile_link_black\">\\2</a>", $alcode);

	return $alcode;
}

function BBCode($Text)
{
	// Replace any html brackets with HTML Entities to prevent executing HTML or script
	// Don't use strip_tags here because it breaks [url] search by replacing & with amp
	$Text = str_replace("<", "&lt", $Text);
	$Text = str_replace(">", "&gt", $Text);

	// Set up the parameters for a URL search string
	$URLSearchString = " a-zA-Z0-9\:\/\-\?\&\.\=\_\~\#\'";
	// Set up the parameters for a MAIL search string
	$MAILSearchString = $URLSearchString . " a-zA-Z0-9\.@";

	// Perform URL Search
	$Text = preg_replace("/\[url\]([$URLSearchString]*)\[\/url\]/", '<a href="$1" target="_blank" class="standard_tile_link_black">$1</a>', $Text);
	$Text = preg_replace("(\[url\=([$URLSearchString]*)\](.+?)\[/url\])", '<a href="$1" target="_blank" class="standard_tile_link_black">$2</a>', $Text);
	//$Text = preg_replace("(\[url\=([$URLSearchString]*)\]([$URLSearchString]*)\[/url\])", '<a href="$1" target="_blank" class="main_links">$2</a>', $Text);

	// Perform MAIL Search
	$Text = preg_replace("(\[mail\]([$MAILSearchString]*)\[/mail\])", '<a href="mailto:$1">$1</a>', $Text);
	$Text = preg_replace("/\[mail\=([$MAILSearchString]*)\](.+?)\[\/mail\]/", '<a href="mailto:$1">$2</a>', $Text);
	
	// Check for bold text
	$Text = preg_replace("(\[b\](.+?)\[\/b])is",'<span style="font-weight:bold;">$1</span>',$Text);

	// Check for Italics text
	$Text = preg_replace("(\[i\](.+?)\[\/i\])is",'<span style="font-style: italic;">$1</span>',$Text);

	// Check for Underline text
	$Text = preg_replace("(\[u\](.+?)\[\/u\])is",'<span style="text-decoration: underline;">$1</span>',$Text);

	// Check for strike-through text
	$Text = preg_replace("(\[s\](.+?)\[\/s\])is",'<span class="strikethrough">$1</span>',$Text);

	// Check for over-line text
	$Text = preg_replace("(\[o\](.+?)\[\/o\])is",'<span class="overline">$1</span>',$Text);

	// Check for colored text
	$Text = preg_replace("(\[color=(.+?)\](.+?)\[\/color\])is","<span style=\"color: $1\">$2</span>",$Text);

	// Check for sized text
	$Text = preg_replace("(\[size=(.+?)\](.+?)\[\/size\])is","<span style=\"font-size: $1px\">$2</span>",$Text);

	// Check for list text
	$Text = preg_replace("/\[list\](.+?)\[\/list\]/is", '<ul class="listbullet">$1</ul>' ,$Text);
	$Text = preg_replace("/\[list=1\](.+?)\[\/list\]/is", '<ul class="listdecimal">$1</ul>' ,$Text);
	$Text = preg_replace("/\[list=i\](.+?)\[\/list\]/s", '<ul class="listlowerroman">$1</ul>' ,$Text);
	$Text = preg_replace("/\[list=I\](.+?)\[\/list\]/s", '<ul class="listupperroman">$1</ul>' ,$Text);
	$Text = preg_replace("/\[list=a\](.+?)\[\/list\]/s", '<ul class="listloweralpha">$1</ul>' ,$Text);
	$Text = preg_replace("/\[list=A\](.+?)\[\/list\]/s", '<ul class="listupperalpha">$1</ul>' ,$Text);
	$Text = str_replace("[*]", "<li>", $Text);

	// Check for font change text
	$Text = preg_replace("(\[font=(.+?)\](.+?)\[\/font\])","<span style=\"font-family: $1;\">$2</span>",$Text);

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
	$Text = preg_replace("/\[code\](.+?)\[\/code\]/is","$CodeLayout", $Text);

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
	$Text = preg_replace("/\[quote\](.+?)\[\/quote\]/is","$QuoteLayout", $Text);
	
	// Images
	// [img]pathtoimage[/img]
	$Text = preg_replace("/\[img\](.+?)\[\/img\]/", '<img src="$1">', $Text);
	
	// [img=widthxheight]image source[/img]
	$Text = preg_replace("/\[img\=([0-9]*)x([0-9]*)\](.+?)\[\/img\]/", '<img src="$3" height="$2" width="$1">', $Text);
	
	// urls without using the url tag
	$Text = preg_replace("#(^|[\n ])([\w]+?://.*?[^ \"\n\r\t<]*)#is", "\\1<a href=\"\\2\" target=\"_blank\" class=\"standard_tile_link\">\\2</a>", $Text);

	$Text = preg_replace("#(^|[\n ])((www|ftp)\.[\w\-]+\.[\w\-.\~]+(?:/[^ \"\t\n\r<]*)?)#is", "\\1<a href=\"http://\\2\" target=\"_blank\" class=\"standard_tile_link\">\\2</a>", $Text);

	return $Text;
}

function InsertSmillies($alcode){
	$alcode = str_replace(":-D", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_biggrin.gif\">", $alcode);
	$alcode = str_replace(":)", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_smile.gif\">", $alcode);
	$alcode = str_replace(":(", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_sad.gif\">", $alcode);
	$alcode = str_replace("8O", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_eek.gif\">", $alcode);
	$alcode = str_replace(":?", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_confused.gif\">", $alcode);
	$alcode = str_replace(" 8)", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_cool.gif\">", $alcode);
	$alcode = str_replace(":x", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_mad.gif\">", $alcode);
	$alcode = str_replace(":P", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_razz.gif\">", $alcode);
	$alcode = str_replace(":oops:", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_redface.gif\">", $alcode);
	$alcode = str_replace(":evil:", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_evil.gif\">", $alcode);
	$alcode = str_replace(":twisted:", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_twisted.gif\">", $alcode);
	$alcode = str_replace(":roll:", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_rolleyes.gif\">", $alcode);
	$alcode = str_replace(":frown:", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_frown.gif\">", $alcode);
	$alcode = str_replace(":|", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_neutral.gif\">", $alcode);
	$alcode = str_replace(":mrgreen:", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_mrgreen.gif\">", $alcode);
	$alcode = str_replace(":o", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_surprised.gif\">", $alcode);
	$alcode = str_replace(":lol:", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_lol.gif\">", $alcode);
	$alcode = str_replace(":cry:", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_cry.gif\">", $alcode);
	$alcode = str_replace(";)", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_wink.gif\">", $alcode);
	$alcode = str_replace(":wink:", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_wink.gif\">", $alcode);
	$alcode = str_replace(":!:", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_exclaim.gif\">", $alcode);
	$alcode = str_replace(":arrow:", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_arrow.gif\">", $alcode);
	$alcode = str_replace(":?:", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_question.gif\">", $alcode);
	$alcode = str_replace(":idea:", "<img style=\"vertical-align: middle;\" src=\"../templates/0/emoticons/icon_idea.gif\">", $alcode);
	return $alcode;
}

function RemoveSmillies($alcode){
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

function convert_timestamp($timestamp)
{
	$timestamp = date("F j, Y",$timestamp);
	return $timestamp;
} 

function convert_timestamp_small($timestamp)
{
	$timestamp = date("j-m-y",$timestamp);
	return $timestamp;
} 
	
function get_username_from_id($submitted)
{
	$query = "SELECT userid FROM users WHERE user_id = $submitted";
	global $mysqli;
	$result = $mysqli->query($query) or die("Query failed");
	if(get_rows($result) == 0) return 0;
	else
	{
		$query_data = $result->fetch_array(MYSQLI_BOTH);
	return $query_data['userid'];
	}
}

function get_rows ($result)
{
	$num=$result->num_rows;
	return $num;
}

function date_to_timestamp($date_Year,$date_Month,$date_Day)
{
	$timestamp = mktime (0,0,0,$date_Month,$date_Day,$date_Year);
	return $timestamp;
} 
	

function filter($entry){
// Filter out strange characters like ^, $, &, change "it's" to "its"
	static $drop_char_match =   array('^', '$', '&', '(', ')', '<', '>', '`', '"', '|', ',', '@', '_', '?', '%', '-', '~', '+', '.', '[', ']', '{', '}', ':', '\\', '/', '=', '#', '\'', ';', '!');
	static $drop_char_replace = array('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '' , '', '', '', '', '', '');

	for($i = 0; $i < count($drop_char_match); $i++)
	{
		$entry =  str_replace($drop_char_match[$i], $drop_char_replace[$i], $entry);
	}
	return $entry;
}

function search($entry){
// search for strange characters like ^, $, &, change "it's" to "its"
	static $drop_char_match =   array('^', '$', '&', '(', ')', '<', '>', '`', '"', '|', ',', '@', '_', '?', '%', '-', '~', '+', '.', '[', ']', '{', '}', ':', '\\', '/', '=', '#', '\'', ';', '!');
	
	$count = 0;
	
	for($i = 0; $i < count($drop_char_match); $i++)
	{
		if ($count == 0)
		{
			$count = substr_count($entry, $drop_char_match[$i]);
		}
	}
	return $count;
}

function az_dropdown_value($entry) {
	
		$entry = array('num','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
	
	return $entry;
}

function az_dropdown_output($entry) {
	
		$entry = array('0-9','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	
	return $entry;
}

function statistics_stack() {

	global $mysqli;
	
	//**************************
	// Get all the random stats
	//**************************

	// START - NUMBER OF GAMES IN ARCHIVE
	$sql = "SELECT COUNT(*) AS count FROM game";
	$query = $mysqli->query($sql);
	$gamecount = $query->fetch_array(MYSQLI_BOTH);
	$stack[] = "$gamecount[count] games in archive";

	// END - NUMBER OF GAMES IN ARCHIVE

	mysqli_free_result($query);

	// START - COUNT GAME SCREENSHOTS IN ARCHIVE
	$sql = "SELECT COUNT(*) AS count FROM screenshot_game";
	$query = $mysqli->query($sql);
	$gamescreencount = $query->fetch_array(MYSQLI_BOTH);
	$stack[] = "$gamescreencount[count] game screenshots in archive";

	// END - COUNT GAME SCREENSHOTS IN ARCHIVE

	mysqli_free_result($query);

	// START - COUNT HOW MANY GAMES HAS SCREENSHOT
	$sql = "SELECT COUNT(DISTINCT game_id) AS count FROM screenshot_game";
	$query = $mysqli->query($sql);
	$screencount = $query->fetch_array(MYSQLI_BOTH);
	$stack[] = "$screencount[count] games have screenshots";

	// END - COUNT HOW MANY GAMES HAS SCREENSHOT

	mysqli_free_result($query);

		// START - COUNT COMPANIES IN ARCHIVE
	$sql = "SELECT COUNT(*) AS count FROM pub_dev";
	$query = $mysqli->query($sql);
	$pubdev = $query->fetch_array(MYSQLI_BOTH);
	$stack[] = "$pubdev[count] companies in the archive";

	// END - COUNT COMPANIES IN ARCHIVE

	mysqli_free_result($query);

	// START - COUNT HOW MANY GAMES HAS PUBLISHER ASSIGNED
	$sql = "SELECT COUNT(DISTINCT game_id) AS count FROM game_publisher";
	$query = $mysqli->query($sql);
	$publisher = $query->fetch_array(MYSQLI_BOTH);
	$stack[] = "$publisher[count] games have a publisher assigned";

	// END - COUNT HOW MANY GAMES HAS PUBLISHER ASSIGNED

	mysqli_free_result($query);

		// START - COUNT HOW MANY GAMES HAS DEVELOPER ASSIGNED
	$sql = "SELECT COUNT(DISTINCT game_id) AS count FROM game_developer";
	$query = $mysqli->query($sql);
	$developer = $query->fetch_array(MYSQLI_BOTH);
	$stack[] = "$developer[count] games have a developer assigned";

	// END - COUNT HOW MANY GAMES HAS DEVELOPER ASSIGNED

	mysqli_free_result($query);

	// START - COUNT HOW MANY GAMES HAS BOXSCANS
	$sql = "SELECT COUNT(DISTINCT game_id) AS count FROM game_boxscan";
	$query = $mysqli->query($sql);
	$boxscan = $query->fetch_array(MYSQLI_BOTH);
	$stack[] = "$boxscan[count] games have boxscans assigned";

	// END - COUNT HOW MANY GAMES HAS BOXSCANS

	mysqli_free_result($query);

		// START - COUNT HOW MANY GAMES HAS CATEGORIES SET
	$sql = "SELECT COUNT(DISTINCT game_id) AS count FROM game_cat_cross";
	$query = $mysqli->query($sql);
	$game_category = $query->fetch_array(MYSQLI_BOTH);
	$stack[] = "$game_category[count] games have category set";

	// END - COUNT HOW MANY GAMES HAS CATEGORIES SET

	mysqli_free_result($query);

	// START - COUNT NUMBER OF DOWNLOADABLE FILES
	$sql = "SELECT COUNT(game_id) AS count FROM game_download";
	$query = $mysqli->query($sql);
	$game_files = $query->fetch_array(MYSQLI_BOTH);
	$stack[] = "$game_files[count] files for download";

	// END - COUNT NUMBER OF DOWNLOADABLE FILES

	mysqli_free_result($query);

		// START - COUNT HOW MANY GAMES HAS DOWNLOAD
	$sql = "SELECT COUNT(DISTINCT game_id) AS count FROM game_download";
	$query = $mysqli->query($sql);
	$game_download = $query->fetch_array(MYSQLI_BOTH);
	$stack[] = "$game_download[count] games have download";

	// END - COUNT HOW MANY GAMES HAS DOWNLOAD

	mysqli_free_result($query);

		// START - RELEASE YEAR STATS
	$sql = "SELECT COUNT(game_id) AS count FROM game_year";
	$query = $mysqli->query($sql);
	$game_year = $query->fetch_array(MYSQLI_BOTH);
	$stack[] = "$game_year[count] games have a release year set";

	// END - RELEASE YEAR STATS

	mysqli_free_result($query);

		// START - GAME REVIEW STATS
	$sql = "SELECT COUNT(DISTINCT game_id) AS count FROM review_game";
	$query = $mysqli->query($sql);
	$review_game = $query->fetch_array(MYSQLI_BOTH);
	$stack[] = "$review_game[count] games have been reviewed";

	// END - GAME REVIEW STATS

	mysqli_free_result($query);

		// START - USER STATS
	$sql = "SELECT COUNT(user_id) AS count FROM users";
	$query = $mysqli->query($sql);
	$users = $query->fetch_array(MYSQLI_BOTH);
	$stack[] = "$users[count] registered users";

	// END - USER STATS

	mysqli_free_result($query);

		// START - ARTICLE STATS
	$sql = "SELECT COUNT(DISTINCT article_id) AS count FROM article_main";
	$query = $mysqli->query($sql);
	$article_main = $query->fetch_array(MYSQLI_BOTH);
	$stack[] = "$article_main[count] articles in archive";

	// END - ARTICLE STATS

	mysqli_free_result($query);

		// START - LINKS STATS
	$sql = "SELECT COUNT(website_id) AS count FROM website";
	$query = $mysqli->query($sql);
	$website = $query->fetch_array(MYSQLI_BOTH);
	$stack[] = "$website[count] links in archive";

	// END - LINKS STATS

	mysqli_free_result($query);

		// START - music STATS
	$sql = "SELECT COUNT(DISTINCT game_id) AS count FROM game_music";
	$query = $mysqli->query($sql);
	$music = $query->fetch_array(MYSQLI_BOTH);
	$stack[] = "$music[count] games have music attached";

	// END - music STATS

	mysqli_free_result($query);

		// START - music STATS
	$sql = "SELECT COUNT(music_id) AS count FROM game_music";
	$query = $mysqli->query($sql);
	$music = $query->fetch_array(MYSQLI_BOTH);
	$stack[] = "$music[count] gamemusic files are uploaded";

	// END - music STATS

	return $stack;	
}

//This function will create a change log table entry according to its parameters. In the db* files, with every DB transaction, 
//this function is called. The table is used for the change log section of the cpanel.
function create_log_entry($section, $section_id, $subsection, $subsection_id, $action, $user_id) {
	
	global $mysqli;
	
	$log_time = date_to_timestamp(date('Y'),date('m'),date('d'));
	
//	Everything we do for the GAMES SECTION	
	If ( $section == 'Games' )
	{
		if ( $subsection == 'Submission' )
		{
			// get game id
			$query_game_id = "SELECT game_id FROM game_submitinfo WHERE game_submitinfo_id = '$section_id'";
			$result = $mysqli->query($query_game_id) or die("getting game name failed");
			$query_data = $result->fetch_array(MYSQLI_BOTH);
			$section_id = $query_data['game_id'];
			
		}
		
		//  get the game name
			$query_game = "SELECT game_name FROM game WHERE game_id = '$section_id'";
			$result = $mysqli->query($query_game) or die("getting game name failed");
			$query_data = $result->fetch_array(MYSQLI_BOTH);
			$section_name = $query_data['game_name'];
	
	
		If ( $subsection == 'Game' OR $subsection == 'File' OR $subsection == 'Screenshot' OR  $subsection == 'Mag score' OR
			 $subsection == 'Box back' OR $subsection == 'Box front' OR $subsection == 'Review' OR $subsection == 'Review comment' OR 
			 $subsection == 'Music' OR $subsection == 'Submission' )
		{
			$subsection_name = $section_name;
		}
		
		If ( $subsection == 'AKA' )
		{
			//  get the AKA name
				$query_aka = "SELECT aka_name FROM game_aka WHERE game_aka_id = '$subsection_id'";
				$result = $mysqli->query($query_aka) or die("getting aka name failed");
				$query_data = $result->fetch_array(MYSQLI_BOTH);
				$subsection_name = $query_data['aka_name'];
				$subsection_id = $section_id;
		}
		
		If ( $subsection == 'Creator' )
		{
			if ($action == 'Delete')
			{
				//  get the ind name & id
				$query_ind = "SELECT individuals.ind_id, 
									 individuals.ind_name FROM individuals 
														  LEFT JOIN game_author ON ( individuals.ind_id = game_author.ind_id ) 
														  WHERE game_author.game_author_id = '$subsection_id'";
				$result = $mysqli->query($query_ind) or die("getting ind name failed");
				$query_data = $result->fetch_array(MYSQLI_BOTH);
				$subsection_name = $query_data['ind_name'];
				$subsection_id = $query_data['ind_id'];
			}
			else
			{
			//  get the ind name
				$query_ind = "SELECT ind_name FROM individuals WHERE ind_id = '$subsection_id'";
				$result = $mysqli->query($query_ind) or die("getting ind name failed");
				$query_data = $result->fetch_array(MYSQLI_BOTH);
				$subsection_name = $query_data['ind_name'];
			}
		}
		
		If ( $subsection == 'Publisher' OR $subsection == 'Developer' )
		{
			//  get the pub/dev name
				$query_pubdev = "SELECT pub_dev_name FROM pub_dev WHERE pub_dev_id = '$subsection_id'";
				$result = $mysqli->query($query_pubdev) or die("getting pub/dev name failed");
				$query_data = $result->fetch_array(MYSQLI_BOTH);
				$subsection_name = $query_data['pub_dev_name'];
		}
		
		If ( $subsection == 'Year' )
		{
			//  get the game year
				$query_gameyear = "SELECT game_year FROM game_year WHERE game_year_id = '$subsection_id'";
				$result = $mysqli->query($query_gameyear) or die("getting gameyear failed");
				$query_data = $result->fetch_array(MYSQLI_BOTH);
				$subsection_name = $query_data['game_year'];
				$subsection_id = $section_id;
		}
		
		If ( $subsection == 'Similar' )
		{
			if ($action == 'Delete')
			{
				// get the cross id
				$query_cross = "SELECT game_similar_cross FROM game_similar WHERE game_similar_id = '$subsection_id'";
				$result = $mysqli->query($query_cross) or die("getting cross failed");
				$query_data = $result->fetch_array(MYSQLI_BOTH);
				$subsection_id = $query_data['game_similar_cross'];
			}
		//  get the game name
			$query_game = "SELECT game_name FROM game WHERE game_id = '$subsection_id'";
			$result = $mysqli->query($query_game) or die("getting game name failed");
			$query_data = $result->fetch_array(MYSQLI_BOTH);
			$subsection_name = $query_data['game_name'];
			$subsection_id = $section_id;
		}
		
		If ( $subsection == 'Comment' )
		{
			//get game_id and game_user_comments_id
			$query_user_comment = "SELECT game_user_comments.game_id, 
										  game_user_comments.game_user_comments_id,
										  game.game_name 
										  FROM game_user_comments 
										  LEFT JOIN game ON ( game.game_id = game_user_comments.game_id )
										  WHERE game_user_comments.comment_id = '$subsection_id'";
										  
			$result = $mysqli->query($query_user_comment) or die("getting user comments id failed");
			$query_data = $result->fetch_array(MYSQLI_BOTH);
			$subsection_id = $query_data['game_user_comments_id'];
			$section_id = $query_data['game_id'];
			$section_name = $query_data['game_name'];
			$subsection_name = $query_data['game_name'];
		}
	}
	
//	Everything we do for the GAMES SERIES SECTION	
	If ( $section == 'Game series' )
	{	
		If ( $subsection == 'Game' )
		{
			if ( $action == 'Delete' )
			{
				//get the game_id and game_series_id
				$query_series = "SELECT game_id, game_series_id FROM game_series_cross WHERE game_series_cross_id = '$subsection_id'";
				$result = $mysqli->query($query_series) or die("getting series info failed");
				$query_data = $result->fetch_array(MYSQLI_BOTH);
				$subsection_id = $query_data['game_id'];
				$section_id = $query_data['game_series_id'];
			}
			
			//  get the game name
			$query_game = "SELECT game_name FROM game WHERE game_id = '$subsection_id'";
			$result = $mysqli->query($query_game) or die("getting game name failed");
			$query_data = $result->fetch_array(MYSQLI_BOTH);
			$subsection_name = $query_data['game_name'];
		}
		
		//  get the name of the series 
		$query_series = "SELECT game_series_name FROM game_series WHERE game_series_id = '$section_id'";
		$result = $mysqli->query($query_series) or die("getting series name failed");
		$query_data = $result->fetch_array(MYSQLI_BOTH);
		$section_name = $query_data['game_series_name'];
		
		If ( $subsection == 'Series' )
		{
			$subsection_name = $section_name;
		}
	}

//	Everything we do for the Trivia SECTION		
	If ( $section == 'Trivia' )
	{
		if ( $subsection == 'DYK' OR $subsection == 'Quote' )
		{
			$subsection_name = ( "Trivia ID " . $subsection_id );
			$section_name = ( "Trivia ID " . $subsection_id );
		}
	}

//	Everything we do for the USERS SECTION			
	If ( $section == 'Users' )
	{
		// Get the username
		$query_username = "SELECT userid FROM users WHERE user_id = '$section_id'";
		$result = $mysqli->query($query_username) or die("getting user name failed");
		$query_data = $result->fetch_array(MYSQLI_BOTH);
		$section_name = $query_data['userid'];
		
		if ( $subsection == 'Avatar' OR $subsection == 'User' )
		{
			$subsection_name = $section_name;
		}
	
	}
	
	//	Everything we do for the LINKS section			
	If ( $section == 'Links' )
	{		
		// Get the website name
		$query_website = "SELECT website_name FROM website WHERE website_id = '$section_id'";
		$result = $mysqli->query($query_website) or die("getting website name failed");
		$query_data = $result->fetch_array(MYSQLI_BOTH);
		$section_name = $query_data['website_name'];
		
		if ( $subsection == 'Link' )
		{
			$subsection_name = $section_name;
		}
		
		if ( $subsection == 'Category' )
		{
			// Get the category name
			$query_cat = "SELECT website_category_name FROM website_category WHERE website_category_id = '$subsection_id'";
			$result = $mysqli->query($query_cat) or die("getting category name failed");
			$query_data = $result->fetch_array(MYSQLI_BOTH);
			$subsection_name = $query_data['website_category_name'];
		}	
	}
	
	//	Everything we do for the LINKS CATEGORY section			
	If ( $section == 'Links cat' )
	{
		// Get the category name
		$query_cat = "SELECT website_category_name FROM website_category WHERE website_category_id = '$section_id'";
		$result = $mysqli->query($query_cat) or die("getting category name failed");
		$query_data = $result->fetch_array(MYSQLI_BOTH);
		$section_name = $query_data['website_category_name'];
		
		if ( $subsection == 'Category' )
		{
			$subsection_name = $section_name;
		}
	}	

	//	Everything we do for the COMPANY section			
	If ( $section == 'Company' )
	{
		// Get the company name
		$query_comp = "SELECT pub_dev_name FROM pub_dev WHERE pub_dev_id = '$section_id'";
		$result = $mysqli->query($query_comp) or die("getting comp name failed");
		$query_data = $result->fetch_array(MYSQLI_BOTH);
		$section_name = $query_data['pub_dev_name'];
		
		if ( $subsection == 'Company' OR $subsection == 'Logo')
		{
			$subsection_name = $section_name;
		}
	}
	
	//	Everything we do for the Individual section			
	If ( $section == 'Individuals' )
	{
		if ( $subsection == 'Nickname' )
		{
			if ( $action == 'Delete' )
			{
				// we need to get the ind id
				$query_ind = "SELECT ind_id FROM individual_nicks WHERE individual_nicks_id = '$section_id'";
				$result = $mysqli->query($query_ind) or die("getting individual id failed");
				$query_data = $result->fetch_array(MYSQLI_BOTH);
				$section_id = $query_data['ind_id'];
				$subsection_id = $query_data['ind_id'];
			}
		}	
			
		// Get the individual name
		$query_ind = "SELECT ind_name FROM individuals WHERE ind_id = '$section_id'";
		$result = $mysqli->query($query_ind) or die("getting individual name failed");
		$query_data = $result->fetch_array(MYSQLI_BOTH);
		$section_name = $query_data['ind_name'];
		
		if ( $subsection == 'Individual' OR $subsection == 'Image' OR $subsection == 'Nickname')
		{
			$subsection_name = $section_name;
		}
	}
	
	//	Everything we do for the AUTHOR TYPE section			
	If ( $section == 'Author type' )
	{
		// get the author type name
		$query_author = "SELECT author_type_info FROM author_type WHERE author_type_id = '$section_id'";
		$result = $mysqli->query($query_author) or die("getting author type name failed");
		$query_data = $result->fetch_array(MYSQLI_BOTH);
		$section_name = $query_data['author_type_info'];
		
		if ( $subsection == 'Author type' )
		{
			$subsection_name = $section_name;
		}
	}
	
	//	Everything we do for the INTERVIEW section			
	If ( $section == 'Interviews' )
	{	
		if ( $subsection == 'Interview' )
		{
			If ( $action == 'Update' OR $action == 'Delete' )
			{
				//we need to get the individual id
				$query_ind = "SELECT ind_id FROM interview_main WHERE interview_id = '$section_id'";
				$result = $mysqli->query($query_ind) or die("getting ind id failed");
				$query_data = $result->fetch_array(MYSQLI_BOTH);
				$section_id = $query_data['ind_id'];	
			}
		}
		
		if ( $subsection == 'Screenshots' )
		{
			If ( $action == 'Insert' OR $action == 'Delete')
			{
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
		$query_data = $result->fetch_array(MYSQLI_BOTH);
		$section_name = $query_data['ind_name'];
		
		if ( $subsection == 'Interview' or $subsection == 'Screenshots' )
		{
			$subsection_name = $section_name;
		}
	}
	
	//	Everything we do for the AUTHOR TYPE section			
	If ( $section == 'News' )
	{
		if ( $subsection == 'News submit' )
		{
			// get the headline
			$query_news = "SELECT news_headline FROM news_submission WHERE news_submission_id = '$section_id'";
			$result = $mysqli->query($query_news) or die("getting headline failed");
			$query_data = $result->fetch_array(MYSQLI_BOTH);
			$section_name = $query_data['news_headline'];
			
			$subsection_name = $section_name;
		}
		
		if ( $subsection == 'News item' )
		{
			// get the headline
			$query_news = "SELECT news_headline FROM news WHERE news_id = '$section_id'";
			$result = $mysqli->query($query_news) or die("getting headline failed");
			$query_data = $result->fetch_array(MYSQLI_BOTH);
			$section_name = $query_data['news_headline'];
			
			$subsection_name = $section_name;
		}
		
		if ( $subsection == 'Image' )
		{
			// get the image name
			$query_image = "SELECT news_image_name FROM news_image WHERE news_image_id = '$section_id'";
			$result = $mysqli->query($query_image) or die("getting image name failed");
			$query_data = $result->fetch_array(MYSQLI_BOTH);
			$section_name = $query_data['news_image_name'];
			
			$subsection_name = $section_name;
		}
	}
	
	//	Everything we do for the Menu Set SECTION	
	If ( $section == 'Menu set' )
	{
		//  get the menu set name
			$query_menu_Set = "SELECT menu_sets_name FROM menu_set WHERE menu_sets_id = '$section_id'";
			$result = $mysqli->query($query_menu_Set) or die("getting menu set name failed");
			$query_data = $result->fetch_array(MYSQLI_BOTH);
			$section_name = $query_data['menu_sets_name'];
	
	
		If ( $subsection == 'Menu set' or $subsection == 'Menu disk (multiple)' )
		{
			$subsection_name = $section_name;
		}
		
		if ( $subsection == 'Crew' )
		{
			// get the name of the crew
			$query_crew = "SELECT crew_name FROM crew WHERE crew_id = '$subsection_id'";
			$result = $mysqli->query($query_crew) or die("getting crew name failed");
			$query_data = $result->fetch_array(MYSQLI_BOTH);
			$subsection_name = $query_data['crew_name'];
		}
		
		if ( $subsection == 'Individual' )
		{
			// get the name of the crew
			$query_ind = "SELECT ind_name FROM individuals WHERE ind_id = '$subsection_id'";
			$result = $mysqli->query($query_ind) or die("getting individual name failed");
			$query_data = $result->fetch_array(MYSQLI_BOTH);
			$subsection_name = $query_data['ind_name'];
		}
		
		If ( $subsection == 'Menu type' )
		{
			// get the name of the menu type
			$query_menu_type = "SELECT menu_types_text FROM menu_types_main WHERE menu_types_main_id = '$subsection_id'";
			$result = $mysqli->query($query_menu_type) or die("getting menu type name failed");
			$query_data = $result->fetch_array(MYSQLI_BOTH);
			$subsection_name = $query_data['menu_types_text'];
		}
		
		If ( $subsection == 'Menu disk' )
		{
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
				
			$result_menus= $mysqli->query($sql_menus) or die ("error in query disk name");
			
			while ( $row=$result_menus->fetch_array(MYSQLI_BOTH) ) 
			{  
				// Create Menu disk name
				$menu_disk_name = "$row[menu_sets_name] ";
				if(isset($row['menu_disk_number'])) {$menu_disk_name .= "$row[menu_disk_number]";}
				if(isset($row['menu_disk_letter'])) {$menu_disk_name .= "$row[menu_disk_letter]";}
				if(isset($row['menu_disk_part'])) 
				{
					if (is_numeric($row['menu_disk_part']))
						{$menu_disk_name .= " part $row[menu_disk_part]";}
						else 
						{
							$menu_disk_name .= "$row[menu_disk_part]";
						}
				}
			}
			$subsection_name = $menu_disk_name;
		}
	}
	
	//	Everything we do for the CREW SECTION	
	If ( $section == 'Crew' )
	{
		// get the name of the crew
		$query_crew = "SELECT crew_name FROM crew WHERE crew_id = '$section_id'";
		$result = $mysqli->query($query_crew) or die("getting crew name failed");
		$query_data = $result->fetch_array(MYSQLI_BOTH);
		$section_name = $query_data['crew_name'];
		
		If ( $subsection == 'Crew' or $subsection == 'Logo')
		{
			$subsection_name = $section_name;
		}
		
		If ( $subsection == 'Subcrew' )
		{
			if ($action == 'Delete')
			{
				// get the id's
				$query_crew = "SELECT * FROM sub_crew WHERE sub_crew_id = '$subsection_id'";
				$result = $mysqli->query($query_crew) or die("getting crew ids failed");
				$query_data = $result->fetch_array(MYSQLI_BOTH);
				$subsection_id = $query_data['crew_id'];
				$section_id = $query_data['parent_id'];
				
				// get the name of the crew
				$query_crew = "SELECT crew_name FROM crew WHERE crew_id = '$section_id'";
				$result = $mysqli->query($query_crew) or die("getting crew name failed");
				$query_data = $result->fetch_array(MYSQLI_BOTH);
				$section_name = $query_data['crew_name'];	
			}
	
			// get the name of the subcrew
			$query_crew = "SELECT crew_name FROM crew WHERE crew_id = '$subsection_id'";
			$result = $mysqli->query($query_crew) or die("getting crew name failed");
			$query_data = $result->fetch_array(MYSQLI_BOTH);
			$subsection_name = $query_data['crew_name'];
		}
		
		If ( $subsection == 'Member' )
		{
			if ($action == 'Delete')
			{
				// get the id's
				$query_crew = "SELECT * FROM crew_individual WHERE crew_individual_id = '$subsection_id'";
				$result = $mysqli->query($query_crew) or die("getting crew ids failed");
				$query_data = $result->fetch_array(MYSQLI_BOTH);
				$subsection_id = $query_data['ind_id'];
				$section_id = $query_data['crew_id'];
				
				// get the name of the crew
				$query_crew = "SELECT crew_name FROM crew WHERE crew_id = '$section_id'";
				$result = $mysqli->query($query_crew) or die("getting crew name failed");
				$query_data = $result->fetch_array(MYSQLI_BOTH);
				$section_name = $query_data['crew_name'];		
			}
			
			$query_ind = "SELECT ind_name FROM individuals WHERE ind_id = '$subsection_id'";
			$result = $mysqli->query($query_ind) or die("getting ind name failed");
			$query_data = $result->fetch_array(MYSQLI_BOTH);
			$subsection_name = $query_data['ind_name'];
		}
		
		If ( $subsection == 'Nickname' )
		{
			// get the id's
			$query_crew = "SELECT * FROM crew_individual WHERE crew_individual_id = '$subsection_id'";
			$result = $mysqli->query($query_crew) or die("getting crew ids failed");
			$query_data = $result->fetch_array(MYSQLI_BOTH);
			$subsection_id = $query_data['ind_id'];
			$section_id = $query_data['crew_id'];
			
			// get the name of the crew
			$query_crew = "SELECT crew_name FROM crew WHERE crew_id = '$section_id'";
			$result = $mysqli->query($query_crew) or die("getting crew name failed");
			$query_data = $result->fetch_array(MYSQLI_BOTH);
			$section_name = $query_data['crew_name'];	
			
			// get the name of the member
			$query_ind = "SELECT ind_name FROM individuals WHERE ind_id = '$subsection_id'";
			$result = $mysqli->query($query_ind) or die("getting ind name failed");
			$query_data = $result->fetch_array(MYSQLI_BOTH);
			$subsection_name = $query_data['ind_name'];
		}
	}
	
	//	Everything we do for the MENU TYPE SECTION	
	If ( $section == 'Menu type' )
	{
		// get the name of the menu type
		$query_menu_type = "SELECT menu_types_text FROM menu_types_main WHERE menu_types_main_id = '$section_id'";
		$result = $mysqli->query($query_menu_type) or die("getting menu type name failed");
		$query_data = $result->fetch_array(MYSQLI_BOTH);
		$section_name = $query_data['menu_types_text'];
		
		If ( $subsection == 'Menu type' )
		{
			$subsection_name = $section_name;
		}
	}
	
	//	Everything we do for the MENU DISK	
	If ( $section == 'Menu disk' )
	{
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
			
		$result_menus= $mysqli->query($sql_menus) or die ("error in query disk name");
		
		while ( $row=$result_menus->fetch_array(MYSQLI_BOTH) ) 
		{  
			$section_id = $row['menu_sets_id'];
									
			// Create Menu disk name
			$menu_disk_name = "$row[menu_sets_name] ";
			if(isset($row['menu_disk_number'])) {$menu_disk_name .= "$row[menu_disk_number]";}
			if(isset($row['menu_disk_letter'])) {$menu_disk_name .= "$row[menu_disk_letter]";}
			if(isset($row['menu_disk_part'])) 
			{
				if (is_numeric($row['menu_disk_part']))
					{$menu_disk_name .= " part $row[menu_disk_part]";}
					else 
					{
						$menu_disk_name .= "$row[menu_disk_part]";
					}
			}
		}
		
		$section_name = $menu_disk_name;
		
		If ( $subsection == 'State' )
		{
			// get the name of the menu type
			$query_menu_state = "SELECT menu_state FROM menu_disk_state WHERE state_id = '$subsection_id'";
			$result = $mysqli->query($query_menu_state) or die("getting menu state name failed");
			$query_data = $result->fetch_array(MYSQLI_BOTH);
			$subsection_name = $query_data['menu_state'];
		}
		
		If ( $subsection == 'Parent' )
		{
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
				
			$result_menus= $mysqli->query($sql_menus) or die ("error in query disk name");
			
			while ( $row=$result_menus->fetch_array(MYSQLI_BOTH) ) 
			{  
				// Create Menu disk name
				$menu_disk_name = "$row[menu_sets_name] ";
				if(isset($row['menu_disk_number'])) {$menu_disk_name .= "$row[menu_disk_number]";}
				if(isset($row['menu_disk_letter'])) {$menu_disk_name .= "$row[menu_disk_letter]";}
				if(isset($row['menu_disk_part'])) 
				{
					if (is_numeric($row['menu_disk_part']))
						{$menu_disk_name .= " part $row[menu_disk_part]";}
						else 
						{
							$menu_disk_name .= "$row[menu_disk_part]";
						}
				}
			}
		$subsection_name = $menu_disk_name;
		}
		
		If ( $subsection == 'Year')
		{
			$subsection_name = $subsection_id;
		}
		
		If ( $subsection == 'Menu disk' or $subsection == 'Screenshots'  or $subsection == 'File' )
		{
			$subsection_name = $section_name ;
		}
		
		If ( $subsection == 'Credits')
		{
			if ($action == 'Delete')
			{
				//get the ind id
				$query_ind = "SELECT ind_id FROM menu_disk_credits WHERE menu_disk_credits_id = '$subsection_id'";
				$result = $mysqli->query($query_ind) or die("getting individual name failed");
				$query_data = $result->fetch_array(MYSQLI_BOTH);
				$subsection_id = $query_data['ind_id'];
			}
			
			// get the name of the individual
			$query_ind = "SELECT ind_name FROM individuals WHERE ind_id = '$subsection_id'";
			$result = $mysqli->query($query_ind) or die("getting individual name failed");
			$query_data = $result->fetch_array(MYSQLI_BOTH);
			$subsection_name = $query_data['ind_name'];
		}
		
		If ( $subsection == 'Nickname')
		{
			// get the individual id
			$query_ind = "SELECT ind_id FROM menu_disk_credits WHERE individual_nicks_id = '$subsection_id'";
			$result = $mysqli->query($query_ind) or die("getting individual name failed");
			$query_data = $result->fetch_array(MYSQLI_BOTH);
			$ind_id = $query_data['ind_id'];
			
			//now get the individual name
			$query_ind = "SELECT ind_name FROM individuals WHERE ind_id = '$ind_id'";
			$result = $mysqli->query($query_ind) or die("getting individual name failed");
			$query_data = $result->fetch_array(MYSQLI_BOTH);
			$subsection_name = $query_data['ind_name'];
		}
		
		If ( $subsection == 'Game')
		{
			//  get the game name
			$query_game = "SELECT game_name FROM game WHERE game_id = '$subsection_id'";
			$result = $mysqli->query($query_game) or die("getting game name failed");
			$query_data = $result->fetch_array(MYSQLI_BOTH);
			$subsection_name = $query_data['game_name'];
		}
		
		If ( $subsection == 'Demo')
		{
			//  get the demo name
			$query_demo = "SELECT demo_name FROM demo WHERE demo_id = '$subsection_id'";
			$result = $mysqli->query($query_demo) or die("getting demo name failed");
			$query_data = $result->fetch_array(MYSQLI_BOTH);
			$subsection_name = $query_data['demo_name'];
		}
		
		If ( $subsection == 'Tool')
		{
			//  get the tool name
			$query_tool = "SELECT tools_name FROM tools WHERE tools_id = '$subsection_id'";
			$result = $mysqli->query($query_tool) or die("getting tool name failed");
			$query_data = $result->fetch_array(MYSQLI_BOTH);
			$subsection_name = $query_data['tools_name'];
		}
		
		If ( $subsection == 'Software' or $subsection == 'Chain')
		{
			//get the type of software
			$query_soft = "SELECT menu_types_main_id FROM menu_disk_title WHERE menu_disk_title_id = '$subsection_id'";
			$result = $mysqli->query($query_soft) or die("getting menu_type failed");
			$query_data = $result->fetch_array(MYSQLI_BOTH);
			$type = $query_data['menu_types_main_id'];
			
			//get the name of the software
			if ($type == '1')
			{
				//get the id of the game
				$query_game = "SELECT game_id FROM menu_disk_title_game WHERE menu_disk_title_id = '$subsection_id'";
				$result = $mysqli->query($query_game) or die("getting game id failed");
				$query_data = $result->fetch_array(MYSQLI_BOTH);
				$subsection_id = $query_data['game_id'];
				
				//  get the game name
				$query_game = "SELECT game_name FROM game WHERE game_id = '$subsection_id'";
				$result = $mysqli->query($query_game) or die("getting game name failed");
				$query_data = $result->fetch_array(MYSQLI_BOTH);
				$subsection_name = $query_data['game_name'];
				if ($subsection <> 'Chain')
				{
					$subsection = 'Game';
				}
			}	
			
			if ($type == '2')
			{
				//get the id of the demo
				$query_demo = "SELECT demo_id FROM menu_disk_title_demo WHERE menu_disk_title_id = '$subsection_id'";
				$result = $mysqli->query($query_demo) or die("getting demo id failed");
				$query_data = $result->fetch_array(MYSQLI_BOTH);
				$subsection_id = $query_data['demo_id'];
				
				//  get the demo name
				$query_demo = "SELECT demo_name FROM demo WHERE demo_id = '$subsection_id'";
				$result = $mysqli->query($query_demo) or die("getting demo name failed");
				$query_data = $result->fetch_array(MYSQLI_BOTH);
				$subsection_name = $query_data['demo_name'];
				if ($subsection <> 'Chain')
				{
					$subsection = 'Demo';
				}
			}	
			
			if ($type == '3')
			{
				//get the id of the tool
				$query_tool = "SELECT tools_id FROM menu_disk_title_tools WHERE menu_disk_title_id = '$subsection_id'";
				$result = $mysqli->query($query_tool) or die("getting toold id failed");
				$query_data = $result->fetch_array(MYSQLI_BOTH);
				$subsection_id = $query_data['tools_id'];
				
				//  get the tool name
				$query_tool = "SELECT tools_name FROM tools WHERE tools_id = '$subsection_id'";
				$result = $mysqli->query($query_tool) or die("getting tool name failed");
				$query_data = $result->fetch_array(MYSQLI_BOTH);
				$subsection_name = $query_data['tools_name'];
				if ($subsection <> 'Chain')
				{
					$subsection = 'Tool';
				}
			}	
		}	
	}
	
	//	Everything we do for the Articles section			
	If ( $section == 'Articles' )
	{	
		if ( $subsection == 'Article' )
		{
			If ( $action == 'Update' or $action == 'Delete' or $action == 'Insert')
			{
				//we need to get the title
				$query_title = "SELECT article_title FROM article_text WHERE article_id = '$section_id'";
				$result = $mysqli->query($query_title) or die("getting title failed");
				$query_data = $result->fetch_array(MYSQLI_BOTH);
				$section_name = $query_data['article_title'];	
			}
		}
		
		if ( $subsection == 'Screenshots' )
		{
			If ( $action == 'Insert' OR $action == 'Delete')
			{
				//we need to get the title
				$query_title = "SELECT article_title FROM article_text WHERE article_id = '$section_id'";
				$result = $mysqli->query($query_title) or die("getting title failed");
				$query_data = $result->fetch_array(MYSQLI_BOTH);
				$section_name = $query_data['article_title'];		
			}
		}
		
		if ( $subsection == 'Article' or $subsection == 'Screenshots' )
		{
			$subsection_name = $section_name;
		} 
	}
	
	echo $section;
	
	$sql_log = $mysqli->query("INSERT INTO change_log (section, section_id, section_name, sub_section, sub_section_id, sub_section_name, user_id, action, timestamp) VALUES ('$section', '$section_id', '$section_name', '$subsection', '$subsection_id', '$subsection_name', '$user_id', '$action', '$log_time')") 
								or die ("Couldn't insert change log into database");  
}
?>

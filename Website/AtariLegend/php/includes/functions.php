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
$alcode = preg_replace("#\[hotspot\](.*)\[\/hotspot\]#Ui", "<a name=\"$1\">$1</a>", $alcode);
$alcode = str_replace("[quote]", "<blockquote><span class=\"12px\">quote:</span><hr>", $alcode);
$alcode = str_replace("[/quote]", "<hr></blockquote>", $alcode);
$alcode = str_replace("[code]","<blockquote><pre>",$alcode);
$alcode = str_replace("[/code]","</pre></blockquote>",$alcode);
$alcode = preg_replace("#\[url\](www\..+)\[\/url\]#i", "[url=http://$1]$1[/url]", $alcode);
$alcode = preg_replace("#\[url\=(www\..+)\](.*)\[\/url\]#i", "[url=http://$1]$2[/url]", $alcode);
$alcode = preg_replace("#\[url\=(.*)\](.*)\[\/url\]#Ui", "<a href=\"$1\" class=\"standard_tile_link\">$2</a>", $alcode);
$alcode = preg_replace("#\[url\](.*)\[\/url\]#Ui", "<a href=\"$1\" class=\"standard_tile_link\">$1</a>", $alcode);
$alcode = preg_replace("#\[hotspotUrl\](.*)\[\/hotspotUrl\]#Ui", "<a href=\"$1\" class=\"standard_tile_link\">$1</a>", $alcode);
$alcode = preg_replace("#(^|[\n ])([\w]+?://.*?[^ \"\n\r\t<]*)#is", "\\1<a href=\"\\2\" target=\"_blank\" class=\"standard_tile_link\">\\2</a>", $alcode);
$alcode = preg_replace("#(^|[\n ])((www|ftp)\.[\w\-]+\.[\w\-.\~]+(?:/[^ \"\t\n\r<]*)?)#is", "\\1<a href=\"http://\\2\" target=\"_blank\" class=\"standard_tile_link\">\\2</a>", $alcode);

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
            $Text = preg_replace("/\[url\]([$URLSearchString]*)\[\/url\]/", '<a href="$1" target="_blank" class="standard_tile_link">$1</a>', $Text);
            $Text = preg_replace("(\[url\=([$URLSearchString]*)\](.+?)\[/url\])", '<a href="$1" target="_blank" class="standard_tile_link">$2</a>', $Text);
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
	
function convert_timestamp_rss($timestamp)
	{
		$timestamp = date("r",$timestamp);
		return $timestamp;
	} 
	
function get_username_from_id($submitted)
	{
					$query = "SELECT username FROM users WHERE user_id = '$submitted'";
					$result = mysql_query($query) or die("Query failed");
					if(mysql_num_rows($result) == 0) return 0;
					else
					{
						$query_data = mysql_fetch_array($result);
					return $query_data[username];
					}
	}

function get_user_id_from_name($submitted)
	{
					$query = "SELECT user_id FROM users WHERE userid = '$submitted'";
					$result = mysql_query($query) or die("Query failed");
					if(mysql_num_rows($result) == 0) return 0;
					else
					{
						$query_data = mysql_fetch_array($result);
					return $query_data[user_id];
					}
	}
	
function get_rows ($result)
	{
		$num=mysql_num_rows($result);
		return $num;
	}

	
function maketree($rootcatid,$sql,$maxlevel)
{
// $sql is the sql statement which fetches the data
// you MUST keep this order:
// 1) the category ID, 2) the parent category ID, 3) the name of the category
         $result=mysql_query($sql);
		 
                 while(list($catid,$parcat,$name)=mysql_fetch_array($result)){
                 $table[$parcat][$catid]=$name; // array $table get 2 keys both with value $name

                 };

         $result=makebranch($rootcatid,$table,0,$maxlevel);

         RETURN $result;
}

function makebranch($parcat,$table,$level,$maxlevel)
{
	global $branche_info;
	global $tree;

	$list=$table[$parcat];
    asort($list); // here we do the sorting
    while(list($key,$val)=each($list))
	{
		// do the indent
        if ($level=="0")
		{
        	$branche_info[cat_width]="0";
        }
		else
		{
            $width=($level+1)*10;
            $branche_info[cat_width] = $width;
        };
        // the resulting HTML - feel free to change it
        // $level is optional
	
		$website = mysql_query ("SELECT count(*) FROM website_category_cross WHERE website_category_id='$key'");
	
		$branche_info[cat_links] = mysql_result($website,0,0);
		$branche_info[cat_name] = $val;
		$branche_info[cat_id] = $key;
		$tree[info][] = $branche_info;
		
		// ask if case to query if the category in this "cycle" has a subcategory, if it has execute makebranch2
		if ((isset($table[$key])) AND (($maxlevel>$level+1) OR ($maxlevel=="0")))
  	    {
 	    	makebranch($key,$table,$level+1,$maxlevel);
        };
    };
}


function date_selector($inName, $useDate=0) 
    { 
        //create array so we can name months 
        $monthName = array(1=> "January",  "February",  "March", 
            "April",  "May",  "June",  "July",  "August", 
            "September",  "October",  "November",  "December"); 

        //if date invalid or not supplied, use current time 
        if($useDate == 0) 
        { 
            $useDate = Time(); 
        } 

        /* 
        ** make month selector 
        */ 
        print("<select name=" . $inName .  "Month>\n"); 
        for($currentMonth = 1; $currentMonth <= 12; $currentMonth++) 
        { 
            print("<option value=\""); 
            print(intval($currentMonth)); 
            print("\""); 
            if(intval(date( "m", $useDate))==$currentMonth) 
            { 
                print(" selected"); 
            } 
            print(">" . $monthName[$currentMonth] .  "\n"); 
        } 
        print("</select>"); 


        /* 
        ** make day selector 
        */ 
        print("<select name=" . $inName .  "Day>\n"); 
        for($currentDay=1; $currentDay <= 31; $currentDay++) 
        { 
            print("<option value=\"$currentDay\""); 
            if(intval(date( "d", $useDate))==$currentDay) 
            { 
                print(" selected"); 
            } 
            print(">$currentDay\n"); 
        } 
        print("</select>"); 


        /* 
        ** make year selector 
        */ 
        print("<select name=" . $inName .  "Year>\n"); 
        $startYear = date( "Y", $useDate); 
        for($currentYear = $startYear - 5; $currentYear <= $startYear+5;$currentYear++) 
        { 
            print("<option value=\"$currentYear\""); 
            if(date( "Y", $useDate)==$currentYear) 
            { 
                print(" selected"); 
            } 
            print(">$currentYear\n"); 
        } 
        print("</select>"); 
		
		
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
?>

<?php
/***************************************************************************
*                              functions_search.php
*                              -------------------
*     begin                : Wed Sep 05 2001
*     copyright            : (C) 2002 The phpBB Group
*     email                : support@phpbb.com
*
*     $Id: functions_search.php,v 1.8.2.16 2003/06/30 17:18:37 acydburn Exp $
*
****************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

function clean_words($mode, &$entry)
{
	static $drop_char_match =   array('^', '$', '&', '(', ')', '<', '>', '`', '\'', '"', '|', ',', '@', '_', '?', '%', '-', '~', '+', '.', '[', ']', '{', '}', ':', '\\', '/', '=', '#', '\'', ';', '!');
	static $drop_char_replace = array(' ', ' ', ' ', ' ', ' ', ' ', ' ', '',  '',   ' ', ' ', ' ', ' ', '',  ' ', ' ', '',  ' ',  ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ' , ' ', ' ', ' ', ' ',  ' ', ' ');

	$entry = ' ' . strip_tags(strtolower($entry)) . ' ';

	if ( $mode == 'post' )
	{
		// Replace line endings by a space
		$entry = preg_replace('/[\n\r]/is', ' ', $entry); 
		// HTML entities like &nbsp;
		$entry = preg_replace('/\b&[a-z]+;\b/', ' ', $entry); 
		// Remove URL's
		$entry = preg_replace('/\b[a-z0-9]+:\/\/[a-z0-9\.\-]+(\/[a-z0-9\?\.%_\-\+=&\/]+)?/', ' ', $entry); 
		// Quickly remove BBcode.
		$entry = preg_replace('/\[img:[a-z0-9]{10,}\].*?\[\/img:[a-z0-9]{10,}\]/', ' ', $entry); 
		$entry = preg_replace('/\[\/?url(=.*?)?\]/', ' ', $entry);
		$entry = preg_replace('/\[\/?[a-z\*=\+\-]+(\:?[0-9a-z]+)?:[a-z0-9]{10,}(\:[a-z0-9]+)?=?.*?\]/', ' ', $entry);
	}

	//
	// Filter out strange characters like ^, $, &, change "it's" to "its"
	//
	for($i = 0; $i < count($drop_char_match); $i++)
	{
		$entry =  str_replace($drop_char_match[$i], $drop_char_replace[$i], $entry);
	}

	if ( $mode == 'post' )
	{
		$entry = str_replace('*', ' ', $entry);

		// 'words' that consist of <3 or >20 characters are removed.
		$entry = preg_replace('/[ ]([\S]{1,2}|[\S]{21,})[ ]/',' ', $entry);
	}

	return $entry;
}

function split_words(&$entry, $mode = 'post')
{
	return explode(' ', trim(preg_replace('#\s+#', ' ', $entry)));
}

function add_search_words($mode, $post_id, $post_text, $post_title = '')
{

	$search_raw_words = array();
	$search_raw_words['text'] = split_words(clean_words('post', $post_text));
	$search_raw_words['title'] = split_words(clean_words('post', $post_title));

	@set_time_limit(0);

	$word = array();
	$word_insert_sql = array();
	while ( list($word_in, $search_matches) = @each($search_raw_words) )
	{
		$word_insert_sql[$word_in] = '';
		if ( !empty($search_matches) )
		{
			for ($i = 0; $i < count($search_matches); $i++)
			{ 
				$search_matches[$i] = trim($search_matches[$i]);

				if( $search_matches[$i] != '' ) 
				{
					$word[] = $search_matches[$i];
					if ( !strstr($word_insert_sql[$word_in], "'" . $search_matches[$i] . "'") )
					{
						$word_insert_sql[$word_in] .= ( $word_insert_sql[$word_in] != "" ) ? ", '" . $search_matches[$i] . "'" : "'" . $search_matches[$i] . "'";
					}
				} 
			}
		}
	}

	if ( count($word) )
	{
		sort($word);

		$prev_word = '';
		$word_text_sql = '';
		$temp_word = array();
		for($i = 0; $i < count($word); $i++)
		{
			if ( $word[$i] != $prev_word )
			{
				$temp_word[] = $word[$i];
				$word_text_sql .= ( ( $word_text_sql != '' ) ? ', ' : '' ) . "'" . $word[$i] . "'";
			}
			$prev_word = $word[$i];
		}
		$word = $temp_word;

		$check_words = array();

		$value_sql = '';
		$match_word = array();
		for ($i = 0; $i < count($word); $i++)
		{ 
			$new_match = true;
			if ( isset($check_words[$word[$i]]) )
			{
				$new_match = false;
			}

			if ( $new_match )
			{
						$value_sql .= ( ( $value_sql != '' ) ? ', ' : '' ) . '(\'' . $word[$i] . '\')';
			}
		}

		if ( $value_sql != '' )
		{
				 	$sql = "INSERT IGNORE INTO news_search_wordlist (news_word_text) 
						VALUES $value_sql"; 

			if ( !$mysqli->query($sql) )
			{
				die ("Could not insert new word");
			} 
			
			
		}
	}

	while( list($word_in, $match_sql) = @each($word_insert_sql) )
	{
		$title_match = ( $word_in == 'title' ) ? 1 : 0;

		if ( $match_sql != '' )
		{
			$sql = "INSERT IGNORE INTO news_search_wordmatch (news_id, news_word_id, news_title_match) 
				SELECT $post_id, news_word_id, $title_match  
					FROM news_search_wordlist 
					WHERE news_word_text IN ($match_sql)"; 
			if ( !$mysqli->query($sql) )
			{
				die ("Could not insert new word2");
			}
			
			
		}
	}

	return;
}


function remove_search_post($post_id_sql)
{

	$words_removed = false;

			$sql = "SELECT news_word_id 
				FROM news_search_wordmatch 
				WHERE news_id IN ($post_id_sql) 
				GROUP BY news_word_id";
			if ( $result = $mysqli->query($sql) )
			{
				$word_id_sql = '';
				while ( $row = $result->fetch_array(MYSQLI_BOTH) )
				{
					$word_id_sql .= ( $word_id_sql != '' ) ? ', ' . $row['news_word_id'] : $row['news_word_id']; 
				}

				$sql = "SELECT news_word_id 
					FROM news_search_wordmatch 
					WHERE news_word_id IN ($word_id_sql) 
					GROUP BY news_word_id 
					HAVING COUNT(news_word_id) = 1";
				if ( $result = $mysqli->query($sql) )
				{
					$word_id_sql = '';
					while ( $row = $result->fetch_array(MYSQLI_BOTH) )
					{
						$word_id_sql .= ( $word_id_sql != '' ) ? ', ' . $row['news_word_id'] : $row['news_word_id']; 
					}

					if ( $word_id_sql != '' )
					{
						$sql = "DELETE FROM news_search_wordlist 
							WHERE news_word_id IN ($word_id_sql)";
						if ( !$mysqli->query($sql) )
						{
							die("Could not delete word list entry");
						}

						$words_removed = $mysqli->affected_rows;
					}
				}
			}


	$sql = "DELETE FROM news_search_wordmatch  
		WHERE news_id IN ($post_id_sql)";
	if ( !$mysqli->query($sql) )
	{
		die("Error in deleting post");
	}

	return $words_removed;
}


?>

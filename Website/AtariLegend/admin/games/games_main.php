<?
/***************************************************************************
*                                games_main.php
*                            --------------------------
*   begin                : Sunday, August 28, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : admin@atarilegend.com
*
*   Id: games_main.php,v 0.10 2005/08/28 17:30 Gatekeeper
*
***************************************************************************/

/*
***********************************************************************************
This is the game browse page where you can navigate your way through the games db
***********************************************************************************
*/

//load all common functions
include("../includes/common.php"); 

date_default_timezone_set('UTC');
$start = microtime(true);

if (empty($action)) {$action='';}
/*
***********************************************************************************
Firstly , we are gonna check which parts of the search functions are used in the main
screen and we're gonna fill some extra variables accordingly. These variables will be
used to create the querystring later.
***********************************************************************************
*/

	if (isset($action) and $action == "insert" )
	{
		//Insert the game in the game table
		$sql_game = mysql_query("INSERT INTO game (game_name) VALUES ('$newgame')") or die ("Couldn't insert game into database");  

		$message = "Game has been inserted into the database";
		$smarty->assign("message",$message);
		
		//Get the companies to fill the search fields
		$sql_company = mysql_query("SELECT * FROM pub_dev ORDER BY pub_dev_name ASC")
			    	   or die ("Couldn't query Publisher and Developer database");
		
		while  ($company=mysql_fetch_array($sql_company)) 
		{  
			$smarty->append('company',
	    		 array('comp_id' => $company['pub_dev_id'],
				 	   'comp_name' => $company['pub_dev_name']));
		}

		$smarty->assign("user_id",$_SESSION['user_id']);
		$smarty->assign('games_main_tpl', '1');

		//Send all smarty variables to the templates
		$smarty->display('file:../templates/0/index.tpl');
	}
	elseif (isset($action) and $action == "search" )
	{		
		//check the $gamebrowse select
		if (empty($gamebrowse) or $gamebrowse == '-')
		{
			$gamebrowse_select = "game_name LIKE '%'";
			$akabrowse_select = "game_name LIKE '%'";
		}
		elseif ($gamebrowse == 'num')
		{
			$gamebrowse_select = "game_name REGEXP '^[0-9].*'";
			$akabrowse_select = "game_aka.aka_name REGEXP '^[0-9].*'";
		}
		else
		{
			$gamebrowse_select = "game_name LIKE '$gamebrowse%'";
			$akabrowse_select = "game_aka.aka_name LIKE '$gamebrowse%'";
		}
		
		//check the publisher select
		if (empty($publisher) or $publisher == '-')
		{
			$publisher_select = "";
		}
		elseif ($publisher == "null")
		{
			$publisher_select = " AND pd1.pub_dev_id IS NULL";
		}
		else
		{
			$publisher_select = " AND pd1.pub_dev_id = $publisher";
		}

		//check the developer select
		if (empty($developer) or $developer == '-')
		{
			$developer_select = "";
		}
		elseif ($developer == "null")
		{
			$developer_select = " AND pd2.pub_dev_id IS NULL";
		}
		else
		{
			$developer_select = " AND pd2.pub_dev_id = $developer";
		}
		
		//check to see if the year has been clicked
		if (isset($year))
		{
			$year_select = " AND game_year.game_year LIKE '$year%'";
		}
		
		//
		// Here comes a bunch of tickbox checks.
		//
		
		if (isset($falcon_only) and $falcon_only == "1")
		{
			$falcon_only_select = " AND game_falcon_only.falcon_only =$falcon_only";
			$smarty->assign('games_falcon_only', '1');
		}
		
		if (isset($falcon_enhanced) and $falcon_enhanced == "1")
		{
			$falcon_enhanced_select = " AND game_falcon_enhan.falcon_enhanced =$falcon_enhanced";
			$smarty->assign('games_falcon_enhanced', '1');
		}
		
		if (isset($ste_only) and $ste_only == "1")
		{
			$ste_only_select = " AND game_ste_only.ste_only =$ste_only";
			$smarty->assign('games_ste_only', '1');
		}
		
		if (isset($ste_enhanced) and $ste_enhanced == "1")
		{
			$ste_enhanced_select = " AND game_ste_enhan.ste_enhanced =$ste_enhanced";
			$smarty->assign('games_ste_enhanced', '1');
		}
		
		if (isset($free) and $free == "1")
		{
			$free_select = " AND game_free.free =$free";
			$smarty->assign('games_free', '1');
		}
		
		if (isset($arcade) and $arcade == "1")
		{
			$arcade_select = " AND game_arcade.arcade =$arcade";
			$smarty->assign('games_arcade', '1');
		}
		
		if (isset($development) and $development == "1")
		{
			$development_select = " AND game_development.development =$development";
			$smarty->assign('games_development', '1');
		}
		
		if (isset($unreleased) and $unreleased == "1")
		{
			$unreleased_select = " AND game_unreleased.unreleased =$unreleased";
		}
		
		if (isset($unfinished) and $unfinished == "1")
		{
			$unfinished_select = " AND game_unfinished.unfinished =$unfinished";
		}
		
		if (isset($monochrome) and $monochrome == "1")
		{
			$monochrome_select = " AND game_mono.monochrome =$monochrome";
		}
		
		if (isset($seuck) and $seuck == "1")
		{
			$seuck_select = " AND game_seuck.seuck =$seuck";
		}
		
		if (isset($stos) and $stos == "1")
		{
			$stos_select = " AND game_stos.stos =$stos";
		}
		
		if (isset($stac) and $stac == "1")
		{
			$stac_select = " AND game_stac.stac =$stac";
		}
		
		if (isset($wanted) and $wanted == "1")
		{
			$wanted_select = " AND game_wanted.game_id IS NOT NULL";
		}
		
		//Before we start the build the query, we check if there is at least
		//one search field filled in or used! 
		
		if ( $publisher_select == "-" and $gamebrowse_select == ""  and 
			 $gamesearch == "" and $developer_select  == "-" and empty($year_select) and empty($falcon_only_select) and empty($falcon_enhanced_select) 
			 and empty($ste_only_select) and empty($ste_enhanced_select) 
			 and $unreleased_select =="" and $development_select == "" and $arcade_select == "" and $wanted_select == "")
		{
			$message = "Please fill in one of the fields";
			$smarty->assign("message",$message);
			
			//Get the companies to fill the search fields
			$sql_company = mysql_query("SELECT * FROM pub_dev ORDER BY pub_dev_name ASC")
			    		   or die ("Couldn't query Publisher and Developer database");
		
			while  ($company=mysql_fetch_array($sql_company)) 
			{  
				$smarty->append('company',
	    			 array('comp_id' => $company['pub_dev_id'],
					 	   'comp_name' => $company['pub_dev_name']));
			}	
		
			$smarty->assign("user_id",$_SESSION['user_id']);
			
			$smarty->assign('games_main_tpl', '1');

			//Send all smarty variables to the templates
			$smarty->display('file:../templates/0/index.tpl');
				
		}
		else
		{
/*
***********************************************************************************
Now we're gonna start building the querystring. First we'll be checking of we are 
searching on a publisher only, a developer only, or if we are using a combination 
of search features. If we are searching for a pub or dev only, we create a different
querystring for faster output
*********************************************************************************** 
*/
		
		$RESULTGAME = "SELECT  game.game_id,
							   game.game_name,
							   game_boxscan.game_boxscan_id,
							   screenshot_game.screenshot_id,
							   game_music.music_id,
							   game_download.game_download_id,
							   game_falcon_only.falcon_only,
							   game_falcon_enhan.falcon_enhanced,
							   game_ste_enhan.ste_enhanced,
							   game_ste_only.ste_only,

							   
							   pd1.pub_dev_name as 'publisher_name',
						 	   pd1.pub_dev_id as 'publisher_id',
						  	   pd2.pub_dev_name as 'developer_name',
						   	   pd2.pub_dev_id as 'developer_id',
							   game_year.game_year
					   FROM game
					   LEFT JOIN game_boxscan ON (game_boxscan.game_id = game.game_id)
					   LEFT JOIN screenshot_game ON (screenshot_game.game_id = game.game_id)
					   LEFT JOIN game_music ON (game_music.game_id = game.game_id)
					   LEFT JOIN game_download ON (game_download.game_id = game.game_id)
					   LEFT JOIN game_falcon_only ON (game_falcon_only.game_id = game.game_id)
					   LEFT JOIN game_falcon_enhan ON (game.game_id = game_falcon_enhan.game_id)
					   LEFT JOIN game_ste_enhan ON (game.game_id = game_ste_enhan.game_id) 
					   LEFT JOIN game_ste_only ON (game.game_id = game_ste_only.game_id)
				LEFT JOIN game_free ON (game.game_id = game_free.game_id)
				LEFT JOIN game_arcade ON (game.game_id = game_arcade.game_id)
				LEFT JOIN game_development ON (game.game_id = game_development.game_id)
				LEFT JOIN game_unreleased ON (game.game_id = game_unreleased.game_id)
				LEFT JOIN game_unfinished ON (game.game_id = game_unfinished.game_id)
				LEFT JOIN game_mono ON (game.game_id = game_mono.game_id)
				LEFT JOIN game_seuck ON (game.game_id = game_seuck.game_id)
				LEFT JOIN game_stos ON (game.game_id = game_stos.game_id)
				LEFT JOIN game_stac ON (game.game_id = game_stac.game_id)
				LEFT JOIN game_wanted ON (game.game_id = game_wanted.game_id)
					   
					   LEFT JOIN game_publisher ON (game_publisher.game_id = game.game_id) 
					   LEFT JOIN pub_dev pd1 ON (pd1.pub_dev_id = game_publisher.pub_dev_id) 
					   LEFT JOIN game_developer ON (game_developer.game_id = game.game_id) 
					   LEFT JOIN pub_dev pd2 on (pd2.pub_dev_id = game_developer.dev_pub_id) 
					   LEFT JOIN game_year on (game_year.game_id = game.game_id) 
					   WHERE ";
		
		$RESULTGAME .= $gamebrowse_select;
		if (!empty($gamesearch)) {$RESULTGAME .= "game_name LIKE '%$gamesearch%'";} 
		$RESULTGAME .= $publisher_select;
		$RESULTGAME .= $developer_select;
		if (isset($year_select)) {$RESULTGAME .= $year_select;}
		if (isset($falcon_only) and $falcon_only == "1") {$RESULTGAME .= $falcon_only_select;}
		if (isset($falcon_enhanced) and $falcon_enhanced == "1") {$RESULTGAME .= $falcon_enhanced_select;}
		if (isset($ste_only) and $ste_only == "1") {$RESULTGAME .= $ste_only_select;}
		if (isset($ste_enhanced) and $ste_enhanced == "1") {$RESULTGAME .= $ste_enhanced_select;}
		if (isset($free) and $free == "1") {$RESULTGAME .= $free_select;}
		if (isset($arcade) and $arcade == "1") {$RESULTGAME .= $arcade_select;}		
		if (isset($development) and $development == "1") {$RESULTGAME .= $development_select;}
		if (isset($unreleased) and $unreleased == "1") {$RESULTGAME .= $unreleased_select;}
		if (isset($unfinished) and $unfinished == "1") {$RESULTGAME .= $unfinished_select;}
		if (isset($monochrome) and $monochrome == "1") {$RESULTGAME .= $monochrome_select;}
		if (isset($seuck) and $seuck == "1") {$RESULTGAME .= $seuck_select;}
		if (isset($stos) and $stos == "1") {$RESULTGAME .= $stos_select;}
		if (isset($stac) and $stac == "1") {$RESULTGAME .= $stac_select;}
		if (isset($wanted) and $wanted == "1") {$RESULTGAME .= $wanted_select;}
		
		$RESULTGAME .= ' GROUP BY game.game_id, game.game_name HAVING COUNT(DISTINCT game.game_id, game.game_name) = 1';
		$RESULTGAME .= ' ORDER BY game_name ASC';
		

		$games = mysql_query($RESULTGAME);
		
		if (empty($games))		
		{
			$message = "There are problems with the game querie, please try again";
			$smarty->assign("message",$message);
			
			//Get the companies to fill the search fields
			$sql_company = mysql_query("SELECT * FROM pub_dev ORDER BY pub_dev_name ASC")
			 		   	   or die ("Couldn't query Publisher and Developer database");
		
			while  ($company=mysql_fetch_array($sql_company)) 
			{  
				$smarty->append('company',
	    			 array('comp_id' => $company['pub_dev_id'],
					 	   'comp_name' => $company['pub_dev_name']));
			}
			
			$smarty->assign("user_id",$_SESSION['user_id']);
			$smarty->assign('games_main_tpl', '1');

			//Send all smarty variables to the templates
			$smarty->display('file:../templates/0/index.tpl');
		}
		else
		{
			$rows = mysql_num_rows($games);
			if ( $rows > 0 )
			{	
				
				$RESULTAKA = "SELECT
							   game_aka.game_id,
							   game_aka.aka_name,
							   game_boxscan.game_boxscan_id,
							   screenshot_game.screenshot_id,
							   game_music.music_id,
							   game_download.game_download_id,
							   game_falcon_only.falcon_only,
							   game_falcon_enhan.falcon_enhanced,
							   game_ste_enhan.ste_enhanced,
							   game_ste_only.ste_only,
	
							   
							   pd1.pub_dev_name as 'publisher_name', 
						 	   pd1.pub_dev_id as 'publisher_id',
						  	   pd2.pub_dev_name as 'developer_name',
						   	   pd2.pub_dev_id as 'developer_id',
							   game_year.game_year
							  FROM game_aka 
							  LEFT JOIN game ON (game_aka.game_id = game.game_id)
							  LEFT JOIN game_boxscan ON (game_boxscan.game_id = game_aka.game_id)
					 		  LEFT JOIN screenshot_game ON (screenshot_game.game_id = game.game_id)
					   		  LEFT JOIN game_music ON (game_music.game_id = game.game_id)
					   		  LEFT JOIN game_download ON (game_download.game_id = game.game_id)
					 		  LEFT JOIN game_falcon_only ON (game_falcon_only.game_id = game.game_id)
							  LEFT JOIN game_falcon_enhan ON (game.game_id = game_falcon_enhan.game_id)
							  LEFT JOIN game_ste_enhan ON (game.game_id = game_ste_enhan.game_id) 
					   		  LEFT JOIN game_ste_only ON (game.game_id = game_ste_only.game_id)
					   LEFT JOIN game_free ON (game.game_id = game_free.game_id)
					   LEFT JOIN game_arcade ON (game.game_id = game_arcade.game_id)
					   LEFT JOIN game_development ON (game.game_id = game_development.game_id)
					   LEFT JOIN game_unreleased ON (game.game_id = game_unreleased.game_id)
					   LEFT JOIN game_unfinished ON (game.game_id = game_unfinished.game_id)
					   LEFT JOIN game_mono ON (game.game_id = game_mono.game_id)
					   LEFT JOIN game_seuck ON (game.game_id = game_seuck.game_id)
					   LEFT JOIN game_stos ON (game.game_id = game_stos.game_id)
					   LEFT JOIN game_stac ON (game.game_id = game_stac.game_id)
					   LEFT JOIN game_wanted ON (game.game_id = game_wanted.game_id)
					   
					   	   	  LEFT JOIN game_publisher ON (game.game_id = game_publisher.game_id)
							  LEFT JOIN pub_dev pd1 ON (game_publisher.pub_dev_id = pd1.pub_dev_id) 
					   	      LEFT JOIN game_developer ON (game.game_id = game_developer.game_id) 
					          LEFT JOIN pub_dev pd2 on (pd2.pub_dev_id = game_developer.dev_pub_id) 
							  LEFT JOIN game_year on (game_year.game_id = game.game_id) 
					   WHERE ";
				
				$RESULTAKA .= $akabrowse_select;
				if (!empty($gamesearch)) {$RESULTAKA .= "game_aka.aka_name LIKE '%$gamesearch%'";} 
				$RESULTAKA .= $publisher_select;
				$RESULTAKA .= $developer_select;
				if (isset($year_select)) {$RESULTAKA .= $year_select;}
				if (isset($falcon_only) and $falcon_only == "1") {$RESULTAKA .= $falcon_only_select;}
				if (isset($falcon_enhanced) and $falcon_enhanced == "1") {$RESULTAKA .= $falcon_enhanced_select;}
				if (isset($ste_only) and $ste_only == "1") {$RESULTAKA .= $ste_only_select;}
				if (isset($ste_enhanced) and $ste_enhanced == "1") {$RESULTAKA .= $ste_enhanced_select;}
				if (isset($free) and $free == "1") {$RESULTAKA .= $free_select;}
				if (isset($arcade) and $arcade == "1") {$RESULTAKA .= $arcade_select;}		
				if (isset($development) and $development == "1") {$RESULTAKA .= $development_select;}
				if (isset($unreleased) and $unreleased == "1") {$RESULTAKA .= $unreleased_select;}
				if (isset($unfinished) and $unfinished == "1") {$RESULTAKA .= $unfinished_select;}
				if (isset($monochrome) and $monochrome == "1") {$RESULTAKA .= $monochrome_select;}
				if (isset($seuck) and $seuck == "1") {$RESULTAKA .= $seuck_select;}
				if (isset($stos) and $stos == "1") {$RESULTAKA .= $stos_select;}
				if (isset($stac) and $stac == "1") {$RESULTAKA .= $stac_select;}
				if (isset($wanted) and $wanted == "1") {$RESULTAKA .= $wanted_select;}
				$RESULTAKA .= ' GROUP BY game_aka.game_id, game_aka.aka_name HAVING COUNT(DISTINCT game_aka.game_id, game_aka.aka_name) = 1';
				$RESULTAKA .= ' ORDER BY game_aka.aka_name ASC';


				mysql_query("CREATE TEMPORARY TABLE temp ENGINE=MEMORY $RESULTGAME") or die(mysql_error());
				mysql_query("INSERT INTO temp $RESULTAKA") or die("does not compute2");

				$temp_query = mysql_query("SELECT * FROM temp ORDER BY game_name ASC") or die("does not compute3");
				
				
				
				$i = 0;
				
				while ( $sql_game_search = mysql_fetch_assoc($temp_query) ) 
				{  
				      $i++;
					  
					  $smarty->append('game_search',
	  				  array('game_id' => $sql_game_search['game_id'],
			  				'game_name' => $sql_game_search['game_name'],
			 				'publisher_id' => $sql_game_search['publisher_id'],
			  				'publisher_name' => $sql_game_search['publisher_name'],
			  				'developer_id' => $sql_game_search['developer_id'],
			  				'developer_name' => $sql_game_search['developer_name'],
			  				//'year_id' => $sql_game_search['year_id'],
			  				'year' => $sql_game_search['game_year'],
			  				'music' => $sql_game_search['music_id'],
			  				'boxscan' => $sql_game_search['game_boxscan_id'],
			  				'download' => $sql_game_search['game_download_id'],
			  				'screenshot' => $sql_game_search['screenshot_id'],
							'falcon_only' => $sql_game_search['falcon_only'],
							'falcon_enhan' => $sql_game_search['falcon_enhanced'],
							'ste_enhanced' => $sql_game_search['ste_enhanced'],
							'ste_only' => $sql_game_search['ste_only']));
				}
				$time_elapsed_secs = microtime(true) - $start;
				$smarty->assign("nr_of_games",$i);
				$smarty->assign("query_time",$time_elapsed_secs);
				
				mysql_query("DROP TABLE temp") or die("does not compute4");
				
				//Get the companies to fill the search fields
				$sql_company = mysql_query("SELECT * FROM pub_dev ORDER BY pub_dev_name ASC")
			 		   	   or die ("Couldn't query Publisher and Developer database");
		
				while  ($company=mysql_fetch_array($sql_company)) 
				{  
				$smarty->append('company',
	    			 array('comp_id' => $company['pub_dev_id'],
					 	   'comp_name' => $company['pub_dev_name']));
				}
				
				
				$smarty->assign("user_id",$_SESSION['user_id']);
				$smarty->assign('games_list_html', '1');

				//Send all smarty variables to the templates
				$smarty->display('extends:../templates/1/main.html|../templates/1/games_list.html');



				//$smarty->display('file:../templates/1/games_list.html');
			}
			else
			{
				$message = "No entries found for your selection";
				$smarty->assign("message",$message);
				
				//Get the companies to fill the search fields
				$sql_company = mysql_query("SELECT * FROM pub_dev ORDER BY pub_dev_name ASC")
			    			   or die ("Couldn't query Publisher and Developer database");
		
				while  ($company=mysql_fetch_array($sql_company)) 
				{  
					$smarty->append('company',
	    				 array('comp_id' => $company['pub_dev_id'],
				 	 		  'comp_name' => $company['pub_dev_name']));
				}
				
				$smarty->assign("user_id",$_SESSION['user_id']);
				$smarty->assign('games_main_tpl', '1');

				//Send all smarty variables to the templates
				$smarty->display('file:../templates/0/index.tpl');
				}
			}
		}
	}
	else
	{
		//Get publisher values to fill the searchfield
		$sql_publisher = mysql_query("SELECT pub_dev.pub_dev_id,
											 pub_dev.pub_dev_name
											 FROM game_publisher
											 LEFT JOIN pub_dev ON (game_publisher.pub_dev_id = pub_dev.pub_dev_id)
											 GROUP BY pub_dev.pub_dev_id HAVING COUNT(DISTINCT pub_dev.pub_dev_id) = 1
											 ORDER BY pub_dev.pub_dev_name ASC") 
										or die("Problems retriving values from publishers.");
		
		while ($company_publisher = mysql_fetch_assoc($sql_publisher))
		{
		
			$smarty->append('company_publisher',
	    		 array('comp_id' => $company_publisher['pub_dev_id'],
				 	   'comp_name' => $company_publisher['pub_dev_name']));
		
		}
		
		//Get Developer values to fill the searchfield
		$sql_developer = mysql_query("SELECT pub_dev.pub_dev_id,
											 pub_dev.pub_dev_name
											 FROM game_developer
											 LEFT JOIN pub_dev ON (game_developer.dev_pub_id = pub_dev.pub_dev_id)
											 GROUP BY pub_dev.pub_dev_id HAVING COUNT(DISTINCT pub_dev.pub_dev_id) = 1
											 ORDER BY pub_dev.pub_dev_name ASC") 
										or die("Problems retriving values from developers.");
		
		while ($company_developer = mysql_fetch_assoc($sql_developer))
		{
		
			$smarty->append('company_developer',
	    		 array('comp_id' => $company_developer['pub_dev_id'],
				 	   'comp_name' => $company_developer['pub_dev_name']));
		
		}
		
		//get the number of games in the archive
		$query_number = mysql_query("SELECT count(*) FROM game") or die("Couldn't get the number of games");
		$v_rows = mysql_result($query_number,0,0) or die("Couldn't get the number of games");

		$smarty->assign('games_nr', $v_rows); 


		$smarty->assign("user_id",$_SESSION['user_id']);
		$smarty->assign('games_main_tpl', '1');

		//Send all smarty variables to the templates
		$smarty->display('file:../templates/0/index.tpl');
	}

//close the connection
mysql_close();
?>

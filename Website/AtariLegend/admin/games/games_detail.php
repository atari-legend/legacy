<?
/***************************************************************************
 *                                games_detail.php
 *                            ------------------------
 *   begin                : Tuesday, September 6, 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : admin@atarilegend.com
 *	 actual update        : Creation of file
 *
 *   Id: games_detail.php,v 0.10 2005/10/06 17:41 Zombieman
 *
 ***************************************************************************/

//****************************************************************************************
// This is the detail page of a game. Change all the specifics over here!
//**************************************************************************************** 

//load all common functions
include("../includes/common.php"); 

//***********************************************************************************
//Let's get the general game info first. 
//***********************************************************************************

	$sql_game = mysql_query("SELECT game_name, 
						   game.game_id, 
						   game_free.free,
						   game_development.development,
						   game_unreleased.unreleased,
						   game_ste_only.ste_only,
						   game_ste_enhan.ste_enhanced,
						   game_falcon_only.falcon_only,
						   game_falcon_enhan.falcon_enhanced,
						   game_unfinished.unfinished,
						   game_mono.monochrome,
						   game_wanted.game_wanted_id,
						   game_arcade.arcade,
						   game_seuck.seuck,
						   game_stos.stos,
						   game_stac.stac
						   FROM game 
					   	   LEFT JOIN game_free ON (game.game_id = game_free.game_id)
						   LEFT JOIN game_unreleased ON (game.game_id = game_unreleased.game_id)
						   LEFT JOIN game_development ON (game.game_id = game_development.game_id)
						   LEFT JOIN game_ste_only ON (game.game_id = game_ste_only.game_id)
						   LEFT JOIN game_ste_enhan ON (game.game_id = game_ste_enhan.game_id)
						   LEFT JOIN game_falcon_only ON (game.game_id = game_falcon_only.game_id)
						   LEFT JOIN game_falcon_enhan ON (game.game_id = game_falcon_enhan.game_id)
						   LEFT JOIN game_arcade ON (game.game_id = game_arcade.game_id)
						   LEFT JOIN game_seuck ON (game.game_id = game_seuck.game_id)
						   LEFT JOIN game_stos ON (game.game_id = game_stos.game_id)
						   LEFT JOIN game_stac ON (game.game_id = game_stac.game_id)
						   LEFT JOIN game_unfinished ON (game.game_id = game_unfinished.game_id)
						   LEFT JOIN game_mono ON (game.game_id = game_mono.game_id)
						   LEFT JOIN game_wanted ON (game.game_id = game_wanted.game_id)
					       WHERE game.game_id='$game_id'")
				    or die ("Error getting game info");

					
		while ($game_info=mysql_fetch_array($sql_game)) 
		{  
			$smarty->assign('game_info',
	    		 array('game_name' => $game_info['game_name'],
				 	   'game_id' => $game_info['game_id'],
				 	   'game_free' => $game_info['free'],
					   'game_development' => $game_info['development'],
					   'game_unreleased' => $game_info['unreleased'],
					   'game_ste_only' => $game_info['ste_only'],
					   'game_ste_enhan' => $game_info['ste_enhanced'],
					   'game_falcon_only' => $game_info['falcon_only'],
					   'game_falcon_enhan' => $game_info['falcon_enhanced'],
					   'game_unfinished' => $game_info['unfinished'],
					   'game_mono' => $game_info['monochrome'],
					   'game_wanted' => $game_info['game_wanted_id'],
					   'game_arcade' => $game_info['arcade'],
					   'game_seuck' => $game_info['seuck'],
					   'game_stos' => $game_info['stos'],
					   'game_stac' => $game_info['stac']));
		}
			
//***********************************************************************************
//get the release dates
//***********************************************************************************

	$sql_year = mysql_query("SELECT * FROM game_year 
							 LEFT JOIN game_extra_info ON ( game_year.game_extra_info_id = game_extra_info.game_extra_info_id )
							 WHERE game_id='$game_id'")
				or die ("Error loading year");
						  
	while ($year=mysql_fetch_array($sql_year)) 
	{  
		$smarty->append('game_year',
	   		 array('game_year_id' => $year['game_year_id'],
			 	   'game_year' => $year['game_year'],
			 	   'game_extra_info' => $year['game_extra_info']));
	}
						  
//***********************************************************************************
//get the game categories & the categories already selected for this game
//***********************************************************************************

		$sql_categories = mysql_query("SELECT * FROM game_cat ORDER BY game_cat_name")
						  or die ("Error loading categories");
		
		while ($categories=mysql_fetch_array ($sql_categories)) 
		{
			$sql_game_cat = mysql_query("SELECT * FROM game_cat_cross WHERE game_id='$game_id' AND game_cat_id=$categories[game_cat_id]")
							or die ("Error loading categorie cross table");
			
			$selected=mysql_num_rows($sql_game_cat);		
			if ( $selected == 1 )
			{
				$selected = 'selected';
			}
			else
			{
				$selected = '';
			}
			
			$smarty->append('cat',
	    			 array('cat_id' => $categories['game_cat_id'],
					 	   'cat_name' => $categories['game_cat_name'],
						   'cat_selected' => $selected)); 
		}

		
//**********************************************************************************		
//Get the author info
//**********************************************************************************

	//Get the individuals
	$sql_individuals = mysql_query("SELECT * FROM individuals ORDER BY ind_name ASC")
					   or die ("Couldn't query individual database");
		
	while  ($individuals=mysql_fetch_array($sql_individuals)) 
	{  
		$smarty->append('individuals',
	    		 array('ind_id' => $individuals['ind_id'],
					   'ind_name' => $individuals['ind_name']));
	}

	// Get the author types
	$sql_author = mysql_query("SELECT * FROM author_type ORDER BY author_type_info ASC")
		      or die ("Couldn't query author_types");
		
	while  ($author=mysql_fetch_array($sql_author)) 
	{  
		$smarty->append('author_types',
 			 array('author_type' => $author['author_type_info'],
				   'author_type_id' => $author['author_type_id']));
	}
	
	
	//Starting off with displaying the authors that are linked to the game and having a delete option for them */
	$sql_gameauthors = mysql_query("SELECT * FROM game_author
									LEFT JOIN individuals ON (game_author.ind_id = individuals.ind_id)
									LEFT JOIN author_type ON (game_author.author_type_id = author_type.author_type_id) 
									WHERE game_author.game_id='$game_id' ORDER BY author_type.author_type_id, individuals.ind_name")
						or die ("Error loading authors");
										
	 while  ($game_author=mysql_fetch_array ($sql_gameauthors)) 
	 {
	 	$smarty->append('game_author',
 			 array('game_author_id' => $game_author['game_author_id'],
				   'ind_name' => $game_author['ind_name'],
				   'ind_id' => $game_author['ind_id'],
				   'auhthor_type_info' => $game_author['author_type_info']));
	 }

//**********************************************************************************		
//Get the companies info
//**********************************************************************************
	
	//let's get all the companies in the DB
	$sql_company = mysql_query("SELECT * FROM pub_dev ORDER BY pub_dev_name ASC")
			     or die ("Couldn't query Publisher and Developer database");
		
	while  ($company=mysql_fetch_array($sql_company)) 
	{  
		$smarty->append('company',
	   		 	 array('comp_id' => $company['pub_dev_id'],
					   'comp_name' => $company['pub_dev_name']));
	}
	
	
	//let's get the publishers for this game
	$sql_publisher = mysql_query("SELECT * FROM pub_dev 
								 LEFT JOIN game_publisher ON ( pub_dev.pub_dev_id = game_publisher.pub_dev_id ) 
								 LEFT JOIN game_extra_info ON ( game_publisher.game_extra_info_id = game_extra_info.game_extra_info_id )
								 LEFT JOIN continent ON ( game_publisher.continent_id = continent.continent_id )
								 WHERE game_publisher.game_id = '$game_id' ORDER BY pub_dev_name ASC")
			        or die ("Couldn't query publishers");
	
	while  ($publishers=mysql_fetch_array($sql_publisher)) 
	{  
		$smarty->append('publisher',
	   		 	 array('pub_id' => $publishers['pub_dev_id'],
					   'pub_name' => $publishers['pub_dev_name'],
					   'continent_id' => $publishers['continent_id'],
					   'extra_info' => $publishers['game_extra_info'],
					   'continent' => $publishers['continent_name']));
	}
	
	
	//let's get the developers for this game
	$sql_developer = mysql_query("SELECT * FROM pub_dev 
								  LEFT JOIN game_developer ON ( pub_dev.pub_dev_id = game_developer.dev_pub_id ) 
								  LEFT JOIN game_extra_info ON ( game_developer.game_extra_info_id = game_extra_info.game_extra_info_id )
								  LEFT JOIN continent ON ( game_developer.continent_id = continent.continent_id )
								  WHERE game_developer.game_id = '$game_id' ORDER BY pub_dev_name ASC")
			        or die ("Couldn't query developers");
	
	while  ($developers=mysql_fetch_array($sql_developer)) 
	{  
		$smarty->append('developer',
	   		 	 array('pub_id' => $developers['pub_dev_id'],
					   'pub_name' => $developers['pub_dev_name'],
					   'continent_id' => $developers['continent_id'],
					   'extra_info' => $developers['game_extra_info'],
					   'continent' => $developers['continent_name']));
	}

	
//**********************************************************************************		
//Get all the continents
//**********************************************************************************

	$sql_continent = mysql_query("SELECT * FROM continent ORDER BY continent_name ASC")
			     or die ("Couldn't query continent database");
		
	while  ($continent=mysql_fetch_array($sql_continent)) 
	{  
		$smarty->append('continent',
	   		 	 array('continent_id' => $continent['continent_id'],
					   'continent_name' => $continent['continent_name']));
	}
	

//**********************************************************************************		
//Get the extra game info
//**********************************************************************************

	$sql_game_extra_info = mysql_query("SELECT * FROM game_extra_info ORDER BY game_extra_info ASC")
			     or die ("Couldn't query game_extra_info database");
		
	while  ($game_extra_info=mysql_fetch_array($sql_game_extra_info)) 
	{  
		$smarty->append('game_extra_info',
	   		 	 array('game_extra_info_id' => $game_extra_info['game_extra_info_id'],
					   'game_extra_info' => $game_extra_info['game_extra_info']));
	}

	
//***********************************************************************************
//The game categories
//***********************************************************************************

	$sql_categories = mysql_query("SELECT * FROM game_cat ORDER BY game_cat_name")
				 	  or die ("Error loading categories");
			
	while  ($categories=mysql_fetch_array($sql_categories)) 
	{ 
		$smarty->append('categories',
	   		 		 array('game_cat_id' => $categories['game_cat_id'],
					 	   'game_cat_name' => $categories['game_cat_name']));
	}
	
						
	$sql_catcross = mysql_query("SELECT * FROM game_cat_cross WHERE game_id='$game_id'")
					or die ("Error loading categorie cross table");
	
	$nr_catcross = 0;
	
	while  ($catcross=mysql_fetch_array($sql_catcross)) 
	{ 
		$smarty->append('catcross',
	   		 		 array('game_id' => $catcross['game_id'],
					 	   'game_cat_id' => $catcross['game_cat_id']));
		
		$nr_catcross++; 
	}

	$smarty->assign("nr_catcross",$nr_catcross); 
	

//***********************************************************************************
//AKA's
//***********************************************************************************

	$sql_aka = mysql_query("SELECT * FROM game_aka WHERE game_id='$game_id'")
 			   or die ("Couldn't query aka games");
	
	$nr_aka=0;
	
	while ($aka = mysql_fetch_array ($sql_aka)) 
	{
		$smarty->append('aka',
	   		 	 array('game_aka_name' => $aka['aka_name'],
					   'game_id' => $aka['game_id'],
					   'game_aka_id' => $aka['game_aka_id']));
		$nr_aka++;
	}
	
	$smarty->assign("nr_aka",$nr_aka); 

//***********************************************************************************
//The game statistics below on the page
//***********************************************************************************


//Get the number of screenshots!
$numberscreen = mysql_query("SELECT count(*) as count FROM screenshot_game WHERE game_id = '$game_id'")
		  		or die ("couldn't get number of screenshots");
$array = mysql_fetch_array($numberscreen);

$smarty->assign("nr_screenshots",$array['count']); 

//check the number of boxscans
$numberbox = mysql_query("SELECT count(*) as count FROM game_boxscan WHERE game_id = '$game_id'")
			 or die ("couldn't get number of boxscans");
$array = mysql_fetch_array($numberbox);

$smarty->assign("nr_boxscans",$array['count']); 

//Check how many reviews a game has 	
$numberreviews = mysql_query("SELECT count(*) as count FROM review_game WHERE game_id = '$game_id'")
			     or die ("couldn't get number of reviews");
$array = mysql_fetch_array($numberreviews);

$smarty->assign("nr_reviews",$array['count']); 

//check how many pics there are in the game gallery
$numbergallery = mysql_query("SELECT count(*) as count FROM game_gallery WHERE game_id = '$game_id'")
			     or die ("couldn't get number of gallery pics");
$array = mysql_fetch_array($numbergallery);

$smarty->assign("nr_pics",$array['count']); 

//check how many music files this game has
$numbermusic = mysql_query("SELECT count(*) as count FROM game_music WHERE game_id = '$game_id'")
			     or die ("couldn't get number of music files");
$array = mysql_fetch_array($numbermusic);

$smarty->assign("nr_music",$array['count']); 

//check how many magazine reviews this game has
$numbermag = mysql_query("SELECT count(*) as count FROM magazine_game WHERE game_id = '$game_id'")
			     or die ("couldn't get number of mag reviews");
$array = mysql_fetch_array($numbermag);

$smarty->assign("nr_magazines",$array['count']); 
	

//**********************************************************************************		
//Send it all to the template
//**********************************************************************************

$smarty->assign("game_id",$game_id);
$smarty->assign("user_id",$_SESSION['user_id']);
$smarty->assign('games_detail_tpl', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.tpl');

//close the connection
mysql_close();

<?php
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

	$sql_game = $mysqli->query("SELECT game_name, 
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

					
		while ($game_info= $sql_game->fetch_array(MYSQLI_BOTH)) 
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

	$sql_year = $mysqli->query("SELECT * FROM game_year 
							 LEFT JOIN game_extra_info ON ( game_year.game_extra_info_id = game_extra_info.game_extra_info_id )
							 WHERE game_id='$game_id'")
				or die ("Error loading year");
						  
	while ($year= $sql_year->fetch_array(MYSQLI_BOTH)) 
	{  
		$smarty->append('game_year',
	   		 array('game_year_id' => $year['game_year_id'],
			 	   'game_year' => $year['game_year'],
			 	   'game_extra_info' => $year['game_extra_info']));
	}
						  
//***********************************************************************************
//get the game categories & the categories already selected for this game
//***********************************************************************************

		$sql_categories = $mysqli->query("SELECT * FROM game_cat ORDER BY game_cat_name")
						  or die ("Error loading categories");
		
		while ($categories= $sql_categories->fetch_array(MYSQLI_BOTH) ) 
		{
			$sql_game_cat = $mysqli->query("SELECT * FROM game_cat_cross WHERE game_id='$game_id' AND game_cat_id=$categories[game_cat_id]")
							or die ("Error loading categorie cross table");
			
			$selected=get_rows($sql_game_cat);		
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
	$sql_individuals = $mysqli->query("SELECT * FROM individuals ORDER BY ind_name ASC")
					   or die ("Couldn't query individual database");
		
	while  ($individuals= $sql_individuals->fetch_array(MYSQLI_BOTH)) 
	{  
		$smarty->append('individuals',
	    		 array('ind_id' => $individuals['ind_id'],
					   'ind_name' => $individuals['ind_name']));
	}

	// Get the author types
	$sql_author = $mysqli->query("SELECT * FROM author_type ORDER BY author_type_info ASC")
		      or die ("Couldn't query author_types");
		
	while  ($author= $sql_author->fetch_array(MYSQLI_BOTH)) 
	{  
		$smarty->append('author_types',
 			 array('author_type' => $author['author_type_info'],
				   'author_type_id' => $author['author_type_id']));
	}
	
	
	//Starting off with displaying the authors that are linked to the game and having a delete option for them */
	$sql_gameauthors = $mysqli->query("SELECT * FROM game_author
									LEFT JOIN individuals ON (game_author.ind_id = individuals.ind_id)
									LEFT JOIN author_type ON (game_author.author_type_id = author_type.author_type_id) 
									WHERE game_author.game_id='$game_id' ORDER BY author_type.author_type_id, individuals.ind_name")
						or die ("Error loading authors");
										
	 while  ($game_author= $sql_gameauthors->fetch_array(MYSQLI_BOTH)) 
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
	$sql_company = $mysqli->query("SELECT * FROM pub_dev WHERE pub_dev_name REGEXP '^[0-9].*' ORDER BY pub_dev_name ASC")
			     or die ("Couldn't query Publisher and Developer database");
		
	while  ($company= $sql_company->fetch_array(MYSQLI_BOTH)) 
	{  
		$smarty->append('company',
	   		 	 array('comp_id' => $company['pub_dev_id'],
					   'comp_name' => $company['pub_dev_name']));
	}
	
	
	//let's get the publishers for this game
	$sql_publisher = $mysqli->query("SELECT * FROM pub_dev 
								 LEFT JOIN game_publisher ON ( pub_dev.pub_dev_id = game_publisher.pub_dev_id ) 
								 LEFT JOIN game_extra_info ON ( game_publisher.game_extra_info_id = game_extra_info.game_extra_info_id )
								 LEFT JOIN continent ON ( game_publisher.continent_id = continent.continent_id )
								 WHERE game_publisher.game_id = '$game_id' ORDER BY pub_dev_name ASC")
			        or die ("Couldn't query publishers");
	
	while  ($publishers= $sql_publisher->fetch_array(MYSQLI_BOTH)) 
	{  
		$smarty->append('publisher',
	   		 	 array('pub_id' => $publishers['pub_dev_id'],
					   'pub_name' => $publishers['pub_dev_name'],
					   'continent_id' => $publishers['continent_id'],
					   'extra_info' => $publishers['game_extra_info'],
					   'continent' => $publishers['continent_name']));
	}
	
	
	//let's get the developers for this game
	$sql_developer = $mysqli->query("SELECT * FROM pub_dev 
								  LEFT JOIN game_developer ON ( pub_dev.pub_dev_id = game_developer.dev_pub_id ) 
								  LEFT JOIN game_extra_info ON ( game_developer.game_extra_info_id = game_extra_info.game_extra_info_id )
								  LEFT JOIN continent ON ( game_developer.continent_id = continent.continent_id )
								  WHERE game_developer.game_id = '$game_id' ORDER BY pub_dev_name ASC")
			        or die ("Couldn't query developers");
	
	while  ($developers= $sql_developer->fetch_array(MYSQLI_BOTH)) 
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

	$sql_continent = $mysqli->query("SELECT * FROM continent ORDER BY continent_name ASC")
			     or die ("Couldn't query continent database");
		
	while  ($continent= $sql_continent->fetch_array(MYSQLI_BOTH)) 
	{  
		$smarty->append('continent',
	   		 	 array('continent_id' => $continent['continent_id'],
					   'continent_name' => $continent['continent_name']));
	}
	

//**********************************************************************************		
//Get the extra game info
//**********************************************************************************

	$sql_game_extra_info = $mysqli->query("SELECT * FROM game_extra_info ORDER BY game_extra_info ASC")
			     or die ("Couldn't query game_extra_info database");
		
	while  ($game_extra_info= $sql_game_extra_info->fetch_array(MYSQLI_BOTH)) 
	{  
		$smarty->append('game_extra_info',
	   		 	 array('game_extra_info_id' => $game_extra_info['game_extra_info_id'],
					   'game_extra_info' => $game_extra_info['game_extra_info']));
	}

	
//***********************************************************************************
//The game categories
//***********************************************************************************

	$sql_categories = $mysqli->query("SELECT * FROM game_cat ORDER BY game_cat_name")
				 	  or die ("Error loading categories");
			
	while  ($categories= $sql_categories->fetch_array(MYSQLI_BOTH)) 
	{ 
		$smarty->append('categories',
	   		 		 array('game_cat_id' => $categories['game_cat_id'],
					 	   'game_cat_name' => $categories['game_cat_name']));
	}
	
						
	$sql_catcross = $mysqli->query("SELECT * FROM game_cat_cross WHERE game_id='$game_id'")
					or die ("Error loading categorie cross table");
	
	$nr_catcross = 0;
	
	while  ($catcross= $sql_catcross->fetch_array(MYSQLI_BOTH)) 
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

	$sql_aka = $mysqli->query("SELECT * FROM game_aka WHERE game_id='$game_id'")
 			   or die ("Couldn't query aka games");
	
	$nr_aka=0;
	
	while ($aka = $sql_aka->fetch_array(MYSQLI_BOTH)) 
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
$numberscreen = $mysqli->query("SELECT count(*) as count FROM screenshot_game WHERE game_id = '$game_id'")
		  		or die ("couldn't get number of screenshots");
$array = $numberscreen->fetch_array(MYSQLI_BOTH);

$smarty->assign("nr_screenshots",$array['count']); 

//check the number of boxscans
$numberbox = $mysqli->query("SELECT count(*) as count FROM game_boxscan WHERE game_id = '$game_id'")
			 or die ("couldn't get number of boxscans");
$array = $numberbox->fetch_array(MYSQLI_BOTH);

$smarty->assign("nr_boxscans",$array['count']); 

//Check how many reviews a game has 	
$numberreviews = $mysqli->query("SELECT count(*) as count FROM review_game WHERE game_id = '$game_id'")
			     or die ("couldn't get number of reviews");
$array = $numberreviews->fetch_array(MYSQLI_BOTH);

$smarty->assign("nr_reviews",$array['count']); 

//check how many pics there are in the game gallery
$numbergallery = $mysqli->query("SELECT count(*) as count FROM game_gallery WHERE game_id = '$game_id'")
			     or die ("couldn't get number of gallery pics");
$array = $numbergallery->fetch_array(MYSQLI_BOTH);

$smarty->assign("nr_pics",$array['count']); 

//check how many music files this game has
$numbermusic = $mysqli->query("SELECT count(*) as count FROM game_music WHERE game_id = '$game_id'")
			     or die ("couldn't get number of music files");
$array = $numbermusic->fetch_array(MYSQLI_BOTH);

$smarty->assign("nr_music",$array['count']); 

//check how many magazine reviews this game has
$numbermag = $mysqli->query("SELECT count(*) as count FROM magazine_game WHERE game_id = '$game_id'")
			     or die ("couldn't get number of mag reviews");
$array = $numbermag->fetch_array(MYSQLI_BOTH);

$smarty->assign("nr_magazines",$array['count']); 
	
		//Get the companies to fill the search fields
		//Get publisher values to fill the searchfield
		$sql_publisher = $mysqli->query("SELECT pub_dev.pub_dev_id,
							pub_dev.pub_dev_name
							FROM game_publisher
							LEFT JOIN pub_dev ON (game_publisher.pub_dev_id = pub_dev.pub_dev_id)
							GROUP BY pub_dev.pub_dev_id HAVING COUNT(DISTINCT pub_dev.pub_dev_id) = 1
							ORDER BY pub_dev.pub_dev_name ASC") 
								or die("Problems retriving values from publishers.")or die("error publisher");
		
		while ($company_publisher = $sql_publisher->fetch_array(MYSQLI_BOTH))
		{
		
			$smarty->append('company_publisher',
	    		 array('comp_id' => $company_publisher['pub_dev_id'],
				 	   'comp_name' => $company_publisher['pub_dev_name']));
		
		}
		
		//Get Developer values to fill the searchfield
		$sql_developer = $mysqli->query("SELECT pub_dev.pub_dev_id,
							pub_dev.pub_dev_name
							FROM game_developer
							LEFT JOIN pub_dev ON (game_developer.dev_pub_id = pub_dev.pub_dev_id)
							GROUP BY pub_dev.pub_dev_id HAVING COUNT(DISTINCT pub_dev.pub_dev_id) = 1
							ORDER BY pub_dev.pub_dev_name ASC") 
								or die("Problems retriving values from developers.");
		
		while ($company_developer = $sql_developer->fetch_array(MYSQLI_BOTH))
		{
		
			$smarty->append('company_developer',
	    		 array('comp_id' => $company_developer['pub_dev_id'],
				 	   'comp_name' => $company_developer['pub_dev_name']));
		
		}






//**********************************************************************************		
//Send it all to the template
//**********************************************************************************

// Create dropdown values a-z
$az_value = az_dropdown_value(0);
$az_output = az_dropdown_output(0);
						   
$smarty->assign('az_value', $az_value);
$smarty->assign('az_output', $az_output);	


$smarty->assign("game_id",$game_id);
$smarty->assign("user_id",$_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/games_detail.html');

//close the connection
mysqli_close($mysqli);

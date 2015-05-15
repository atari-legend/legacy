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
//If delete aka link has been pressed
//***********************************************************************************
if ( isset($action) and $action == 'delete_aka' )
{
	$sql_aka = mysql_query("DELETE FROM game_aka WHERE game_aka_id = '$game_aka_id' AND game_id = '$game_id'") 
 			   or die ("Couldn't delete aka");

header("Location: ../games/games_detail.php?game_id=$game_id");
}

//***********************************************************************************
//If add aka button has been pressed
//***********************************************************************************
if ( isset($action) and $action == 'game_aka' )
{
	$sql_aka = mysql_query("INSERT INTO game_aka (game_id, aka_name) VALUES ('$game_id','$game_aka')")
 			   or die ("Couldn't insert aka games");

header("Location: ../games/games_detail.php?game_id=$game_id");
}

//***********************************************************************************
//If delete publisher button has been pressed
//***********************************************************************************
if ( isset($action) and $action == 'delete_creator' )
{
	if(isset($game_author_id)) 
	{
		foreach($game_author_id as $author) 
		{
			mysql_query("DELETE FROM game_author WHERE game_author_id = '$author' AND game_id = '$game_id'"); 
		}
	}
	else
	{
		$smarty->assign("message",'Please choose a creator');
	}
header("Location: ../games/games_detail.php?game_id=$game_id");
}

//***********************************************************************************
//If add publisher button has been pressed
//***********************************************************************************
if ( isset($action) and $action == 'add_creator' )
{
	if ( $ind_id != '-' ) 
	{
		$sql = mysql_query("INSERT INTO game_author (game_id , ind_id, author_type_id) VALUES ('$game_id','$ind_id', '$author_type_id')") or die ("creator insertion failed");  
	}
	else
	{
		$smarty->assign("message",'Please choose a creator');
	}
header("Location: ../games/games_detail.php?game_id=$game_id");
}	

//***********************************************************************************
//If delete publisher button has been pressed
//***********************************************************************************
if ( isset($action) and $action == 'delete_publisher' )
{
	if(isset($game_publisher_id)) 
	{
		foreach($game_publisher_id as $publisher) 
		{
			mysql_query("DELETE FROM game_publisher WHERE pub_dev_id = '$publisher' AND game_id = '$game_id'"); 
		}
	}
	else
	{
		$smarty->assign("message",'Please choose a publisher');
	}
header("Location: ../games/games_detail.php?game_id=$game_id");
}

//***********************************************************************************
//If add publisher button has been pressed
//***********************************************************************************
if ( isset($action) and $action == 'add_publisher' )
{
	if ( $company_id_pub != '-' ) 
	{
		$sql = mysql_query("INSERT INTO game_publisher (pub_dev_id ,game_id, continent_id, game_extra_info_id) VALUES ('$company_id_pub','$game_id','$continent_pub', '$game_extra_info_pub')") or die ("Publisher insertion failed");  
	}
	else
	{
		$smarty->assign("message",'Please choose a publisher');
	}
header("Location: ../games/games_detail.php?game_id=$game_id");
}	


//***********************************************************************************
//If delete developer button has been pressed
//***********************************************************************************
if ( isset($action) and $action == 'delete_developer' )
{
	if(isset($game_developer_id)) 
	{
		foreach($game_developer_id as $developer) 
		{
			mysql_query("DELETE FROM game_developer WHERE dev_pub_id = '$developer' AND game_id = '$game_id'"); 
		}
	}
	else
	{
		$smarty->assign("message",'Please choose a developer');
	}
header("Location: ../games/games_detail.php?game_id=$game_id");
}

//***********************************************************************************
//If add developer button has been pressed
//***********************************************************************************
if ( isset($action) and $action == 'add_developer' )
{
	if ( $company_id_dev != '-' ) 
	{
		$sql = mysql_query("INSERT INTO game_developer (dev_pub_id, game_id, continent_id, game_extra_info_id) VALUES ('$company_id_dev','$game_id','$continent_dev','$game_extra_info_dev')") or die ("Developer insertion failed");  
	}
	else
	{
		$smarty->assign("message",'Please choose a developer');
	}
header("Location: ../games/games_detail.php?game_id=$game_id");
}	


//***********************************************************************************
//If delete year button has been pressed
//***********************************************************************************
if ( isset($action) and $action == 'delete_year' )
{
	if(isset($game_year_id)) 
	{
		foreach($game_year_id as $year) 
		{
			mysql_query("DELETE FROM game_year WHERE game_year_id = '$year' AND game_id = '$game_id'"); 
		}
	}
	else
	{
		$smarty->assign("message",'Please choose a release year');
	}
header("Location: ../games/games_detail.php?game_id=$game_id");
}

//***********************************************************************************
//If add year button has been pressed
//***********************************************************************************
if ( isset($action) and $action == 'add_year' )
{
	$sql = mysql_query("INSERT INTO game_year (game_id, game_year, game_extra_info_id) VALUES ('$game_id','$Date_Year','$game_extra_info_year')") or die ("Release year insertion failed"); 
header("Location: ../games/games_detail.php?game_id=$game_id"); 
}	

//***********************************************************************************
//If the modify button has been pressed, update the necesarry tables 
//***********************************************************************************
	if ( isset($action) and $action == 'modify_game' )
	{
		// game_table
		$sdbquery  = mysql_query("UPDATE game SET game_name='$game_name' WHERE game_id=$game_id") or die ("trouble updating game"); 
		
		//******NOT USED ANYMORE******//
		// DUMP TABLE UPDATE
		//$sdbquery  = mysql_query("UPDATE game_search SET game_name='$game_name' WHERE game_id=$game_id") or die ("trouble updating dump table"); 
		
		// Delete the category crosses currently in the database for this game
		$sdbquery  = mysql_query("DELETE FROM game_cat_cross WHERE game_id=$game_id");	

		// Insert the values from the passed category array
		if(isset($category)) 
		{
			foreach ($category as $cat) 
			{
				$sdbquery  = mysql_query("INSERT INTO game_cat_cross (game_id,game_cat_id) VALUES ($game_id,$cat)");	
			}
		}
		

		// Update the public domain tick box info
		// Start off by deleting previos value
		$sdbquery = mysql_query("DELETE FROM game_free WHERE game_id='$game_id'");	

		// then insert the new value if it has been passed.
		if(isset($free))
		{
			$sdbquery = mysql_query("INSERT INTO game_free (game_id,free) VALUES ('$game_id','$free')");
		} 

		// Update the Unreleased tick box info
		// Start off by deleting previos value
		$sdbquery = mysql_query("DELETE FROM game_unreleased WHERE game_id='$game_id'");	

		// then insert the new value if it has been passed.
		if(isset($unreleased))
		{
			$sdbquery = mysql_query("INSERT INTO game_unreleased (game_id,unreleased) VALUES ('$game_id','$unreleased')");
		} 

		// Update the In Development tick box info
		// Start off by deleting previos value
		$sdbquery = mysql_query("DELETE FROM game_development WHERE game_id='$game_id'");	

		// then insert the new value if it has been passed.
		if(isset($development))
		{
			$sdbquery = mysql_query("INSERT INTO game_development (game_id,development) VALUES ('$game_id','$development')");
		} 

		// Update the STE ONLY tick box info
		// Start off by deleting previos value
		$sdbquery = mysql_query("DELETE FROM game_ste_only WHERE game_id='$game_id'");	
	
		// then insert the new value if it has been passed.
		if(isset($ste_only))
		{
			$sdbquery = mysql_query("INSERT INTO game_ste_only (game_id,ste_only) VALUES ('$game_id','$ste_only')");
		} 

		// Update the STE ENHANCED tick box info
		// Start off by deleting previos value
		$sdbquery = mysql_query("DELETE FROM game_ste_enhan WHERE game_id='$game_id'");	

		// then insert the new value if it has been passed.
		if(isset($ste_enhanced))
		{	
			$sdbquery = mysql_query("INSERT INTO game_ste_enhan (game_id,ste_enhanced) VALUES ('$game_id','$ste_enhanced')");
		} 

		// Update the FALCON ONLY tick box info
		// Start off by deleting previos value
		$sdbquery = mysql_query("DELETE FROM game_falcon_only WHERE game_id='$game_id'");	

		// then insert the new value if it has been passed.
		if(isset($falcon_only))
		{
			$sdbquery = mysql_query("INSERT INTO game_falcon_only (game_id,falcon_only) VALUES ('$game_id','$falcon_only')");
		} 

		// Update the FALCON ENHANCED tick box info
		// Start off by deleting previos value
		$sdbquery = mysql_query("DELETE FROM game_falcon_enhan WHERE game_id='$game_id'");	

		// then insert the new value if it has been passed.
		if(isset($falcon_enhanced))
		{
			$sdbquery = mysql_query("INSERT INTO game_falcon_enhan (game_id,falcon_enhanced) VALUES ('$game_id','$falcon_enhanced')");
		} 

		// Update the GAME UNFINISHED tick box info
		// Start off by deleting previos value
		$sdbquery = mysql_query("DELETE FROM game_unfinished WHERE game_id='$game_id'");	

		// then insert the new value if it has been passed.
		if(isset($unfinished))
		{
			$sdbquery = mysql_query("INSERT INTO game_unfinished (game_id,unfinished) VALUES ('$game_id','$unfinished')");
		} 

		// Update the MONOCHROME GAME tick box info
		// Start off by deleting previos value
		$sdbquery = mysql_query("DELETE FROM game_mono WHERE game_id='$game_id'");	

		// then insert the new value if it has been passed.
		if(isset($monochrome))
		{
			$sdbquery = mysql_query("INSERT INTO game_mono (game_id,monochrome) VALUES ('$game_id','$monochrome')");
		} 

		// Update the game wanted tick box info
		// Start off by deleting previos value
		$sdbquery = mysql_query("DELETE FROM game_wanted WHERE game_id='$game_id'");	

		// then insert the new value if it has been passed.
		if(isset($wanted))
		{
			$sdbquery = mysql_query("INSERT INTO game_wanted (game_id) VALUES ('$game_id')");
		} 

		// UPDATE THE ARCADE TICK BOX INFO
		// Start off by deleting previos value
		$sdbquery = mysql_query("DELETE FROM game_arcade WHERE game_id='$game_id'");	

		// then insert the new value if it has been passed.
		if(isset($arcade))
		{
			$sdbquery = mysql_query("INSERT INTO game_arcade (game_id,arcade) VALUES ('$game_id','$arcade')") or die("Couldn't insert arcade tick box info");
		}
		
		// UPDATE THE SEUCK TICK BOX INFO
		// Start off by deleting previos value
		$sdbquery = mysql_query("DELETE FROM game_seuck WHERE game_id='$game_id'");	

		// then insert the new value if it has been passed.
		if(isset($seuck))
		{
			$sdbquery = mysql_query("INSERT INTO game_seuck (game_id,seuck) VALUES ('$game_id','$seuck')") or die("Couldn't insert seuck tick box info");
		}
		
		// UPDATE THE STOS TICK BOX INFO
		// Start off by deleting previos value
		$sdbquery = mysql_query("DELETE FROM game_stos WHERE game_id='$game_id'");	

		// then insert the new value if it has been passed.
		if(isset($stos))
		{
			$sdbquery = mysql_query("INSERT INTO game_stos (game_id,stos) VALUES ('$game_id','$stos')") or die("Couldn't insert stos tick box info");
		}
		
		// UPDATE THE STAC TICK BOX INFO
		// Start off by deleting previos value
		$sdbquery = mysql_query("DELETE FROM game_stac WHERE game_id='$game_id'");	

		// then insert the new value if it has been passed.
		if(isset($stac))
		{
			$sdbquery = mysql_query("INSERT INTO game_stac (game_id,stac) VALUES ('$game_id','$stac')") or die("Couldn't insert stac tick box info");
		}
		
		$smarty->assign("message",'Game has been modified correctly');
	
header("Location: ../games/games_detail.php?game_id=$game_id");
	}
	

//***********************************************************************************
//If the delete button has been pressed, delete the necesarry records from the tables
//***********************************************************************************
	if ( isset($action) and $action == 'delete_game' )
	{
		//First we need to do a hell of a lot checks before we can delete an actual game.
		$sdbquery = mysql_query("SELECT * FROM game_download WHERE game_id='$game_id'")
				 	or die ("Error getting download info");
		if ( mysql_num_rows($sdbquery) > 0 )
		{
			$smarty->assign("message",'Deletion failed - This game has downloads - Delete it in the appropriate section');
		}
		else
		{
			$sdbquery = mysql_query("SELECT * FROM game_diskscan WHERE game_id='$game_id'")
				 		or die ("Error getting diskscan info");
			if ( mysql_num_rows($sdbquery) > 0 )
			{
				$smarty->assign("message",'Deletion failed - This game has a diskscan - Delete it in the appropriate section');
			}
			else
			{
				$sdbquery = mysql_query("SELECT * FROM game_gallery WHERE game_id='$game_id'")
				 			or die ("Error getting gallery info");
				if ( mysql_num_rows($sdbquery) > 0 )
				{
					$smarty->assign("message",'Deletion failed - This game has a images in the gallery table - Delete it in the appropriate section');
				}
				else
				{
					$sdbquery = mysql_query("SELECT * FROM game_boxscan WHERE game_id='$game_id'")
				 				or die ("Error getting boxscan info");
					if ( mysql_num_rows($sdbquery) > 0 )
					{
						$smarty->assign("message",'Deletion failed - This game has (a) boxscan(s) - Delete it in the appropriate section');
					}
					else
					{
						$sdbquery = mysql_query("SELECT * FROM game_user_comments WHERE game_id='$game_id'")
				 					or die ("Error getting user comments");
						if ( mysql_num_rows($sdbquery) > 0 )
						{
							$smarty->assign("message",'Deletion failed - This game has user comments - Delete it in the appropriate section');
						}
						else
						{
							$sdbquery = mysql_query("SELECT * FROM game_submitinfo WHERE game_id='$game_id'")
				 						or die ("Error getting submit info");
							if ( mysql_num_rows($sdbquery) > 0 )
							{
								$smarty->assign("message",'Deletion failed - This game has info submitted from visitors - Delete it in the appropriate section');
							}
							else
							{
								$sdbquery = mysql_query("SELECT * FROM screenshot_game WHERE game_id='$game_id'")
				 							or die ("Error getting screenshot info");
								if ( mysql_num_rows($sdbquery) > 0 )
								{
									$smarty->assign("message",'Deletion failed - This game has screenshots - Delete it in the appropriate section');
								}
								else
								{
									$sdbquery = mysql_query("SELECT * FROM review_game WHERE game_id='$game_id'")
				 								or die ("Error getting review info");
									if ( mysql_num_rows($sdbquery) > 0 )
									{
										$smarty->assign("message",'Deletion failed - This game has reviews - Delete it in the appropriate section');
									}
									else
									{
										$sdbquery = mysql_query("SELECT * FROM game_music WHERE game_id='$game_id'")
				 									or die ("Error getting music info");
										if ( mysql_num_rows($sdbquery) > 0 )
										{
											$smarty->assign("message",'Deletion failed - This game has music files attached - Delete it in the appropriate section');
										}
										else
										{
											$sdbquery = mysql_query("DELETE FROM game WHERE game_id = '$game_id' ");
											$sdbquery = mysql_query("DELETE FROM game_publisher WHERE game_id = '$game_id'");
											$sdbquery = mysql_query("DELETE FROM game_developer WHERE game_id = '$game_id' ");
											$sdbquery = mysql_query("DELETE FROM game_year WHERE game_id = '$game_id' ");
											$sdbquery = mysql_query("DELETE FROM game_cat_cross WHERE game_id = '$game_id' ");
											$sdbquery = mysql_query("DELETE FROM game_development WHERE game_id='$game_id'");
											$sdbquery = mysql_query("DELETE FROM game_unreleased WHERE game_id='$game_id'");
											$sdbquery = mysql_query("DELETE FROM game_free WHERE game_id='$game_id'");
											$sdbquery = mysql_query("DELETE FROM game_arcade WHERE game_id='$game_id'");
											$sdbquery = mysql_query("DELETE FROM game_seuck WHERE game_id='$game_id'");
											$sdbquery = mysql_query("DELETE FROM game_stos WHERE game_id='$game_id'");
											$sdbquery = mysql_query("DELETE FROM game_wanted WHERE game_id='$game_id'");
											$sdbquery = mysql_query("DELETE FROM game_mono WHERE game_id='$game_id'");
											$sdbquery = mysql_query("DELETE FROM game_unfinished WHERE game_id='$game_id'");
											$sdbquery = mysql_query("DELETE FROM game_falcon_enhan WHERE game_id='$game_id'");
											$sdbquery = mysql_query("DELETE FROM game_falcon_only WHERE game_id='$game_id'");
											$sdbquery = mysql_query("DELETE FROM game_ste_enhan WHERE game_id='$game_id'");
											$sdbquery = mysql_query("DELETE FROM game_ste_only WHERE game_id='$game_id'");
											$sdbquery = mysql_query("DELETE FROM game_aka WHERE game_id='$game_id'");
											$sdbquery = mysql_query("DELETE FROM lingo_game WHERE game_id='$game_id'");
											$sdbquery = mysql_query("DELETE FROM game_similar WHERE game_id='$game_id'");
											$sdbquery = mysql_query("DELETE FROM game_series_cross WHERE game_id='$game_id'");
											$sdbquery = mysql_query("DELETE FROM game_author WHERE game_id='$game_id'");				
	
											//Get the companies to fill the search fields
											$sql_company = mysql_query("SELECT * FROM pub_dev ORDER BY pub_dev_name ASC")
			    	 									   or die ("Couldn't query Publisher and Developer database");
		
											while  ($company=mysql_fetch_array($sql_company)) 
											{  
												$smarty->append('company',
	    											 array('comp_id' => $company['pub_dev_id'],
				 	  									   'comp_name' => $company['pub_dev_name']));
											}

											$smarty->assign("message",'Game succesfully deleted');

											$smarty->assign("user_id",$_SESSION['user_id']);
											$smarty->assign('games_main_tpl', '1');

											//Send all smarty variables to the templates
											$smarty->display('file:../templates/0/index.tpl');

											//close the connection
											mysql_close();
										}
									}
								}
							}
						}
					}
				}
			}
		}
header("Location: ../games/games_main.php");
	}
//close the connection
mysql_close();
?>

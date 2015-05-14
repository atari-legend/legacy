<?
/***************************************************************************
*                                link_mod.php
*                            -----------------------
*   begin                : Saturday, Jan 08, 2005
*   copyright            : (C) 2003 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : file creation
*							
*
*   Id: link_mod.php,v 0.10 2005/01/08 Silver Surfer
*
***************************************************************************/

/*
***********************************************************************************
In this section we modify links
***********************************************************************************
*/

include("../includes/common.php");

global $g_tree;
$g_tree = array();

		$LINKSQL = mysql_query("SELECT website_category_id,parent_category,website_category_name FROM website_category order by website_category_name")
				   or die ("Error while querying the links category database");
		 
                 while($link_row=mysql_fetch_array($LINKSQL)){
                 
$g_tree[]  = array(
                    'id'        => $link_row['website_category_id'],
                    'id_parent' => $link_row['parent_category'],
                    'title'     => $link_row['website_category_name']);
                 };
		global $ret_tree;		 
			$ret_tree = array();

// __Recursive function call__
// If you want to print out only
// a subtree you have to modify the first value
// of this function to the id of the subtree
//

$sql_query = "SELECT website_category_id,parent_category,website_category_name FROM website_category order by website_category_name";

//maketree(,,)
maketree(0,$sql_query,0);

//Print the tree structure with indents
//
foreach($ret_tree as $cat)
{
    $indent = '0';
    
    for($i=0;$i<$cat['indent'];$i++)
    {
        $indent=$indent+15;
    }
  		
		$website = mysql_query ("SELECT website_category_id FROM website_category_cross WHERE website_category_id='$cat[id]'");
	
		$website_count = get_rows($website);
		
		
			$smarty->append('category',
	    	array('category_name' => $cat['title'],
				  'category_id' => $cat['id'],
				  'category_parent' => $cat['id_parent'],
				  'category_indent' => $indent,
				  'category_count' => $website_count));
	
} 
				 
				 
					
               
				 
$smarty->assign('link_cat_tpl', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.tpl');
?>

<?php
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

		$LINKSQL = $mysqli->query("SELECT website_category_id,parent_category,website_category_name FROM website_category order by website_category_name")
				   or die ("Error while querying the links category database");
		 
                 while($link_row = $LINKSQL->fetch_array(MYSQLI_BOTH)){
                 
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

$sql_query = $mysqli->query("SELECT website_category_id,parent_category,website_category_name FROM website_category order by website_category_name");

//maketree(,,)
$ret_tree = maketree(0,$sql_query,0);

//$ret_tree = asort($ret_tree);
asort($ret_tree);
//print_r(array_values($ret_tree));
//print_r(array_keys($ret_tree));

//Print the tree structure with indents
//

$arr = array("one", "two", "three");
reset($arr);
echo"<br><br>";

while (list($key, $value) = each($ret_tree)) {

	
	
	foreach($value as $cat) {
		asort($cat);
		foreach($cat as $cat2) {

    				echo "Key: $key; Value: $cat2; <br />\n";
		}
	}
}

foreach($ret_tree as $cat)
{
    $indent = '0';
    
    for($i=0; $i < $cat['$indent']; $i++)
    {
        $indent=$indent+15;
    }
  		
		$website = $mysqli->query("SELECT website_category_id FROM website_category_cross WHERE website_category_id='$cat[id]'");
	
		$website_count = get_rows($website);
		
		
			$smarty->append('category',
	    	array('category_name' => $cat['title'],
				  'category_id' => $cat['id'],
				  'category_parent' => $cat['id_parent'],
				  'category_indent' => $indent,
				  'category_count' => $website_count));
	
} 

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/link_cat.html');
?>

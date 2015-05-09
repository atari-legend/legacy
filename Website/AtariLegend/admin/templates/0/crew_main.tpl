{* 
/***************************************************************************
                              crew_main.tpl
*                            --------------------------
*   begin                : Sunday, August 28, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : admin@atarilegend.com
*
*   Id: crew_main.tpl,v 0.10 2005/10/29 Silver
*
***************************************************************************/

************************************************************************************************
The main game page
************************************************************************************************
*}

{literal}
<script type="text/javascript">
function crewinsert()
{
    JSnewcrew=document.forms["insertcrew"].newcrew.value;
	
	if (JSnewcrew=='')
	{
		alert('Please fill in a crew name');
	}
	else
	{
    	// CONFIRM REQUIRES ONE ARGUMENT
    	var message = "Are you sure you want to insert this crew into the database?";
    	// CONFIRM IS BOOLEAN. THAT MEANS THAT
    	// IT RETURNS TRUE IF 'OK' IS CLICKED
    	// OTHERWISE IT RETURN FALSE
    	var return_value = confirm(message);
		
    	if (return_value !="0")
    	{
    		url="db_crew.php?new_crew="+JSnewcrew+"&action=insert_crew";
			location.href=url;
    	} 
	}
}
</script>
{/literal}

<table align="center" class="HEADERBAR" width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
	<td style="vertical-align:top;" height="5" colspan=6>
	<span class="LEFTNAVHEADING">&nbsp;Crew editor</span>
	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="15" align="center" class="CELLCOLOR">
<tr>
	<td colspan="2">
	<fieldset class="category_set_noGrave" style="margin-left: 5%;margin-right: 5%; width:90%;text-align:center;">
		In this section you can add or edit a crew. Search for a crew by using any of the 
		functionalities below. 
	</fieldset> 
	</td>
</tr>
<tr>
	<td align="center">
		<form action="../crew/crew_search.php" method="post" name="crew_search" id="crew_search">
		<fieldset class="interview_set">
		<legend class="links_legend">Search crews</legend>
		<br>
		<table>
		<tr>
			<td>
				<b>By name :</b>
			</td>
			<td>
				<select name="crewbrowse">
					<option value="" SELECTED>-</option>
					<option value="num">0-9</option>
					<option value="a">A</option>
					<option value="b">B</option>
					<option value="c">C</option>
					<option value="d">D</option>
					<option value="e">E</option>
					<option value="f">F</option>
					<option value="g">G</option>
					<option value="h">H</option>
					<option value="i">I</option>
					<option value="j">J</option>
					<option value="k">K</option>
					<option value="l">L</option>
					<option value="m">M</option>
					<option value="n">N</option>
					<option value="o">O</option>
					<option value="p">P</option>
					<option value="q">Q</option>
					<option value="r">R</option>
					<option value="s">S</option>
					<option value="t">T</option>
					<option value="u">U</option>
					<option value="v">V</option>
					<option value="w">W</option>
					<option value="x">X</option>
					<option value="y">Y</option>
					<option value="z">Z</option>
				</select>
				<input type="text" name="crewsearch" value="{if $new_crew <> ''}{$new_crew}{/if}">
			</td>
		</tr>
			
		</table>
		<br>
		
		<br>
		
		<input type="submit" value="Search">
		<br>
		</fieldset>
		<input type="hidden" name="action" id="action" value="search">
		</form>	
	</td>
</tr>
<tr>
	<td align="center">
	
	<span class="MAINNAV" style="text-align:center;">{if $new_crew <> ''}{$new_crew} added to the database!{/if}<br></span><br>
		<form method="post" name="insertcrew">
		<fieldset class="interview_set">
		<legend class="links_legend">Add Crew</legend>
			<input type="text" name="newcrew">
			<input type="submit" value="Insert" onClick="crewinsert(); return false;">	
		</fieldset>
		</form>
	</td>
</tr>
</table>
<table align="center" class="HEADERBAR" width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	<td>
 	<span class="LEFTNAVHEADING">&nbsp;&nbsp;&nbsp;</span>
	</td>
</tr>
</table>

{if $message <> ''}
	<table align="center" width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td align="center" >
			<br><br>
			<span class="MAINAV">{$message}</span>
		</td>
	</tr>
	</table>
{/if}
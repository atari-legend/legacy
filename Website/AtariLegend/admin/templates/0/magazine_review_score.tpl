<script language="JavaScript">
function scoredelete(JSmagID,JSgame_id)
{literal}{ {/literal}  
	
    	// CONFIRM REQUIRES ONE ARGUMENT
    	var message = "Are you sure you want to delete this review score?";
    	// CONFIRM IS BOOLEAN. THAT MEANS THAT
    	// IT RETURNS TRUE IF 'OK' IS CLICKED
    	// OTHERWISE IT RETURN FALSE
    	var return_value = confirm(message);

    	if (return_value !="0")
    	{literal}{ {/literal} 
    		url="../magazine/db_magazine.php?action=score_delete&magazine_game_id="+JSmagID+"&game_id="+JSgame_id+""
			location.href=url;
    	{literal}}  {/literal} 

{literal}} {/literal} 

</script>

<table width="100%" border="0" cellspacing="0" cellpadding="2" align="center" class="HEADERBAR">
<tr>    
	<td height="5" style="vertical-align:top;">
	<span class="LEFTNAVHEADING">&nbsp;&nbsp;Add Review Score</span>
	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="15" align="center" class="CELLCOLOR">
<tr>
	<td>
	
		
		<br>
		{foreach from=$game_score item=line}
		{$line.game_name} - {$line.magazine_name} {$line.magazine_issue_nr} - score {$line.score} 
		- <a onClick="scoredelete({$line.magazine_game_id},{$game.game_id})" style="cursor: pointer;" class="MAINNAV">Delete Score</a><br>
		{/foreach}<br>
		
		<fieldset class="category_set_noGrave">
	<legend class="links_legend">Reviewed games.</legend>
	<br>
	{* Marty! Hi mate! here you need to add the search variables. Take care /Matt *}
	<form action="../magazine/magazine_setscore.php?source=gameinfo&game_id={$game.game_id}" method="post" name="pickissue" id="pickissue">
			
				<select name="magazine_issue_id" id="magazine_issue_id" size="10">
					
				{foreach from=$issues item=line}
				<option value="{$line.magazine_issue_id}">{$line.magazine_name} issue {$line.magazine_issue_nr}</option>	
				{/foreach}
				
				</select>
			<input type="hidden" name="action" value="set_score">	
			<input type="submit" value="SELECT">
	</form>
	
</fieldset>
		
		
<br>

<a href="../game/game_detail.php?game_id={$game.game_id}" class="MAINNAV">Back</a>

	</td>
</tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="HEADERBAR">
<tr>
	<td>
	<span class="LEFTNAVHEADING">&nbsp;&nbsp;&nbsp;</span>
 	</td>
</tr>
</table>
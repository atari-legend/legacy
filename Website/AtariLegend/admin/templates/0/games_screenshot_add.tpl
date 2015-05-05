{* 
********************************************************************************
*                                games_screenshots_add.tpl
*                            ---------------------------------
*   begin                : Tuesday, november 9, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : admin@atarilegend.com
*	 actual update        : Creation of file
*
*   Id: games_screenshots_tpl.php,v 0.10 2005/11/09 23:02 ST Gravedigger
*
*********************************************************************************/

///***********************************************************************************
// This is the sub template file to generate the games main screenshot page
//************************************************************************************ 
*}

{literal}
<script type="text/javascript">
function delete_screenshot(screenshot_id, game_id)
{	
	// CONFIRM REQUIRES ONE ARGUMENT
    var message = "Are you sure you want to delete the screenshot?";
    // CONFIRM IS BOOLEAN. THAT MEANS THAT
    // IT RETURNS TRUE IF 'OK' IS CLICKED
    // OTHERWISE IT RETURN FALSE
    var return_value = confirm(message);
	if (return_value !="0")
    {
      	url="games_screenshot_add.php?game_id="+game_id+"&screenshot_id="+screenshot_id+"&action=delete_screen";
		location.href=url;
    }
}
</script>
{/literal}
				
<table align="center" class="HEADERBAR" width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
	<td style="vertical-align:top;" height="5" colspan=6>
	<span class="LEFTNAVHEADING">&nbsp;Game screenshots - <a href="../games/games_detail.php?game_id={$game_id}" class="MAINNAV_WHITE">{$game_name}</a></span>
	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="15" align="center" class="CELLCOLOR">
<tr>
	<td>
	<fieldset class="category_set">
		In this section you can add screenshots to a selected game. Use the browse buttons to select the shots and press the 
		'Submit Query' button to link them to the game.
	</fieldset> 
	<br>
	<br>
	<table width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td align="center" width="100%">
		<fieldset class="news_set">
		<legend class="links_legend">screenshots</legend>
		
	<table border="0" cellspacing="2" cellpadding="2" align="center">	
		{if $screenshots_nr <> ''}
			{foreach from=$screenshots item=line name=screen}
		{if $smarty.foreach.screen.iteration eq 1}<tr>{/if}
		{if $smarty.foreach.screen.iteration eq 8}<tr>{/if}
		{if $smarty.foreach.screen.iteration eq 15}<tr>{/if}
		{if $smarty.foreach.screen.iteration eq 22}<tr>{/if}
		{if $smarty.foreach.screen.iteration eq 29}<tr>{/if}
		{if $smarty.foreach.screen.iteration eq 36}<tr>{/if}
		{if $smarty.foreach.screen.iteration eq 43}<tr>{/if}
		{if $smarty.foreach.screen.iteration eq 50}<tr>{/if}		
			<td align="center">	
				Image {$line.count} :: 
				<a href="javascript:delete_screenshot({$line.id},{$game_id})" class="MAINNAV">Delete</a> ::    	
				<a href="javascript:void(window.open('../includes/showscreens.php?screenshot_id={$line.id}','4','width={$line.width},height={$line.height},toolbar=no,statusbar=no'))" class="MAINNAV"><img src="../includes/showimage.php?img={$line.image}&amp;w=89&amp;shadow=0&amp;bgcolour=a2a2a2" width=75 class="shot_border" alt="Click to enlarge!" vspace="2" hspace="1"></a>
			</td>
		{if $smarty.foreach.screen.iteration eq 7}</tr>{/if}
		{if $smarty.foreach.screen.iteration eq 14}</tr>{/if}
		{if $smarty.foreach.screen.iteration eq 21}</tr>{/if}
		{if $smarty.foreach.screen.iteration eq 28}</tr>{/if}
		{if $smarty.foreach.screen.iteration eq 35}</tr>{/if}
		{if $smarty.foreach.screen.iteration eq 42}</tr>{/if}
		{if $smarty.foreach.screen.iteration eq 49}</tr>{/if}
		{if $smarty.foreach.screen.last}</tr>{/if}
			{/foreach}
	</table>
		{else}
			No screenshots attached to this game
		{/if}
		</fieldset>	
		</td>
	</tr>
	</table>
	</td>
</tr>

<tr>
	<td align="center">
		<fieldset class="news_set">
		<legend class="links_legend">Browse</legend>
		<form enctype="multipart/form-data" name="frmUploadShot" action="games_screenshot_add.php" method="post">
		{section name=loop loop=11 start=1} 
			<input type="file" name="image[{$smarty.section.loop.index}]">
		{/section}	
		</fieldset> 
	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="15" align="center" class="CELLCOLOR">
<tr>
	<td>
	<input type="hidden" name="MAX_FILE_SIZE" value="100000">
	<input type="hidden" name="game_id" value="{$game_id}">
	<input type="hidden" name="action" value="add_screens">
	<input type="submit" name="cmdSubmit">
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
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
   		<td colspan="3" valign=top align=center>
			<b><a href="../games/games_detail.php?game_id={$game_id}" class="MAINNAV">back</a></b>
		</td>
	</tr>
</table>
<br>

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
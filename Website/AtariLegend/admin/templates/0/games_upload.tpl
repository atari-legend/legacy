{* 
***************************************************************************
*                                games_upload.tpl
*                            ------------------------
*   begin                : Tuesday, november 9, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : admin@atarilegend.com
*	 actual update        : Creation of file
*
*   Id: games_upload.tpl,v 0.10 2005/11/09 15:10 ST Gravedigger
*
***************************************************************************/

************************************************************************************************
The game upload page
************************************************************************************************
*}

{literal}
<script type="text/javascript">
function delete_download(id, game_id)
{ 
      	// CONFIRM REQUIRES ONE ARGUMENT
    	var message = "Are you sure you want to delete this file?";
    	// CONFIRM IS BOOLEAN. THAT MEANS THAT
    	// IT RETURNS TRUE IF 'OK' IS CLICKED
    	// OTHERWISE IT RETURN FALSE
    	var return_value = confirm(message);

    	if (return_value !="0")
    	{
    		url="../games/games_upload.php?game_id="+game_id+"&game_download_id="+id+"&action=delete_download";
			location.href=url;
    	} 
}
</script>
{/literal}


<table align="center" class="HEADERBAR" width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
	<td style="vertical-align:top;" height="5" colspan=6>
	&nbsp;Upload file for <a href="../games/games_detail.php?game_id={$game.game_id}" class="MAINNAV_WHITE">{$game.game_name}</a>
	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="15" align="center" class="CELLCOLOR">
<tr>
	<td colspan="2">
	<fieldset class="category_set">
		In this section you can upload a download for <b><a href="../games/games_detail.php?game_id={$game.game_id}" class="MAINNAV">{$game.game_name}</a></b>.	Make sure to give 
		every version a different set nr. If a game has 2 disks, those 2 disks should have equal
		set nr's. set nrs are linked to the version/crack you upload. If you upload 2 different 
		crack with the same set_nr for a certain game, it all gets screwed! so make sure you do it 
		correctly!
	</fieldset> 
	</td>
</tr>
</table>

{if $nr_downloads >= '1'}
<table width="100%" cellspacing="2" cellpadding="15" class="CELLCOLOR">
{foreach from=$downloads item=line}
<tr>
	<td>
	<form action="../games/games_upload.php?action=update_download" method="post" name="upload">
	<fieldset class="game_set">
		<legend class="links_legend">{$line.date}</legend>
		<table width="100%">
		<tr>
			<td colspan="4">
				<a href="../../games/game_download.php?game_download_id={$line.game_download_id}" class="MAINNAV">{$line.filename}</a>
				<br>
				<br>
			</td>
		</tr>	
		<tr>
			<td width="10%">
				<b>Cracker :</b>
			</td>
			<td width="40%">
				<input type="text" name="cracker"  maxlength="60" value="{$line.cracker}">
			</td>
			<td width="10%">
				<b>Supplier :</b>
			</td>
			<td width="40%">
				<input type="text" name="supplier"  maxlength="60" value="{$line.supplier}">
			</td>
		</tr>
		<tr>
			<td width="10%">
				<b>Intro By :</b>
			</td>
			<td width="40%">
				<input type="text" name="intro"  maxlength="60" value="{$line.intro}">
			</td>
			<td width="10%">
				<b>Harddrive :</b>
			</td>
			<td width="40%">
				<input type="checkbox" name="harddrive" value="1" {if $line.harddrive=="1"}  "checked" {/if}>
			</td>
		</tr>
		<tr>
			<td width="10%">
				<b>PAL only :</b>
			</td>
			<td width="40%">
				<input type="checkbox" name="screen" value="PAL" {if $line.pal_ntsc=="PAL"} "checked" {/if}>
			</td>
			<td width="10%">
				<b>NTSC only :</b>
			</td>
			<td width="40%">
				<input type="checkbox" name="screen" value="NTSC" {if $line.pal_ntsc=="NTSC"} "checked" {/if}>
			</td>
		</tr>
		<tr>
			<td width="10%">
				<b>Language :</b>
			</td>
			<td width="40%">
				<select name="language" size="1">
					<option value="Ar" {if $line.language=='Ar'} "SELECTED" {/if}>Arabic</option>
					<option value="En" {if $line.language=='En'} "SELECTED" {/if}>English</option>
					<option value="Es" {if $line.language=='Es'} "SELECTED" {/if}>Spanish</option>
					<option value="Fr" {if $line.language=='Fr'} "SELECTED" {/if}>French</option>
					<option value="Sv" {if $line.language=='Sv'} "SELECTED" {/if}>Swedish</option>
					<option value="It" {if $line.language=='It'} "SELECTED" {/if}>Italian</option>
					<option value="De" {if $line.language=='De'} "SELECTED" {/if}>German</option>
					<option value="Nl" {if $line.language=='Nl'} "SELECTED" {/if}>Dutch</option>
					<option value="Fi" {if $line.language=='Fi'} "SELECTED" {/if}>Finish</option>
					<option value="Mu" {if $line.language=='Mu'} "SELECTED" {/if}>Mulilanguage</option>
				</select>
			</td>
			<td width="10%">
				<b>Trainer :</b>
			</td>
			<td width="40%">
				<select name="trainer" size="1">
					<option value=""  {if $line.trainer !=='M' and $line.trainer !=='T'} "SELECTED" {/if}>No Trainer</option>
					<option value="T" {if $line.trainer =='T'} "SELECTED" {/if}>Trainer</option>
					<option value="M" {if $line.trainer =='M'} "SELECTED" {/if}>Mega Trainer</option>
				</select>
			</td>
		</tr>
		<tr>
			<td width="10%">
				<b>Disk :</b>
			</td>
			<td width="40%">
				<select name="disks" size="1">
					<option value="0"  {if $line.disks == '' or $line.disks == '0'} "SELECTED" {/if}>Single disk game</option>
					<option value="1"  {if $line.disks == '1'} "SELECTED" {/if}>1</option>
					<option value="2"  {if $line.disks == '2'} "SELECTED" {/if}>2</option>
					<option value="3"  {if $line.disks == '3'} "SELECTED" {/if}>3</option>
					<option value="4"  {if $line.disks == '4'} "SELECTED" {/if}>4</option>
					<option value="5"  {if $line.disks == '5'} "SELECTED" {/if}>5</option>
					<option value="6"  {if $line.disks == '6'} "SELECTED" {/if}>6</option>
					<option value="7"  {if $line.disks == '7'} "SELECTED" {/if}>7</option>
					<option value="8"  {if $line.disks == '8'} "SELECTED" {/if}>8</option>
					<option value="9"  {if $line.disks == '9'} "SELECTED" {/if}>9</option>
					<option value="10" {if $line.disks == '10'} "SELECTED" {/if}>10</option>
				</select>
			</td>
			<td width="10%">
				<b>SET NR :</b>
			</td>
			<td width="40%">
				<select name="set_nr" size="1">
					<option value="1"  {if $line.set_nr == '1'} "SELECTED" {/if}>1</option>
					<option value="2"  {if $line.set_nr == '2'} "SELECTED" {/if}>2</option>
					<option value="3"  {if $line.set_nr == '3'} "SELECTED" {/if}>3</option>
					<option value="4"  {if $line.set_nr == '4'} "SELECTED" {/if}>4</option>
					<option value="5"  {if $line.set_nr == '5'} "SELECTED" {/if}>5</option>
					<option value="6"  {if $line.set_nr == '6'} "SELECTED" {/if}>6</option>
					<option value="7"  {if $line.set_nr == '7'} "SELECTED" {/if}>7</option>
					<option value="8"  {if $line.set_nr == '8'} "SELECTED" {/if}>8</option>
					<option value="9"  {if $line.set_nr == '9'} "SELECTED" {/if}>9</option>
					<option value="10" {if $line.set_nr == '10'} "SELECTED" {/if}>10</option>
				</select>
			</td>
		</tr>
		<tr>
			<td width="10%">
				<b>Game version :</b>
			</td>
			<td width="40%">
				<input type="text" name="version" maxlength="60" value="{$line.version}">
			</td>
			<td width="10%">
				<b>TOS version</b>
			</td>
			<td width="40%">
				<input type="text" name="tos" maxlength="60" value="{$line.tos}">
			</td>
		</tr>
		<tr>
			<td width="20%">
				<b>Atari Legend Disk :</b>
			</td>
			<td width="30%">
				<input type="checkbox" name="legend" value="1" {if $line.legend == '1'} "checked" {/if}>
			</td>
			<td width="20%">
				<b>Disable download :</b>
			</td>
			<td width="30%">
				<input type="checkbox" name="disable" value="1" {if $line.disable =='1'} "checked" {/if}>
			</td>
		</tr>
		
		<tr>
			<td colspan="4">
				<br>
				<br>
				<input type="hidden" name="game_download_id" value="{$line.game_download_id}">
				<input type="hidden" name="game_id" value="{$game.game_id}">
				<input type="button" value="Delete" onClick="delete_download({$line.game_download_id},{$game.game_id});">
				<input type="submit" value="Update_info">
			</td>
		</tr>	
		</table>
	</fieldset>
	</form>
	</td>
</tr>
{/foreach}
</table>
{/if}

<table width="100%" cellspacing="2" cellpadding="15" class="CELLCOLOR">
<tr>
	<td>
	<form action="../games/games_upload.php?action=add_download" enctype="multipart/form-data" method="post" name="add_file">
	<fieldset class="category_set">
		<legend class="links_legend">Add a new download</legend>
		<table>
		<tr>
			<td>
				<b>Filename :</b> <input type="file" name="game_download_name" accept="application/x-zip-compressed,application/x-zip-compressed,application/x-zip-compressed">
			</td>
		</tr>
		<tr>
			<td>
				<input type="submit" value="Upload">
				<input type="hidden" name="game_id" value="{$game.game_id}">
			</td>
		</tr>
	   </table>
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
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
   		<td colspan="3" valign=top align=center>
			<b><a href="../games/games_detail.php?game_id={$game.game_id}" class="MAINNAV">back</a></b>
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

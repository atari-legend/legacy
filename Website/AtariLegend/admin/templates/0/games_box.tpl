{* 
/***************************************************************************
*                                games_box.tpl
*                            --------------------------
*   begin                : 2005-01-06
*   copyright            : (C) 2005 Atari Legend
*   email                : admin@atarilegend.com
*
*   Id:  games_box.tpl,v 0.10 2005/11/19 Silver
*
***************************************************************************/
*}

<script language="JavaScript">
function deletescreen(JSgameboxID,JSmode)
{literal}{ {/literal}
	// CONFIRM REQUIRES ONE ARGUMENT
    var message = "Are you sure you want to delete this scan?";
    // CONFIRM IS BOOLEAN. THAT MEANS THAT
    // IT RETURNS TRUE IF 'OK' IS CLICKED
    // OTHERWISE IT RETURN FALSE
    var return_value = confirm(message);
	if (return_value !="0")
  {literal}  { {/literal}
      	url="../games/db_games_box.php?mode="+JSmode+"&game_boxscan_id="+JSgameboxID+"&game_id={$game_info.game_id}&action=boxscan_delete";
		location.href=url;
 {literal}   }
}{/literal}
</script>


<table width="100%" border="0" cellspacing="0" cellpadding="2" align="center" class="HEADERBAR">
<tr>    
	<td height="5" style="vertical-align:top;">
	<span class="LEFTNAVHEADING">&nbsp;&nbsp;{$game_info.game_name} - Boxscans</span>
	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="2" align="center" class="CELLCOLOR">
<tr>
	<td>
		<fieldset class="category_set">
			<legend class="links_legend">Boxscans - help</legend>
			<table>
				<tr>
					<td width="100%" align="left" valign="top">
					In this section you can add boxscans to the database. Front and back scans. First add a front box, then you'll have the opportunity to upload and link a back scan with it! 
					</td>
				</tr>
			</table>
		</fieldset> 	

	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="2" align="center" class="CELLCOLOR">
<tr>
	<td width="50%" valign="top">
					<table cellspacing="0" cellpadding="2" border="0" width="90%" style="border: solid 1px #b2b2b2; background-color:#E9E9E9;">
					<tr>
						<td valign="top" width="100%"><b>Browse for a <span style="color:red;">{$mode.mode}</span> boxscan and click "submit" to upload it.</b></td>
		
					</tr>
					</table>
					<table cellspacing="0" cellpadding="10" border="0" width="90%" style="border: solid 1px #b2b2b2; background-color:#E9E9E9;">
					
					<tr bgcolor="#EFEFEF">
						<td width="100%" valign="top">
							<br>
								<form enctype="multipart/form-data" name="frmUploadShot" action="db_games_box.php" method="post">		
							
								<input type="file" name="image[1]">
								<input type="hidden" name="game_id" value="{$game_info.game_id}">
								{if $mode.mode eq "back"}
								<input type="hidden" name="mode" value="back">
								<input type="hidden" name="frontscan_id" value="{$mode.frontscan_id}">
								{/if}
								<input type="hidden" name="action" value="boxscan_upload">
								<input type="submit" value="Upload">
								
								</form>
						</td>
					</tr>
					
					</table>		
				</td>
	
	<td width="50%" valign="top">
				
				
				<table cellspacing="0" cellpadding="2" border="0" width="90%" style="border: solid 1px #b2b2b2; background-color:#E9E9E9;">
					<tr>
						<td valign="top" width="100%"><b>Front boxscans</b></td>
					</tr>
					</table>
					{if $nr_front == 0}
					<table cellspacing="0" cellpadding="10" border="0" width="90%" style="border: solid 1px #b2b2b2; background-color:#E9E9E9;">
					<tr bgcolor="{cycle name="tr" values="#EFEFEF,#E9E9E9"}">
						<td width="100%" valign="top">
							No frontscan available
						</td>
					</tr>
					</table>
					{else}
					<table cellspacing="0" cellpadding="10" border="0" width="90%" style="border: solid 1px #b2b2b2; background-color:#E9E9E9;">
					{foreach from=$frontscan item=line}
						<tr bgcolor="{cycle name="tr" values="#EFEFEF,#E9E9E9"}">
						<td width="10%" valign="top">
						{$line.game_boxscan_id}
						</td>
						<td width="20%" valign="top">
						<a style="cursor:pointer;" class="MAINNAV" OnClick="deletescreen({$line.game_boxscan_id},'notback'); return false;">Delete</a>
						</td>
						<td width="20%" valign="top">
						<a href="javascript:void(window.open('../includes/showscreens.php?game_boxscan_id={$line.game_boxscan_id}','4','width={$line.width},height={$line.height},toolbar=no,statusbar=no'))" class="MAINNAV">View</a>
						</td>
						<td width="50%" valign="top">
						<a href="../games/games_box.php?game_id={$game_info.game_id}&mode=back&frontscan_id={$line.game_boxscan_id}" class="MAINNAV">Add Back</a>
						</td>
					</tr>
					{/foreach}
					</table>	
					{/if}
				<br>
				<table cellspacing="0" cellpadding="2" border="0" width="90%" style="border: solid 1px #b2b2b2; background-color:#E9E9E9;">
					<tr>
						<td valign="top" width="100%"><b>Back boxscans</b></td>
		
					</tr>
					</table>
					{if $nr_back == 0}
					<table cellspacing="0" cellpadding="10" border="0" width="90%" style="border: solid 1px #b2b2b2; background-color:#E9E9E9;">
					<tr bgcolor="{cycle name="tr" values="#EFEFEF,#E9E9E9"}">
						<td width="100%" valign="top">
							No backscan available
						</td>
					</tr>
					</table>
					{else}
					<table cellspacing="0" cellpadding="10" border="0" width="90%" style="border: solid 1px #b2b2b2; background-color:#E9E9E9;">
					
					{foreach from=$backscan item=line}
						<tr bgcolor="{cycle name="tr" values="#EFEFEF,#E9E9E9"}">
						<td width="10%" valign="top">
						{$line.game_boxscan_id}
						</td>
						<td width="20%" valign="top">
						<a style="cursor:pointer;" class="MAINNAV" OnClick="deletescreen({$line.game_boxscan_id},back); return false;">Delete</a>
						</td>
						<td width="20%" valign="top">
						<a href="javascript:void(window.open('../includes/showscreens.php?game_boxscan_id={$line.game_boxscan_id}','4','width={$line.width},height={$line.height},toolbar=no,statusbar=no'))" class="MAINNAV">View</a>
						</td>
						<td width="50%" valign="top">
						{if $line.boxscan_cross_id neq ""}
						<span style="color:green;">--> linked to image {$line.boxscan_cross_id}</span>
						{/if}
						</td>
					</tr>
					{/foreach}
					
					</table>
					{/if}
	
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
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
   		<td colspan="3" valign=top align=center>
			<b><a href="../games/games_detail.php?game_id={$game_info.game_id}" class="MAINNAV">back</a></b>
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
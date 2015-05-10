<script type="text/javascript">
function deleteseries()
{literal}	{ {/literal}
    // CONFIRM REQUIRES ONE ARGUMENT
    var message = "Are you sure you want to delete this Serie?";
    // CONFIRM IS BOOLEAN. THAT MEANS THAT
    // IT RETURNS TRUE IF 'OK' IS CLICKED
    // OTHERWISE IT RETURN FALSE
    var return_value = confirm(message);

    if (return_value !="0")
    {literal}	{ {/literal}
    	url="../games/db_games_series.php?action=delete_gameseries&game_series_id={$series_info.game_series_id}";
		location.href=url;
    {literal}	} {/literal}  
{literal}	} {/literal}
</script>
<table align="center" class="HEADERBAR" width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
	<td style="vertical-align:top;" height="5" colspan=6>
	<span class="LEFTNAVHEADING">&nbsp;Game Series</span>
	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="15" align="center" class="CELLCOLOR">
<tr>
	<td>
	
	<table width="100%" cellspacing="2" cellpadding="2" border="0" class="CELLCOLOR" >
			<tr>
    			<td width="16%" valign="top">
				{if (isset($series_info.series_page) and $series_info.series_page eq 'series_editor') or (isset($series_info.series_page) and $series_info.series_page eq 'addgames_series')}<span class="LEFTNAV"><strong>{$series_info.game_series_name} selected</strong></span>{/if}
				</td>
				<td width="84%" align="left" valign="top">
				{if $series_info.series_page eq 'series_editor' or $series_info.series_page eq '' or $series_info.series_page eq 'edit_series' or $series_info.series_page eq 'addgames_series'}
					<a href="../games/games_series_main.php?series_page=add_series">
						<img src="../templates/0/icons/icon_new_series.png" alt="" width="59" height="18" border="0">
					</a> 
				{/if} 
				{if $series_info.series_page eq 'series_editor' or $series_info.series_page eq 'addgames_series'}<a href="../games/games_series_main.php?series_page=edit_series&game_series_id={$series_info.game_series_id}"><img src="../templates/0/icons/icon_edit_series.png" alt="" width="59" height="18" border="0"></a> {/if}
				{if $series_info.series_page eq 'series_editor' or $series_info.series_page eq 'edit_series' or $series_info.series_page eq 'addgames_series'}<a style="cursor: pointer;" onClick="deleteseries(); return false;"><img src="../templates/0/icons/icon_delete_series.png" alt="" width="59" height="18" border="0"></a> {/if}
				{if $series_info.series_page eq 'series_editor' or $series_info.series_page eq 'edit_series'}<a href="../games/games_series_main.php?series_page=addgames_series&game_series_id={$series_info.game_series_id}"><img src="../templates/0/icons/add_games_button.png" alt="" width="59" height="18" border="0"></a> {/if} 
				</td>
			</tr>
	</table>
	
	<br>
	
	<table width="100%" cellspacing="2" cellpadding="2" border="0" class="CELLCOLOR" >
			<tr>
    			<td width="16%" valign="top">
					<table width="100%" border="0" cellspacing="2" cellpadding="2" class="NAVCELL">
						<tr>
    						<td style="text-align: center;" class="HEADERBAR">
								<span class="LEFTNAVHEADING"> Game Series</span>
    						</td>
						</tr>
						<tr>
							<td class="LEFTNAV">
								{foreach from=$game_series item=line}
								<a href="../games/games_series_main.php?series_page=series_editor&amp;game_series_id={$line.game_series_id}" class="LEFTNAV">{$line.game_series_name}</a><br>
								{/foreach}	

							</td>
						</tr>
					</table>
				</td>
				<td width="84%" align="center" valign="top">
				
				{if (isset($series_info.series_page) and $series_info.series_page eq 'add_series')} {include file="../templates/0/games_series_addseries.tpl"} {/if}
				
				{if (isset($series_info.series_page) and $series_info.series_page eq 'edit_series')} {include file="../templates/0/games_series_editseries.tpl"} {/if}
				
				{if (isset($series_info.series_page) and $series_info.series_page eq 'addgames_series')} {include file="../templates/0/games_series_addgames.tpl"} {/if}
				
				{if (isset($series_info.series_page) and $series_info.series_page eq 'series_editor')}
				
				{if (isset($series_info.sql_series_link_nr) and $series_info.sql_series_link_nr < 1)}
				
				No games hooked to this series yet.
				
				{else}
					<form action="../games/db_games_series.php" method="post" name="delete_from_series" id="delete_from_series">	
				<table cellspacing="0" cellpadding="2" border="0" width="95%" style="border: solid 1px #b2b2b2; background-color:#E9E9E9;">
					<tr>
						<td valign="top" width="5%"><b>Info</b></td>
						<td valign="top" width="30%"><b>Game Name</b></td>
						<td valign="top" width="20%"><b>Publisher</b></td>
						<td valign="top" width="20%"><b>Developer</b></td>
						<td valign="top" width="15%"><b>Year</b></td>
					</tr>
				</table>
				<table cellspacing="0" cellpadding="2" border="0" width="95%" style="border: solid 1px #b2b2b2; background-color:#E9E9E9;">
				{foreach from=$series_link item=line}
					<tr bgcolor="{cycle name="tr" values="#EFEFEF,#E9E9E9"}">
						<td width="5%" valign="top">
							<input type="checkbox" name="game_series_cross_id[]" value="{$line.game_series_cross_id}">
						</td>
						<td width="30%" valign="top">
							{if $line.game_name != ''}
								<a href="../administration/construction.php" class="MAINNAV">
									{$line.game_name}
								</a>
							{else}
								<i>n/a</i>
							{/if}
						</td>
						<td width="25%" valign="top">
							{if (isset($line.publisher_name) and $line.publisher_name != '')}
								<a href="games_main.php?publisher={$line.publisher_id}&amp;action=search" class="MAINNAV">
									{$line.publisher_name}
								</a>
							{else}
								<i>n/a</i>
							{/if}
						</td>
						<td width="25%" valign="top">
							{if (isset($line.developer_name) and $line.developer_name != '')}
								<a href="games_main.php?developer={$line.developer_id}&amp;action=search" class="MAINNAV">
									{$line.developer_name}
								</a>
							{else}
								<i>n/a</i>
							{/if}
						</td>				
						<td width="15%" valign="top">
							{if (isset($line.year) and $line.year != '')}
								<a href="games_main.php?year={$line.year}&amp;action=search" class="MAINNAV">
									{$line.year}
								</a>
							{else}
								<i>n/a</i>
							{/if}
						</td>
					</tr>
				{/foreach}
					
				<input type="hidden" name="series_page" value="series_editor">
				<input type="hidden" name="action" value="delete_from_series">
				<input type="hidden" name="game_series_id" value="{$series_info.game_series_id}">
					<tr style="border-top: solid 2px #b2b2b2; background-color:#ffffff;">
						<td colspan="5" style="border-top: solid 2px #b2b2b2; background-color:#ffffff;">
						<img src="../templates/0/images/arrow_ltr.gif" alt="" width="38" height="22" border="0"><input type="submit" value="Delete from series"></td>
					</tr>

				</table>
				</form>
				
				
				
				
				
				{/if}
				
				
				{/if}
				</td>
			</tr>
	</table>
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

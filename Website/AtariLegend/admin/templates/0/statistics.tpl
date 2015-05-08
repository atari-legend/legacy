{* 
/***************************************************************************
*                                statistics.tpl
*                            --------------------------
*   begin                : 2005-01-06
*   copyright            : (C) 2005 Atari Legend
*   email                : admin@atarilegend.com
*
*   Id:  statistics.tpl,v 0.10 2005/01/06 Silver
*
***************************************************************************/
*}

<table width="100%" border="0" cellspacing="0" cellpadding="2" align="center" class="HEADERBAR">
<tr>    
	<td height="5" style="vertical-align:top;">
	<span class="LEFTNAVHEADING">&nbsp;&nbsp;Database statistics</span>
	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="2" align="center" class="CELLCOLOR">
<tr>
	<td>
		<table cellspacing="2" cellpadding="2" border="0" width="100%">
			<tr>
				<td width="50%" valign="top">
					<table cellspacing="0" cellpadding="2" border="0" width="90%" style="border: solid 1px #b2b2b2; background-color:#E9E9E9;">
					<tr>
						<td valign="top" width="25%"><b>Some Stats</b></td>
		
					</tr>
					</table>
					<table cellspacing="0" cellpadding="2" border="0" width="90%" style="border: solid 1px #b2b2b2; background-color:#E9E9E9;">
					{foreach from=$statistics item=line}
					<tr bgcolor="{cycle name="tr" values="#EFEFEF,#E9E9E9"}">
						<td width="100%" valign="top">
							<span style="background-color:{cycle values="#EFEFEF,#E9E9E9"}; font-family:verdana;">{$line.value}</span><br>
						</td>
					</tr>
					{/foreach}
					</table>		
				</td>
				<td width="25%" valign="top">
					<table cellspacing="0" cellpadding="2" border="0" width="90%" style="border: solid 1px #b2b2b2; background-color:#E9E9E9;">
					<tr>
						<td valign="top" width="25%"><b><span style="color:green;">Good Karma</span></b></td>
					</tr>
					</table>	
					<table cellspacing="0" cellpadding="2" border="0" width="90%" style="border: solid 1px #b2b2b2; background-color:#E9E9E9;">
					{foreach from=$karma_good item=line}
					<tr bgcolor="{cycle name="tr" values="#EFEFEF,#E9E9E9"}">
						<td width="75%" valign="top">
							<a href="../user/user_detail.php?user_id_selected={$line.user_id}" class="MAINNAV">{$line.user_name}</a>
						</td>
						<td width="25%" valign="top">
							{$line.karma}
						</td>
					</tr>
					{/foreach}
					</table>
				</td>
				<td width="25%" valign="top">
					<table cellspacing="0" cellpadding="2" border="0" width="90%" style="border: solid 1px #b2b2b2; background-color:#E9E9E9;">
					<tr>
						<td valign="top" width="25%"><b><span style="color:red;">Bad Voodoo</span></b></td>
					</tr>
					</table>	
					<table cellspacing="0" cellpadding="2" border="0" width="90%" style="border: solid 1px #b2b2b2; background-color:#E9E9E9;">
					{foreach from=$karma_bad item=line}
					<tr bgcolor="{cycle name="tr" values="#EFEFEF,#E9E9E9"}">
						<td width="75%" valign="top">
							<a href="../user/user_detail.php?user_id_selected={$line.user_id}" class="MAINNAV">{$line.user_name}</a>						</td>
						<td width="25%" valign="top">
							{$line.karma}
						</td>
					</tr>
					{/foreach}
					</table>
				</td>
			</tr>
		</table>
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
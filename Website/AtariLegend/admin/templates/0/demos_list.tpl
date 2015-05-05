{* 
/***************************************************************************
                              demos_list.tpl
*                            --------------------------
*	begin                : Sunday, October 30, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : admin@atarilegend.com
*
*   Id: demos_list.tpl,v 0.10 2005/10/30 13:54 Gatekeeper
*
***************************************************************************/

************************************************************************************************
The main game page
************************************************************************************************
*}

<table align="center" class="HEADERBAR" width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
	<td style="vertical-align:top;" height="5" colspan=6>
	<span class="LEFTNAVHEADING">&nbsp;Search results</span>
	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="15" align="center" class="CELLCOLOR">
<tr>
	<td colspan="2">
	<fieldset class="category_set">
		This is the search result page. Click a demo to go to the main page. Click a Crew/Year to do a new search.
		If you want to do a new search query or like to add a new demo, click <a href="demos_main.php" class="MAINNAV"><b>here</b></a>!
	</fieldset> 
	</td>
</tr>
<tr>
	<td align="center">
		<table cellspacing="0" cellpadding="2" border="0" width="90%" style="border: solid 1px #b2b2b2; background-color:#E9E9E9;">
		<tr>
			<td valign="top" width="25%"><b>Demo Name</b></td>
			<td valign="top" width="25%"><b>Crew</b></td>
			<td valign="top" width="10%"><b>Year</b></td>
			<td valign="top" width="15%"><b>Info</b></td>			
		</tr>
		</table>
		<table cellspacing="0" cellpadding="2" border="0" width="90%" style="border: solid 1px #b2b2b2; background-color:#E9E9E9;">
		{foreach from=$demo_search item=line}
		<tr bgcolor="{cycle name="tr" values="#EFEFEF,#E9E9E9"}">
			<td width="25%" valign="top">{if $line.demo_name != ''}<a href="demos_detail.php?demo_id={$line.demo_id}" class="MAINNAV">{$line.demo_name}</a>{else}<i>n/a</i>{/if}</td>
			<td width="25%" valign="top">{if $line.crew_name != ''}<a href="demos_main.php?crew={$line.crew_id}&amp;action=search" class="MAINNAV">{$line.crew_name}</a>{else}<i>n/a</i>{/if}</td>
			<td width="10%" valign="top">{if $line.year != ''}<a href="demos_main.php?year={$line.year}&amp;action=search" class="MAINNAV">{$line.year}</a>{else}<i>n/a</i>{/if}</td>
			<td width="15%" valign="top">
				{if $line.screenshot != ''}<img src="../templates/0/icons/screen.gif" alt="Screenshots available" hspace="0" vspace="0" border="0" title="Screenshot Available">{/if}
				{if $line.music != ''}<img src="../templates/0/icons/sound.gif" alt="Music available" hspace="0" vspace="0" border="0" title="Music Available">{/if}
				{if $line.download != ''}<img src="../templates/0/icons/disk.gif" alt="Download available" hspace="0" vspace="0" border="0" title="Download Available">{/if}
				{if $line.ste_enhan != '' or $line.ste_only >='1'}<img src="../templates/0/icons/ste.png" alt="STE Game" hspace="0" vspace="0" border="0" title="STE Game">{/if}
			</td>
		</tr>
		{/foreach}
		</table>	
		<table cellspacing="0" cellpadding="2" border="0" width="90%" style="border-left: solid 1px #b2b2b2; border-left: solid 1px #b2b2b2; border-right: solid 1px #b2b2b2; border-bottom: solid 1px #b2b2b2;background-color:#E9E9E9;">
		<tr>
			<td valign="top" width="100%"><b>{if $nr_of_demos == 1}1 demo found {else} {$nr_of_demos} demos found{/if} in {$query_time} sec</b></td>
		</tr>
		</table>
		<br>
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
			<b><a href="../demos/demos_main.php" class="MAINNAV">back</a></b>
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
<br>
<br>
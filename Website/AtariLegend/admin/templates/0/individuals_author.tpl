{* 
/***************************************************************************
*                                individuals_author.tpl
*                            -----------------------------
*   begin                : Saturday, August 6, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : maarten.martens@freebel.net
*   actual update        : Creation of file
*   Id: individuals_auhtor.php,v 0.10 2005/08/06 19:07 Gatekeeper
*
***************************************************************************/

//****************************************************************************************
// The Author main page
//**************************************************************************************** 
*}

<table align="center" class="HEADERBAR" width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
	<td style="vertical-align:top;" height="5" colspan=6>
	<span class="LEFTNAVHEADING">&nbsp;Add/Edit Author types</span>
	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="15" align="center" class="CELLCOLOR">
<tr>
	<td colspan="2">
	<fieldset class="category_set">
		Here you can add, edit or delete an author type. These groupings are used in the actual game section
		to connect them to a certain genre. 		
	</fieldset> 
	</td>
</tr>
<tr>
	<td>
		{if $load == '1'}
			<form action="../individuals/individuals_author.php" method="post" name="post">
			<fieldset class="links_set">
			<legend class="links_legend">Add a new type</legend>
			<input type="text" name="newtype" value="{$author_types_load.author_type}">
			<input type="hidden" name="action" value="edit">
			<input type="hidden" name="type_id" value="{$author_types_load.author_type_id}">
			<input type="submit" value="Edit">
			</fieldset>
			</form>
		{else}
			<form action="../individuals/individuals_author.php" method="post" name="post">
			<fieldset class="links_set">
			<legend class="links_legend">Add a new type</legend>
			<input type="text" name="newtype">
			<input type="hidden" name="action" value="insert">
			<input type="submit" value="Insert">
			</fieldset>
			</form>
		{/if}
	</td>
</tr>
<tr>
	<td>
		<fieldset class="links_set">
		<legend class="links_legend">Current types</legend>
		<table>
		{foreach from=$author_types item=line} 
		<tr>
			<td align="left" width="70%">{$line.author_type}</td>
			<td align="center" width="15%"><a href="individuals_author.php?type_id={$line.author_type_id}&amp;action=load" class=MAINNAV>Edit</a></td>
			<td align="right" width="15%"><a href="individuals_author.php?type_id={$line.author_type_id}&amp;action=delete" class=MAINNAV>Delete</a></td>
		</tr>
		{/foreach}
		</table>
		</fieldset>
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
			<b><a href="javascript:history.go(-1)" class="MAINNAV">back</a></b>
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
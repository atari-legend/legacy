{* 
/***************************************************************************
*                                company_logos.tpl
*                            --------------------------
*   begin                : Sunday, August 7, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : maarten.martens@freebel.net
*   actual update        : Creation of file
*   Id: company_logos.tpl,v 0.10 2005/08/07 14:29 Gatekeeper
*
***************************************************************************/

************************************************************************************************
The company logos preview page
************************************************************************************************
*}

<table align="center" class="HEADERBAR" width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
	<td style="vertical-align:top;" height="5" colspan=6>
	<span class="LEFTNAVHEADING">&nbsp;Company logos preview</span>
	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="15" align="center" class="CELLCOLOR">
<tr>
	<td colspan="2">
	<fieldset class="category_set">
		This is just an eye candy section with an overview of the current company logos. Clicking on the
		company name will lead you to the appropriate edit page.
	</fieldset> 
	</td>
</tr>
{foreach from=$company item=line}
<tr>
	<td align="left" width="25%">
		<b><a href="../company/company_edit.php?comp_id={$line.comp_id}" class="MAINNAV">{$line.comp_name}</a></b>
	</td>
	<td align="left" width="75%">
		<img src="../includes/showscreens.php?pub_dev_id={$line.comp_id}" border="0">	
	</td>		
</tr>
{/foreach}
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
{* 
/***************************************************************************
*                                interviews_preview.tpl
*                            --------------------------
*   begin                : friday, July 21, 2005
*   copyright            : (C) 2004 Atari Legend
*   email                : admin@atarilegend.com
*
*   Id: interviews_preview.tpl,v 0.10 2005/07/21 1647 ST Graveyard
*
***************************************************************************/

//****************************************************************************************
// this is the template file to generate an interview preview
//**************************************************************************************** 
*}

<table align="center" class="HEADERBAR" width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
	<td style="vertical-align:top;" height="5" colspan=6 width="50%" align="left">
		<span class="LEFTNAVHEADING">&nbsp;Written by <a href="mailto:{if isset($interview.interview_email)}{$interview.interview_email}{/if}?subject=Your interview with {$interview.interview_author} at Atari Legend" class="MAINNAV_WHITE">{$interview.interview_author}</a></span>		
	</td>
	<td style="vertical-align:top;" height="5" colspan=6 width="50%" align="right">
		<span class="LEFTNAVHEADING">{$interview.interview_date}</span>
	</td>			
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="15" align="center" class="CELLCOLOR">
<tr>
	<td>		
		{if $interview.interview_img != 'none'}
			<span style="float:right;"><img src="../includes/show_image.php?file={$interview.interview_img}" alt="{$interview.individual_name}"></span>
		{/if}
		{$interview.interview_chapters}
	</td>
</tr>
</table>
			
<table width="100%" cellspacing="2" cellpadding="15" align="center" class="CELLCOLOR">
<tr>			
	<td width="100%" colspan="4" valign="top">		
		{$interview.interview_text}
	</td>
</tr>
<tr>		
	<td width="100%" colspan="4" align="center" valign="top">		
		<br>
		© 2001 - 2005 by "Atari Legend". All rights reserved.
	</td>
</tr>
</table>

<table align="center" class="HEADERBAR" width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
	<td style="vertical-align:top;" height="5" colspan=6 width="50%" align="left">
		<span class="LEFTNAVHEADING">&nbsp;Written by <a href="mailto:{$interview.interview_email}?subject=Your interview with {$interview.interview_author} at Atari Legend" class="MAINNAV_WHITE">{$interview.interview_author}</a></span>		
	</td>
	<td style="vertical-align:top;" height="5" colspan=6 width="50%" align="right">
		<span class="LEFTNAVHEADING">{$interview.interview_date}</span>
	</td>			
</tr>
</table>
</td>

<td width="30%" align="right" valign="top">
	<table align="center" class="HEADERBAR" width="100%" cellspacing="0" cellpadding="2" border="0">
	<tr>
		<td style="vertical-align:top;" height="5" colspan=6 width="50%" align="left">
			<span class="LEFTNAVHEADING">&nbsp;Screenshots</span>		
		</td>
	</tr>
	</table>
	<table width="100%" cellspacing="2" cellpadding="15" align="center" class="CELLCOLOR">
	<tr>			
		<td width="100%" valign="top">
			{foreach from=$screenshots item=line} 
				<table width="100%">
				<tr>
   					 <td align="center">
					 	<img src="../includes/show_image.php?file={$line.screenshot}&amp;w=120&amp;shadow=0&amp;bgcolour=a2a2a2" border="1">
					</td>
				</tr>
				<tr>
					<td width="100%" align="center">
						{$line.comment}
					</td>
				</tr>
				</table>
				<br>
				<br>
			{/foreach}
		</td>
	</tr>
	</table>
	<table align="center" class="HEADERBAR" width="100%" cellspacing="0" cellpadding="2" border="0">
	<tr>
		<td style="vertical-align:top;" height="5" colspan=6 width="50%" align="right">
		</td>
	</tr>
	</table>
</td>
</tr>
</table>
<td width="1%">&nbsp;</td>
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

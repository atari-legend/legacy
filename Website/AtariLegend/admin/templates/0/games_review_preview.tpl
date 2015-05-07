{* 
/***************************************************************************
*                               games_review_preview.tpl
*                            -------------------------------
*   begin                : Saturday, December 03, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : admin@atarilegend.com
*
*   Id: games_review_preview.tpl,v 0.10 2005/12/03 17:40 ST Graveyard
*
***************************************************************************/
//****************************************************************************************
// this is the template file to generate a game review
//**************************************************************************************** 
*}

<table align="center" class="HEADERBAR" width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
	<td style="vertical-align:top;" height="5" colspan=6 width="50%" align="left">
		<span class="LEFTNAVHEADING">&nbsp;Written by {if $review.email != ''}<a href="mailto:{$review.email}?subject=Your review of {$review.game_name} at Atari Legend" class="MAINNAV_WHITE">{$review.user_name}</a>{else}{$review.user_name}{/if}</span>		
	</td>
	<td style="vertical-align:top;" height="5" colspan=6 width="50%" align="right">
		<span class="LEFTNAVHEADING">{$review.date}</span>
	</td>			
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="15" align="center" class="CELLCOLOR">
<tr>			
	<td width="100%" colspan="4" valign="top">		
		{$review.text}
	</td>
</tr>
<tr>			
	<td>
		<table align="center" cellspacing="0" cellpadding="2" border="0" width="90%" style="border: solid 1px #b2b2b2; background-color:white;">
		<tr>	
			<td class="main_text" width="25%" align="center" valign="top">		
				Graphics : <b>{$score.graphics} </b>
			</td>
			<td class="main_text" width="25%" align="center" valign="top">	
				Sound : <b>{$score.sound} </b>
			</td>
			<td class="main_text" width="25%" align="center" valign="top">		
				Gameplay : <b>{$score.gameplay} </b>
			</td>
			<td class="main_text" width="25%" align="center" valign="top">		
				Overall : <b>{$score.overall} </b>
			</td>
		</tr>
		</table>
	</td>
</tr>
<tr>		
	<td width="100%" colspan="4" align="center" valign="top">		
		<br>
		� 2001 - 2005 by "Atari Legend". All rights reserved.
	</td>
</tr>
</table>
<table align="center" class="HEADERBAR" width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
	<td style="vertical-align:top;" height="5" colspan=6 width="50%" align="left">
		<span class="LEFTNAVHEADING">&nbsp;Written by {if $review.email != ''}<a href="mailto:{$review.email}?subject=Your review of {$review.game_name} at Atari Legend" class="MAINNAV_WHITE">{$review.user_name}</a>{else}{$review.user_name}{/if}</span>		
	</td>
	<td style="vertical-align:top;" height="5" colspan=6 width="50%" align="right">
		<span class="LEFTNAVHEADING">{$review.date}</span>
	</td>			
</tr>
</table>

<td width="25%" align="right" valign="top">
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
					 	<img src="../includes/show_image.php?file={$line.screenshot}&resize=410,null,null,null&crop=left,top,410,260&minimum_size=410,260" border="1">
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

	

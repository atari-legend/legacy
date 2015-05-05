{* 
/***************************************************************************
*                                games_review_add.tpl
*                            --------------------------
*   begin                : Sunday, November 27, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : maarten.martens@freebel.net
*   actual update        : created this page
*
*   Id: games_review_add.tpl,v 0.10 2005/11/27 Gatekeeper
*
***************************************************************************/

///****************************************************************************************
// This is the sub template file to generate the reviews add page
//**************************************************************************************** 
*}

{* load the button javascripts *}
{include file="../templates/0/js/game_comment.js"}

{* popup_init must be called once at the top of the page *}
{popup_init src="../templates/0/js/overlib.js"}

<form action="../games/games_review_add.php" method="post" name="post">
<table align="center" class="HEADERBAR" width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
	<td style="vertical-align:top;" height="5" colspan=6>
	<span class="LEFTNAVHEADING">&nbsp;Add review - <a href="../games/games_detail.php?game_id={$game.game_id}" class="MAINNAV_WHITE">{$game.game_name}</a></span>
	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="15" align="center" class="CELLCOLOR">
<tr>
	<td>
	<fieldset class="category_set">
		At this page you can add a new review in the AL database.
	</fieldset> 
	<br>
	<br>
	<table width="50%" cellspacing="0" cellpadding="0">
	<tr>
		<td width="50%">
		<fieldset class="game_set">
		<legend class="links_legend">Other reviews</legend>
			<table>
			<tr>
				<td width="100%" align="left" colspan="3">
				{foreach from=$review item=line}
					<b>Review {$line.review_nr} ::  <a href="../games/games_review_edit.php?reviewid={$line.review_id}&amp;game_id={$game.game_id}" class="MAINNAV">Edit</a> :: <a href="../games/games_review_preview.php?review_id={$line.review_id}&game_id={$game.game_id}" class="MAINNAV"> Preview </a>by {$line.user_name}</b><br>
				{/foreach}	
				</td>
			</tr>
			</table>
		</fieldset>
		</td>
	</tr>
	</table>
	<br>
	<br>
	<table width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%">
			<b>Written by :</b>
		</td>
		<td width="90%">
			<select name="members" class="links_selector">
				<option value="-" selected>-</option>
				{foreach from=$authors item=line}
					<option value="{$line.user_id}">{$line.user_name}</option>
				{/foreach}	
			</select>
		</td>
	</tr>
	</table>
	<table width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%">
			<b>Date :</b>
		</td>
		<td width="90%">
			{html_select_date start_year="2000"}
		</td>
	</tr>
	<tr>
		<td align="right" colspan="3">
			<br>
			&nbsp;<input type="text" size="60" name="helpbox" maxlength="100" style="font-size:10px; border=0px; background-color:#D0D1DF" value="Tip: Styles can be applied quickly to selected text." />
		</td>
	</tr>
	</table>
	<table width="100%" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td width="100%" colspan="8">
			<br>
			<br>
			<b>Review :</b>
		</td>
	</tr>
	<tr>
		<td width="100%" align="left" colspan="8">
			<br>
			<input type="button" accesskey= "b" name="addbbcode0" value="B" onclick="bbstyle(0,'textfield')" onMouseOver="helpline('b')" />
			<input type="button" accesskey= "u" name="addbbcode4" value="U" onclick="bbstyle(4,'textfield')" onMouseOver="helpline('u')" />
			<input type="button" accesskey= "i" name="addbbcode2" value="I" onclick="bbstyle(2,'textfield')" onMouseOver="helpline('i')" />
			<input type="button" accesskey="w" name="addbbcode6" value="URL" onClick="bbstyle(6,'textfield')" onMouseOver="helpline('h')" />			  
			<input type="button" accesskey="x" name="addbbcode8" value="@" onClick="bbstyle(8,'textfield')" onMouseOver="helpline('e')" />			  			
			<input type="button" accesskey= "t" name="addbbcode12" value="Hotspot Target" onclick="bbstyle(12,'textfield')" onMouseOver="helpline('t')" />		 
			&nbsp;
			&nbsp;
			<a href="javascript:setsmileyn(' :-D ')"><img src="../templates/0/emoticons/icon_biggrin.gif" alt="Very Happy" border="0" onMouseOver="helpline('x')"></a>
			<a href="javascript:setsmileyn(' :) ')"><img src="../templates/0/emoticons/icon_smile.gif" alt="Smile" border="0" onMouseOver="helpline('x')"></a>
			<a href="javascript:setsmileyn(' :( ')"><img src="../templates/0/emoticons/icon_sad.gif" alt="sad" border="0" onMouseOver="helpline('x')"></a> 
			<a href="javascript:setsmileyn(' 8O ')"><img src="../templates/0/emoticons/icon_eek.gif" alt="shocked" border="0" onMouseOver="helpline('x')"></a>
			<a href="javascript:setsmileyn(' :? ')"><img src="../templates/0/emoticons/icon_confused.gif" alt="confused" border="0" onMouseOver="helpline('x')"></a>
			<a href="javascript:setsmileyn(' 8)')"><img src="../templates/0/emoticons/icon_cool.gif" alt="Cool" border="0" onMouseOver="helpline('x')"></a>
			<a href="javascript:setsmileyn(' :x ')"><img src="../templates/0/emoticons/icon_mad.gif" alt="Mad" border="0" onMouseOver="helpline('x')"></a>
			<a href="javascript:setsmileyn(' :P ')"><img src="../templates/0/emoticons/icon_razz.gif" alt="Razz" border="0" onMouseOver="helpline('x')"></a>
			<a href="javascript:setsmileyn(' :oops: ')"><img src="../templates/0/emoticons/icon_redface.gif" alt="Embarassed" border="0" onMouseOver="helpline('x')"></a>
			<a href="javascript:setsmileyn(' :evil: ')"><img src="../templates/0/emoticons/icon_evil.gif" alt="Evil or Very mad" border="0" onMouseOver="helpline('x')"></a>
			<a href="javascript:setsmileyn(' :twisted: ')"><img src="../templates/0/emoticons/icon_twisted.gif" alt="Twisted Evil" border="0" onMouseOver="helpline('x')"></a>
			<a href="javascript:setsmileyn(' :roll: ')"><img src="../templates/0/emoticons/icon_rolleyes.gif" alt="Rolling eyes" border="0" onMouseOver="helpline('x')"></a>
			<a href="javascript:setsmileyn(' :frown: ')"><img src="../templates/0/emoticons/icon_frown.gif" alt="Frowning" border="0" onMouseOver="helpline('x')"></a>
			<a href="javascript:setsmileyn(' :| ')"><img src="../templates/0/emoticons/icon_neutral.gif" alt="Neutral" border="0" onMouseOver="helpline('x')"></a>
			<a href="javascript:setsmileyn(' :mrgreen: ')"><img src="../templates/0/emoticons/icon_mrgreen.gif" alt="Mr. Green" border="0" onMouseOver="helpline('x')"></a>
			<a href="javascript:setsmileyn(' :o ')"><img src="../templates/0/emoticons/icon_surprised.gif" alt="Surprised" border="0" onMouseOver="helpline('x')"></a>
			<a href="javascript:setsmileyn(' :lol: ')"><img src="../templates/0/emoticons/icon_lol.gif" alt="Laughing" border="0" onMouseOver="helpline('x')"></a>
			<a href="javascript:setsmileyn(' :cry: ')"><img src="../templates/0/emoticons/icon_cry.gif" alt="Crying or Very sad" border="0" onMouseOver="helpline('x')"></a>
			<a href="javascript:setsmileyn(' :wink: ')"><img src="../templates/0/emoticons/icon_wink.gif" alt="Wink" border="0" onMouseOver="helpline('x')"></a>
			<a href="javascript:setsmileyn(' :!: ')"><img src="../templates/0/emoticons/icon_exclaim.gif" alt="Exclamation" border="0" onMouseOver="helpline('x')"></a>
			<a href="javascript:setsmileyn(' :arrow: ')"><img src="../templates/0/emoticons/icon_arrow.gif" alt="smilie" border="0" onMouseOver="helpline('x')"></a>
			<a href="javascript:setsmileyn(' :?: ')"><img src="../templates/0/emoticons/icon_question.gif" alt="Question" border="0" onMouseOver="helpline('x')"></a>
			<a href="javascript:setsmileyn(' :idea: ')"><img src="../templates/0/emoticons/icon_idea.gif" alt="Idea" border="0" onMouseOver="helpline('x')"></a>
		</td>	
	</tr>
	<tr>
		<td width="100%" colspan="8">
			<textarea name="textfield" ONSELECT="javascript:storeCaret(this);" ONCLICK="javascript:storeCaret(this);" ONKEYUP="javascript:storeCaret(this);" ONCHANGE="javascript:storeCaret(this);" rows="15" class="textarea_interviews"></textarea>
		</td>
	</tr>
	</table>
	<br>
	<br>
	<table width="100%" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td width="15%" align="right">
			<b>Graphics :</b> &nbsp;
		</td>
		<td width="10%" align="left">
			<input type="text" name="graphics" class="gamescore">
		</td>
		<td width="15%" align="right">
			<b>Sound :</b> &nbsp;
		</td>
		<td width="10%" align="left">
			<input type="text" name="sound" class="gamescore">
		</td>
		<td width="15%" align="right">
			<b>Gameplay :</b> &nbsp;
		</td>
		<td width="10%" align="left">
			<input type="text" name="gameplay" class="gamescore">
		</td>
		<td width="15%" align="right">
			<b>Conclusion :</b> &nbsp;
		</td>
		<td width="10%" align="left">
			<input type="text" name="conclusion" class="gamescore">
		</td>
	</tr>
	</table>	
	<table width="100%" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td valign="top" width="100%" align="center">
		<br>
		<br>
		<fieldset class="interview_set_screenshot">
		<legend class="links_legend">Screenshots</legend>
		{if $screenshots_nr <> 0}
			{foreach from=$screenshots item=line} 
				<img src="../includes/showimage.php?img={$line.screenshot_link}&amp;w=60&amp;shadow=1&amp;bgcolour=ffffff" align="center">
				<input class="review_input" type="text" name="inputfield[]">
				<br>
				<br>
			{/foreach}
		{else}
			There are currently no screenshots attached to this game. Go to the<a href="../games/games_detail.php?game_id={$game.game_id}" class="MAINNAV"> screenshot adding</a>
			page to link specific screenshots to this game. 
		{/if}
		</fieldset> 
		</td>
	</tr>
	</table>	
	<table width="100%" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td valign="top" width="100%">
			<br>
			<br>
			<input type="hidden" name="action" value="add_review">
			<input type="hidden" name="game_id" value="{$game.game_id}">
			<input type="submit" name="Create Review" value="Create Review">
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

</form>
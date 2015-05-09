{* 
/***************************************************************************
*                                interviews_edit.tpl
*                            --------------------------
*   begin                : Saturday, July 22 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : maarten.martens@freebel.net
*   actual update        : created this page
*
*   Id: interviews_edit.tpl,v 0.10 2005/07/22 13:40 Gatekeeper
*
***************************************************************************/

///****************************************************************************************
// This is the sub template file to generate the interviews edit page
//**************************************************************************************** 
*}

{literal}
<script type="text/javascript">
function deletecomment(screenshot_id, interview_id)
{	
	// CONFIRM REQUIRES ONE ARGUMENT
    var message = "Are you sure you want to delete the screenshot with its comment?";
    // CONFIRM IS BOOLEAN. THAT MEANS THAT
    // IT RETURNS TRUE IF 'OK' IS CLICKED
    // OTHERWISE IT RETURN FALSE
    var return_value = confirm(message);
	if (return_value !="0")
    {
      	url="interviews_edit.php?interview_id="+interview_id+"&screenshot_id="+screenshot_id+"&action=delete_comment";
		location.href=url;
    }
}

function deleteinterview(interview_id)
{	
	// CONFIRM REQUIRES ONE ARGUMENT
    var message = "Are you sure you want to delete this interview?";
    // CONFIRM IS BOOLEAN. THAT MEANS THAT
    // IT RETURNS TRUE IF 'OK' IS CLICKED
    // OTHERWISE IT RETURN FALSE
    var return_value = confirm(message);
	if (return_value !="0")
    {
      	url="interviews_delete.php?interview_id="+interview_id;
		location.href=url;
    }
}
</script>
{/literal}
		
{* load the button javascripts *}
{include file="../templates/0/js/game_comment.js"}

{* popup_init must be called once at the top of the page *}
{popup_init src="../templates/0/js/overlib.js"}

<form action="../interviews/interviews_edit.php" method="post" name="post">
<table align="center" class="HEADERBAR" width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
	<td style="vertical-align:top;" height="5" colspan=6>
	<span class="LEFTNAVHEADING">&nbsp;Edit Interviews - <a href="../individuals/individuals_edit.php?ind_id={$interview.interview_ind_id}" class="MAINNAV_WHITE">{$interview.interview_ind_name}</a></span>
	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="15" align="center" class="CELLCOLOR">
<tr>
	<td>
	<fieldset class="category_set">
		At this page you can change an existing interview in the AL database. the screen might seem a little complex,
		therefor I suggest you first read the <b><a href="../interviews/interviews_help.php" class="LEFTNAV">help</a></b> provided with this section!
	</fieldset> 
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
					{if $line.user_id == $interview.interview_author}
						<option value="{$line.user_id}" selected>{$line.user_name}</option>
					{else}
						<option value="{$line.user_id}">{$line.user_name}</option>
					{/if}
				{/foreach}	
			</select>
		</td>
	</tr>
	<tr>
		<td width="10%">
			<b>Individual :</b>
		</td>
		<td width="90%">
			<select name="individual" class="links_selector">
				<option value="-" selected>-</option>
				{foreach from=$individuals item=line}
					{if $line.ind_id == $interview.interview_ind_id}
						<option value="{$line.ind_id}" selected>{$line.ind_name}</option>
					{else}
						<option value="{$line.ind_id}">{$line.ind_name}</option>
					{/if}
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
			{html_select_date time=$interview.interview_date start_year="2000"}
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
		<td width="100%">
			<br>
			<b>Intro :</b>
		</td>
	</tr>
	<tr>
		<td width="100%" align="left">
			<br>
			<input type="button" accesskey= "b" name="addbbcode0" value="B" onclick="bbstyle(0,'textintro')" onMouseOver="helpline('b')" />
			<input type="button" accesskey= "u" name="addbbcode4" value="U" onclick="bbstyle(4,'textintro')" onMouseOver="helpline('u')" />
			<input type="button" accesskey= "i" name="addbbcode2" value="I" onclick="bbstyle(2,'textintro')" onMouseOver="helpline('i')" />
			<input type="button" accesskey="w" name="addbbcode6" value="URL" onClick="bbstyle(6,'textintro')" onMouseOver="helpline('h')" />			  
			<input type="button" accesskey="x" name="addbbcode8" value="@" onClick="bbstyle(8,'textintro')" onMouseOver="helpline('e')" />			  			
			&nbsp;
			&nbsp;
			<a href="javascript:setsmileyn2(' :-D ')"><img src="../templates/0/emoticons/icon_biggrin.gif" alt="Very Happy" border="0" onMouseOver="helpline('x')"></a>
			<a href="javascript:setsmileyn2(' :) ')"><img src="../templates/0/emoticons/icon_smile.gif" alt="Smile" border="0" onMouseOver="helpline('x')"></a>
			<a href="javascript:setsmileyn2(' :( ')"><img src="../templates/0/emoticons/icon_sad.gif" alt="sad" border="0" onMouseOver="helpline('x')"></a> 
			<a href="javascript:setsmileyn2(' 8O ')"><img src="../templates/0/emoticons/icon_eek.gif" alt="shocked" border="0" onMouseOver="helpline('x')"></a>
			<a href="javascript:setsmileyn2(' :? ')"><img src="../templates/0/emoticons/icon_confused.gif" alt="confused" border="0" onMouseOver="helpline('x')"></a>
			<a href="javascript:setsmileyn2(' 8)')"><img src="../templates/0/emoticons/icon_cool.gif" alt="Cool" border="0" onMouseOver="helpline('x')"></a>
			<a href="javascript:setsmileyn2(' :x ')"><img src="../templates/0/emoticons/icon_mad.gif" alt="Mad" border="0" onMouseOver="helpline('x')"></a>
			<a href="javascript:setsmileyn2(' :P ')"><img src="../templates/0/emoticons/icon_razz.gif" alt="Razz" border="0" onMouseOver="helpline('x')"></a>
			<a href="javascript:setsmileyn2(' :oops: ')"><img src="../templates/0/emoticons/icon_redface.gif" alt="Embarassed" border="0" onMouseOver="helpline('x')"></a>
			<a href="javascript:setsmileyn2(' :evil: ')"><img src="../templates/0/emoticons/icon_evil.gif" alt="Evil or Very mad" border="0" onMouseOver="helpline('x')"></a>
			<a href="javascript:setsmileyn2(' :twisted: ')"><img src="../templates/0/emoticons/icon_twisted.gif" alt="Twisted Evil" border="0" onMouseOver="helpline('x')"></a>
			<a href="javascript:setsmileyn2(' :roll: ')"><img src="../templates/0/emoticons/icon_rolleyes.gif" alt="Rolling eyes" border="0" onMouseOver="helpline('x')"></a>
			<a href="javascript:setsmileyn2(' :frown: ')"><img src="../templates/0/emoticons/icon_frown.gif" alt="Frowning" border="0" onMouseOver="helpline('x')"></a>
			<a href="javascript:setsmileyn2(' :| ')"><img src="../templates/0/emoticons/icon_neutral.gif" alt="Neutral" border="0" onMouseOver="helpline('x')"></a>
			<a href="javascript:setsmileyn2(' :mrgreen: ')"><img src="../templates/0/emoticons/icon_mrgreen.gif" alt="Mr. Green" border="0" onMouseOver="helpline('x')"></a>
			<a href="javascript:setsmileyn2(' :o ')"><img src="../templates/0/emoticons/icon_surprised.gif" alt="Surprised" border="0" onMouseOver="helpline('x')"></a>
			<a href="javascript:setsmileyn2(' :lol: ')"><img src="../templates/0/emoticons/icon_lol.gif" alt="Laughing" border="0" onMouseOver="helpline('x')"></a>
			<a href="javascript:setsmileyn2(' :cry: ')"><img src="../templates/0/emoticons/icon_cry.gif" alt="Crying or Very sad" border="0" onMouseOver="helpline('x')"></a>
			<a href="javascript:setsmileyn2(' :wink: ')"><img src="../templates/0/emoticons/icon_wink.gif" alt="Wink" border="0" onMouseOver="helpline('x')"></a>
			<a href="javascript:setsmileyn2(' :!: ')"><img src="../templates/0/emoticons/icon_exclaim.gif" alt="Exclamation" border="0" onMouseOver="helpline('x')"></a>
			<a href="javascript:setsmileyn2(' :arrow: ')"><img src="../templates/0/emoticons/icon_arrow.gif" alt="smilie" border="0" onMouseOver="helpline('x')"></a>
			<a href="javascript:setsmileyn2(' :?: ')"><img src="../templates/0/emoticons/icon_question.gif" alt="Question" border="0" onMouseOver="helpline('x')"></a>
			<a href="javascript:setsmileyn2(' :idea: ')"><img src="../templates/0/emoticons/icon_idea.gif" alt="Idea" border="0" onMouseOver="helpline('x')"></a>
		</td>
	</tr>
	<tr>
		<td width="100%">
			<textarea name="textintro" ONSELECT="javascript:storeCaret(this);" ONCLICK="javascript:storeCaret(this);" ONKEYUP="javascript:storeCaret(this);" ONCHANGE="javascript:storeCaret(this);" rows="5" class="textarea_interviews">{$interview.interview_intro}</textarea>
		</td>
	</tr>				
	<tr>
		<td width="100%">
			<br>
			<br>
			<b>Chapters :</b>
		</td>
	</tr>
	<tr>
		<td width="100%" align="left">
			<br>
			<input type="button" accesskey= "b" name="addbbcode0" value="B" onclick="bbstyle(0,'textchapters')" onMouseOver="helpline('b')" />
			<input type="button" accesskey= "u" name="addbbcode4" value="U" onclick="bbstyle(4,'textchapters')" onMouseOver="helpline('u')" />
			<input type="button" accesskey= "i" name="addbbcode2" value="I" onclick="bbstyle(2,'textchapters')" onMouseOver="helpline('i')" />
			<input type="button" accesskey="w" name="addbbcode6" value="URL" onClick="bbstyle(6,'textchapters')" onMouseOver="helpline('h')" />			  
			<input type="button" accesskey="x" name="addbbcode8" value="@" onClick="bbstyle(8,'textchapters')" onMouseOver="helpline('e')" />			  			
			<input type="button" accesskey= "s" name="addbbcode10" value="Hotspot Source" onclick="bbstyle(10,'textchapters')"  onMouseOver="helpline('s')" />
		</td>	
	</tr>
	<tr>
		<td width="100%">
			<textarea name="textchapters" ONSELECT="javascript:storeCaret(this);" ONCLICK="javascript:storeCaret(this);" ONKEYUP="javascript:storeCaret(this);" ONCHANGE="javascript:storeCaret(this);" rows="5" class="textarea_interviews">{$interview.interview_chapters}</textarea>
		</td>
	</tr>
	<tr>
		<td width="100%">
			<br>
			<br>
			<b>Interview :</b>
		</td>
	</tr>
	<tr>
		<td width="100%" align="left">
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
		<td width="100%">
			<textarea name="textfield" ONSELECT="javascript:storeCaret(this);" ONCLICK="javascript:storeCaret(this);" ONKEYUP="javascript:storeCaret(this);" ONCHANGE="javascript:storeCaret(this);" rows="15" class="textarea_interviews">{$interview.interview_text}</textarea>
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
		{if $screenshots_nr <> ''}
			{foreach from=$screenshots item=line} 
				<img src="../includes/show_image.php?file={$line.interview_screenshot}&resize=50,null,null,null&crop=null,null,null,null" align="center">
				<input class="review_input" type="text" name="inputfield[]" value="{$line.interview_screenshot_comment}">
				<a href="javascript:deletecomment({$line.interview_screenshot_id},{$interview.interview_id})" class="MAINNAV">Delete Shot</a>
				<br>
				<br>
			{/foreach}
		{else}
			There are currently no screenshots attached to this interview. Go to the <a href="interviews_screenshots_add.php?interview_id={$interview.interview_id}" class="MAINNAV">screenshot adding</a>
			page to link specific screenshots to this interview. Remember that you have to create an interview first before actually uploading screenshots!			
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
			<input type="hidden" name="interview_id" value="{$interview.interview_id}">
			<input type="hidden" name="action" value="Update_Interview">
			<input type="submit" name="update" value="Update interview">
			<input type="button" name="delete" value="Delete interview" onclick="deleteinterview({$interview.interview_id})">
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

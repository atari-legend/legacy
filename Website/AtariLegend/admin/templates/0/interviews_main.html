{* 
/***************************************************************************
*                                interviews_main.tpl
*                            ------------------------------
*   begin                : Thursday, July 21, 2005
*   copyright            : (C) 2003 Atari Legend
*   email                : maarten.martens@freebel.net
*   actual update        : Start of creation file
*
*   Id: interviews_main.tpl,v 0.10 21/07/2005 22:17 Gatekeeper
*
***************************************************************************

///****************************************************************************************
// This is the sub template file to generate the interviews main
//**************************************************************************************** 
*}

{literal}
<script type="text/javascript">
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

<table align="center" class="HEADERBAR" width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
	<td style="vertical-align:top;" height="5" colspan=6>
	<span class="LEFTNAVHEADING">&nbsp;Interviews</span>
	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="15" align="center" class="CELLCOLOR">
<tr>
	<td>
	<fieldset class="category_set">
		Overhere you can add a new interview or edit an existing interview. If you like to edit an interview,
		just look up the person in the dropdown list and press <b>search</b>. If you like a list of all interviewed
		people, just press search without making a selection. If you like to add an interview, select the person
		and press the <b>add</b> button.
	</fieldset> 
	<br>
	<br>
	<table width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td align="center" width="55%">
		<form action="../interviews/interviews_main.php" method="post" name="search">
		<fieldset class="interview_set">
		<legend class="links_legend">Search for an Interview</legend>
		<select name="individual_search" class="links_selector">
			<option value="-" selected>-</option>
			{foreach from=$individuals_interviewed item=line}
				<option value="{$line.ind_id}">{$line.ind_name}</option>
			{/foreach}	
		</select>
		<input type="submit" value="Search">
		</fieldset>
		<input type="hidden" name="action" value="search">
		<input type="hidden" name="user_id" id="user_id" value="{$user_id}">
		</form>	
		</td>
		<td align="center" width="50%">
		<form action="../interviews/interviews_add.php" method="post" name="insert">
		<fieldset class="interview_set">
		<legend class="links_legend">Add an Interview</legend>
		<select name="individual_create" class="links_selector">
			<option value="-" selected>-</option>
			{foreach from=$individuals item=line}
				<option value="{$line.ind_id}">{$line.ind_name}</option>
			{/foreach}	
		</select>
		<input type="submit" value="Add">
		</fieldset>
		<input type="hidden" name="user_id" id="user_id" value="{$user_id}">
		</form>	
		</td>
	</tr>
	</table>
	</td>
</tr>
{if isset($interview)}
{foreach from=$interview item=line}
<tr>
	<td align="center">
		<fieldset class="news_set">
		<legend class="links_legend">
		{if $line.user_email <> ''}	
			Written by <a href="mailto:{$line.user_email}?subject=Your interview with {$line.ind_name} at Atari Legend" class="MAINNAV">{$line.user_id}</a> on {$line.interview_date}
		{else}
			Written by {$line.user_id} on {$line.interview_date}
		{/if}	
		</legend>
		<table>
		<tr>
			<td width="100%" valign="top" align="left" colspan="2">
				Interview with <a href="../individuals/individuals_edit.php?ind_id={$line.ind_id}" class="MAINNAV"><b>{$line.ind_name}</b></a>
				<br>
				<br>
			</td>
		</tr>
		<tr>
			<td width="20%" valign="top" align="left">
			{if $line.ind_photo == 'none'}
				<img src="../includes/show_image.php?file=../templates/0/images/unknown.png">
			{else}
				<img src="../includes/show_image.php?file={$line.ind_photo}&resize=210,null,null,null" alt="photo">
			{/if}
			</td>
			<td width="80%" align="left">
				<i>{$line.interview_text}</i>
			</td>
		</tr>
		<tr>
			<td width="100%" valign="top" align="center" colspan="2">
				<br>
				<a href="interviews_edit.php?interview_id={$line.interview_id}" class="MAINNAV">EDIT</a> :: <a href="javascript:deleteinterview({$line.interview_id})" class="MAINNAV">DELETE</a> :: <a href="interviews_preview.php?interview_id={$line.interview_id}" class="MAINNAV">PREVIEW</a> :: <a href="interviews_screenshots_add.php?interview_id={$line.interview_id}" class="MAINNAV">ADD SCREENSHOTS</a>
			</td>
		</tr>
		</table>
		</fieldset> 
	</td>
</tr>
{/foreach}
{/if}
</table>

<table width="100%" cellspacing="2" cellpadding="15" align="center" class="CELLCOLOR">
<tr>
	<td>
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

{if isset($message) and $message <> ''}
	<table align="center" width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td align="center" >
			<br><br>
			<span class="MAINAV">{$message}</span>
		</td>
	</tr>
	</table>
{/if}

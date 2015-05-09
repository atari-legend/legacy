<script language="JavaScript">
function commentdelete(JSsubID)
{literal}{ {/literal}  
	
	JSview = "{$structure.list}";
	JSv_count = {$structure.v_counter};
	
    	// CONFIRM REQUIRES ONE ARGUMENT
    	var message = "Are you sure you want to delete this submission?";
    	// CONFIRM IS BOOLEAN. THAT MEANS THAT
    	// IT RETURNS TRUE IF 'OK' IS CLICKED
    	// OTHERWISE IT RETURN FALSE
    	var return_value = confirm(message);

    	if (return_value !="0")
    	{literal}{ {/literal} 
    		url="../games/db_games_submissions.php?action=delete_submission&submit_id="+JSsubID+"&v_counter="+JSv_count+"&list="+JSview+""
			location.href=url;
    	{literal}}  {/literal} 
{literal}} {/literal} 
</script>

<script language="JavaScript">
function submovetocomment(JSsubID)
{literal}{ {/literal}  
	
	JSview = "{$structure.list}";
	JSv_count = {$structure.v_counter};
	
    	// CONFIRM REQUIRES ONE ARGUMENT
    	var message = "Are you sure you want to move this submission to comments?";
    	// CONFIRM IS BOOLEAN. THAT MEANS THAT
    	// IT RETURNS TRUE IF 'OK' IS CLICKED
    	// OTHERWISE IT RETURN FALSE
    	var return_value = confirm(message);

    	if (return_value !="0")
    	{literal}{ {/literal} 
    		url="../games/db_games_submissions.php?action=move_submission_tocomment&submit_id="+JSsubID+"&v_counter="+JSv_count+"&list="+JSview+""
			location.href=url;
    	{literal}}  {/literal} 
{literal}} {/literal} 
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="2" align="center" class="HEADERBAR">
<tr>    
	<td height="5" style="vertical-align:top;">
	<span class="LEFTNAVHEADING">&nbsp;&nbsp;Game Submissions</span>
	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="15" class="CELLCOLOR">
<tr>
	<td align="center">
	<fieldset class="category_set">
		<table>
		<tr>
			<td width="100%" valign="top">
				When you have finished reviewing the submitted data move the submission to the "Done list" by clicking the appropriate Done button. 
				Users have submitted a total of <b>{$total_nr_submissions}</b> entries in the AL DB!
			</td>
		</tr>
		</table>
	</fieldset> 
	</td>
</tr>
</table>
 
<table width="100%" cellspacing="2" cellpadding="15" align="center" class="CELLCOLOR">
<tr>
	<td align="center">
		{if $structure.list == 'current'}
		<strong><a href="../games/submission_games.php?list=done" class="MAINNAV">Switch to Done list</a></strong><br>
		{elseif $structure.list == 'done'}
		<strong><a href="../games/submission_games.php?list=current" class="MAINNAV">Switch to Current list</a></strong><br>
		{/if}
		<br>
		<table width="400" border="0" cellspacing="2" cellpadding="2">
			<tr>
				<td width="50%" align="left">
			{if $structure.v_counter > 0}
	
			<strong><a href="../games/submission_games.php?list={$structure.list}&amp;v_counter={$structure.back_arrow}" class="MAINNAV">Previous</a></strong>
	
			{/if}
				</td>
				<td width="50%" align="right">

			{if $structure.forward_arrow >= 25}
	
			<strong><a href="../games/submission_games.php?list={$structure.list}&amp;v_counter={$structure.forward_arrow}" class="MAINNAV">Next</a></strong>
	
			{/if}
				</td>
			</tr>
		</table>

		<br>
		
		{foreach from=$submission item=line}
				<table cellspacing="0" cellpadding="2" border="0" width="95%" style="border: solid 1px #b2b2b2; background-color:#E9E9E9;">
				<tr>
						<td class="main_text" valign="top" width="150" style="border-right: solid 1px #b2b2b2;"><b>Posted by <a href="../user/user_detail.php?user_id_selected={$line.user_id}" class="links_links">{$line.user_name}</a></b></td>
						<td class="main_text" valign="top" ><b><a href="../games/games_detail.php?game_id={$line.game_id}" class="links_links">{$line.game_name}</a></b> </td>
						<td class="main_text" valign="top" align="right"><b>{$line.date}</b></td>			
				</tr>
				</table>
				<table cellspacing="0" cellpadding="0" border="0" width="95%" style="border: solid 1px #b2b2b2; background-color:#E9E9E9;">
				<tr bgcolor="#EFEFEF">
					<td class="main_text" width="150" valign="top" style="line-height: 13px; border-right: solid 1px #b2b2b2;">
					<br>
					{if $line.avatar_ext !=''}
					<table>
					<tr>
					<td align="center">
		 <img src="../includes/show_image.php?file={$line.avatar_image}&resize=80,null,null,null&crop=null,null,null,null" width={$line.avatar_width} alt="Avatar">				
					</td>
					</tr>
					</table>
					<br>{/if}
					Joined: {$line.user_joindate}<br>
					{if $line.user_comment_nr eq 0} {else}<a href="../games/games_comment.php?c_counter={$links.v_counter}&users_id={$line.user_id}&view=users_comments" class="MAINNAV">{/if}Game Comments: {$line.user_comment_nr}{if $line.user_comment_nr eq 0} {else}</a>{/if}<br>
					Game Submissions: {$line.usersubmit_number}<br>
					Karma: {$line.karma}
					
					</td>
					<td class="main_text" valign="top" style="line-height: 13px;">
						<br>
						<br>
						{if isset($line.image)}<span style="float:right;"><a href="../games/games_detail.php?game_id={$line.game_id}">
					<img src="../includes/show_image.php?file={$line.image}&resize=240,null,null,null&crop=null,null,null,null" alt="{$line.game_name}" border="0"></a></span>{/if}
						{$line.comment}
						<br>
						<br>
						<br>		
					</td>
				</tr>
				</table>	
				<table cellspacing="0" cellpadding="2" border="0" width="95%" style="border-left: solid 1px #b2b2b2; border-right: solid 1px #b2b2b2; border-bottom: solid 1px #b2b2b2;background-color:#E9E9E9;">
				<tr>
					<td width="150" valign="middle" class="main_text" style="line-height: 13px; border-right: solid 1px #b2b2b2;">
					
					<strong><a href="#top" class="MAINNAV">Back to top</a></strong>
					
					</td>
				
					<td valign="top" class="main_text">
						{if $line.email != ''}
							<a href="mailto:{$line.email}?subject=Thanks for the submission on {$line.game_name} at Atari Legend">
							<img src="../templates/0/icons/icon_email.gif" alt="Email User" title="Email User" width="59" height="18" border="0">
							</a>{/if}
							{if $structure.list == 'done'} {else}
							<a href="../games/db_games_submissions.php?action=update_submission&submit_id={$line.submit_id}&list={$structure.list}&v_counter={$structure.v_counter}">
							<img src="../templates/0/icons/icon_done.png" alt="Done" width="59" height="18" border="0" title="Edit Comment">
							</a>
							{/if}
							<a  onClick="commentdelete({$line.submit_id})" style="cursor: pointer;">
							<img src="../templates/0/icons/icon_delete.gif" alt="Delete Comment" title="Delete Comment" width="16" height="18" border="0">
							</a>
							<a  onClick="submovetocomment({$line.submit_id})" style="cursor: pointer;">
							<img src="../templates/0/icons/icon_movetocomments.png" alt="Move Comment" title="Move Comment" width="135" height="18" border="0">
							</a>
												
					</td>
					<td valign="middle" class="main_text" style="text-align: right;">
					
					</td>		
				</tr>
				</table>
				<br>
				{/foreach}
		
		
		
		
		
		
		
		
		
		
		
		

<table width="400" border="0" cellspacing="2" cellpadding="2">
<tr>
	<td width="50%" align="left">
	{if $structure.v_counter > 0}
	
	<strong><a href="../games/submission_games.php?list={$structure.list}&amp;v_counter={$structure.back_arrow}" class="MAINNAV">Previous</a></strong>
	
	{/if}
	</td>
	<td width="50%" align="right">

	{if $structure.forward_arrow >= 25}
	
	<strong><a href="../games/submission_games.php?list={$structure.list}&amp;v_counter={$structure.forward_arrow}" class="MAINNAV">Next</a></strong>
	
	{/if}
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

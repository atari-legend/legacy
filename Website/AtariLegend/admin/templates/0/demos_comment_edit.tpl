<table align="center" class="HEADERBAR" width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
	<td style="vertical-align:top;" height="5" colspan=6>
	<span class="LEFTNAVHEADING">&nbsp;Edit Comment</span>
	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="15" align="center" class="CELLCOLOR">
<tr>
	<td>
	<br>
		Comment by <strong>{$comments.user_name}</strong> on <strong>{$comments.demo}</strong> on {$comments.date}
	<br>
	<br>	
	<form action="../demos/db_demos_comment.php" method="post" name="editdemos_comment" id="editdemos_comment">

	<label for="comment_text">Comment</label>
	<textarea cols="50" rows="8" name="comment_text" class="textarea_links">{$comments.comment}</textarea>
	<br>
	<br>
	<input type="hidden" name="action" id="action" value="edit_demos_comment">
	<input type="hidden" name="users_id" value="{$comments.users_id}">
	<input type="hidden" name="view" value="{$comments.view}">
	<input type="hidden" name="demo_user_comments_id" value="{$comments.demo_user_comments_id}">
	<input type="hidden" name="c_counter" value="{$comments.c_counter}">
	<input type="hidden" name="v_counter" value="{$comments.v_counter}">
	<input type="hidden" name="comment_id" value="{$comments.comment_id}">
	<input type="submit" value="Edit">
	<input type="reset">
	</form>

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
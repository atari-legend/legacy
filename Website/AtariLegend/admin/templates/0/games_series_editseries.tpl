<table width="100%" cellspacing="2" cellpadding="15" align="center">
<tr>
	<td width="100%">
	<span class="LEFTNAV" style="color:#483D8B;">
	Here you can change the name of the game series.
	</span>
	<br>
	<br>
	
	<form action="../games/db_games_series.php" method="post" name="edit_series" id="edit_series">
	<label for="game_series_name">New name</label>
	<input type="text" name="game_series_name" id="game_series_name" value="{$series_info.game_series_name}" size="40" maxlength="64" class="links_input-box"><br>
	<input type="hidden" name="action" value="edit_series">
	<input type="hidden" name="game_series_id" value="{$series_info.game_series_id}">
	<input type="submit" name="inserter" value="Change">
	</form>

	<br>
	<br>
	<a href="javascript:history.go(-1)" class="MAINNAV">Back</a>
	
	</td>
</tr>
</table>
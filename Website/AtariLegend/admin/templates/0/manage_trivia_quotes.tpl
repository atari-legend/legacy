<table width="100%" border="0" cellspacing="0" cellpadding="2" align="center" class="HEADERBAR">
<tr>    
	<td height="5" style="vertical-align:top;">
	<span class="LEFTNAVHEADING">&nbsp;&nbsp;Manage Trivia Quotes</span>
	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="15" align="center" class="CELLCOLOR">
<tr>
	<td>
	
		
		 Here you can add a new <strong>trivia quote</strong> by using the below text field or you can delete old trivia quotes.<br>
		<br>
		
		
		<br>
		
		<fieldset class="category_set_noGrave">
	<legend class="links_legend">Add a new Trivia quote to the database</legend>
	
	

	<form action="../trivia/db_trivia.php" method="post" name="trivia" id="trivia">
	
	<label for="website_description_text">Trivia Text</label>	
		<textarea name="trivia_quote" id="trivia_quote" class="textarea_links" style="HEIGHT: 50px;"></textarea>
	
	<input type="hidden" name="action" value="add_trivia">
	<input type="submit" value="Submit" style="margin-left: 80%;">
	</form>
	

</fieldset> 
		
		<br>
		<br>
		
		{foreach from=$trivia item=line}
		
<fieldset class="category_set_noGrave">
	<legend class="links_legend">Trivia ID {$line.trivia_quote_id}</legend>
	
	<br>
	{$line.trivia_quote}<br>
	
	<form action="../trivia/db_trivia.php" method="post" name="trivia{$line.trivia_quote_id}" id="trivia{$line.trivia_quote_id}">
	<input type="hidden" name="action" value="delete_trivia_quote">
	<input type="hidden" name="trivia_quote_id" value="{$line.trivia_quote_id}">
	<input type="submit" value="Delete" style="margin-left: 80%;">
	</form>
</fieldset> 

<br>
<br>

		{/foreach}

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
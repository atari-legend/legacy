<table width="100%" border="0" cellspacing="0" cellpadding="2" align="center" class="HEADERBAR">
<tr>    
	<td height="5" style="vertical-align:top;">
	<span class="LEFTNAVHEADING">&nbsp;&nbsp;Modify Links</span>
	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="2" align="center" class="CELLCOLOR">
<tr>
	<td>
	
		<span class="maintext">Links in Archive</span>
		
		<form action="../links/link_modlist.php" method="post" name="catdrop" id="catdrop">
		<span class="maintext">Pick category</span>
	
	
			
			<select name="catpick">
					{foreach from=$category item=line}
						<option value="{$line.category_id}" {$line.selected}>{$line.category_name}</option>
					{/foreach}
			</select>
			<input type="submit" value="Pick">
			</form>
		
		<table width="100%" border="0" cellspacing="4" cellpadding="4">

		{foreach from=$link_list item=line}

			<tr>
    			<td style="border: solid 1px gray;">
				
				{if  $line.website_imgext !== ""}
					<a href="{$line.website_url}" target="_blank" style="target-net:tab;">
					<img src="../includes/show_image.php?file={$line.website_image}&resize=410,null,null,null&crop=left,top,410,260&minimum_size=410,260" border="0" style="border: 1px solid black; float: right;">
					</a>					
				{/if}
				
			<span class="maintext_light">
			<a href="{$line.website_url}" class="LEFTNAV" target="_blank">{$line.website_name}</a> 
			<a href="link_mod.php?website_id={$line.website_id}" class="MAINNAV">(Click to modify)</a><br>
			added on {$line.timestamp} by</span> <span class="maintext">{$line.submitted}</span><br>
			<span class="maintext_light">{$line.website_description}</span>
				</td>
			</tr>
		{/foreach}
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

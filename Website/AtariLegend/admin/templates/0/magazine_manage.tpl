<table width="100%" border="0" cellspacing="0" cellpadding="2" align="center" class="HEADERBAR">
<tr>    
	<td height="5" style="vertical-align:top;">
	<span class="LEFTNAVHEADING">&nbsp;&nbsp;Manage Magazines</span>
	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="15" align="center" class="CELLCOLOR">
<tr>
	<td>
	
		
		  Hiya, here you can add issues to magazines and upload covershots. To add reviewscores please visit the gamepages.<br>
		<br>
		
		
		<br>
		
		
<fieldset class="category_set_noGrave">
	<legend class="links_legend">Magazines in archive</legend>
	
	<br>
	{foreach from=$magazine item=line}
	
	<a href="../magazine/magazine_edit.php?magazine_id={$line.magazine_id}" class="MAINNAV">{$line.magazine_name}</a><br>
	
	{/foreach}
	<br>
	
	
</fieldset> 

<br>



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
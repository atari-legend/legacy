<table width="100%" border="0" cellspacing="0" cellpadding="2" align="center" class="HEADERBAR">
<tr>    
	<td height="5" style="vertical-align:top;">
	<span class="LEFTNAVHEADING">&nbsp;&nbsp;Magazine reviews.</span>
	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="15" align="center" class="CELLCOLOR">
<tr>
	<td>
	
		
		<br>
		
		<fieldset class="category_set_noGrave">
	<legend class="links_legend">Reviewed games.</legend>
	<br>
	
	<table cellspacing="2" cellpadding="2" border="1">
<tr>
	<th><span class="LEFTNAV">Game name</span></th>
	<th><span class="LEFTNAV">Score</span></th>
</tr>
{foreach from=$magazine item=line}
<tr>
	<td><span class="LEFTNAV">{$line.game}</span></td>
	<td><span class="LEFTNAV">{$line.score}</span></td>
</tr>

{/foreach}
</table>

</fieldset>
		
		
<br>

<a href="../magazine/magazine_edit.php?magazine_id={$magazine_info.magazine_id}" class="MAINNAV">Back</a>

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
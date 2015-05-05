<script language="JavaScript">
function coverdelete(JSmagazine_issue_id)
{literal}{ {/literal}  
	
    	// CONFIRM REQUIRES ONE ARGUMENT
    	var message = "Are you sure you want to DELETE this Coverscan??";
    	// CONFIRM IS BOOLEAN. THAT MEANS THAT
    	// IT RETURNS TRUE IF 'OK' IS CLICKED
    	// OTHERWISE IT RETURN FALSE
    	var return_value = confirm(message);

    	if (return_value !="0")
    	{literal}{ {/literal} 
    		url="../magazine/db_magazine.php?action=delete_coverscan&magazine_issue_id="+JSmagazine_issue_id+""
			location.href=url;
    	{literal}}  {/literal} 

{literal}} {/literal} 
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="2" align="center" class="HEADERBAR">
<tr>    
	<td height="5" style="vertical-align:top;">
	<span class="LEFTNAVHEADING">&nbsp;&nbsp;{$magazine.magazine_name} issue {$magazine.magazine_issue_nr} selected.</span>
	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="15" align="center" class="CELLCOLOR">
<tr>
	<td>
	
		{if $magazine.scan eq "1"}
		 coverscan preview<br><br>
		<img src="../includes/showscreens.php?magazine_scan_id={$magazine.magazine_issue_id}" alt="" border="0">
		<table>
			<tr>
				<td class="boxborder">
					<a onClick="coverdelete({$magazine.magazine_issue_id})" style="cursor: pointer;" class="MAINNAV">Delete Magazine scan</a>
				</td>
			</tr>
		</table>

		{else}
		 No coverscan has been uploaded, please upload one.<br>
		<br>
		
		
		<br>
		
		<fieldset class="category_set_noGrave">
	<legend class="links_legend">New Magazine.</legend>
	<br>
	<form method="post" enctype="multipart/form-data" action="../magazine/db_magazine.php" name="magazinecoverscan">
	
	Coverscan: <input type="file" name="coverscan" accept="image/jpeg" class="gamesearchInputs">
	<input type="hidden" name="action" value="coverscan_upload">
	<input type="hidden" name="magazine_issue_id" value="{$magazine.magazine_issue_id}">
	<input type='submit' value='Upload'>
	</form> <br>

</fieldset>
		
		
		

 
		{/if}	
<br>

<a href="../magazine/magazine_edit.php?magazine_id={$magazine.magazine_id}" class="MAINNAV">Back</a>

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
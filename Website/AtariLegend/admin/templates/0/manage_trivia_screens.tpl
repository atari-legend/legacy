<table width="100%" border="0" cellspacing="0" cellpadding="2" align="center" class="HEADERBAR">
<tr>    
	<td height="5" style="vertical-align:top;">
	<span class="LEFTNAVHEADING">&nbsp;&nbsp;Manage Intro Screens</span>
	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="15" align="center" class="CELLCOLOR">
<tr>
	<td>
	
		
		 In this section you can add images to the database which will be presented in the intro section of the front page.<br>
		<br>
		
		
		<br>
		
		<fieldset class="category_set_noGrave">
	<legend class="links_legend">Delete or view previously uploaded screen.</legend>
	
	{foreach from=$trivia item=line}


					<script language="JavaScript">
				  	function deletescreen{$line.trivia_screens_id}()
			{literal}	  	{ {/literal}
			      		// CONFIRM REQUIRES ONE ARGUMENT
     					var message = "Are you sure you want to delete this image?";
    					// CONFIRM IS BOOLEAN. THAT MEANS THAT
    					// IT RETURNS TRUE IF 'OK' IS CLICKED
    					// OTHERWISE IT RETURN FALSE
     					var return_value = confirm(message);
	    				if (return_value !="0")
        		{literal}		{ {/literal}
      						url="../trivia/db_trivia.php?action=delete_trivia_screen&imageid={$line.trivia_screens_id}";
							location.href=url;
       			{literal}		} {/literal}
		{literal}		  	} {/literal}
				  	</script>


	{$line.trivia_screens_id} :: <a href="" onclick="deletescreen{$line.trivia_screens_id}(); return false;" class="MAINNAV">Delete</a>  	
	:: <a href="javascript:void(window.open('../includes/showscreens.php?trivia_screens_id={$line.trivia_screens_id}&ext={$line.imgext}','4','width={$line.width},height={$line.height},toolbar=no,statusbar=no'))" class="MAINNAV">Look at image</a>
			       	  <br>
				
	
	{/foreach}
	

</fieldset> 
		
		<br>
		<br>
		

		
<fieldset class="category_set_noGrave">
	<legend class="links_legend">Upload another trivia screen!</legend>
	
	<br>
	<br>
	
	<form enctype="multipart/form-data" action="../trivia/db_trivia.php" method="post" name="frmUploadShot">
	
	<input type="file" name="image[1]">
	<input type="file" name="image[2]">
	
	<input type="hidden" name="action" value="trivia_upload">
	<input type="hidden" name="MAX_FILE_SIZE" value="100000">
	<input type="submit" value="Upload" style="margin-left: 80%;" name="cmdSubmit">
	</form>
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
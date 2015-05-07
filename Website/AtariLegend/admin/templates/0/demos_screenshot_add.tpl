{* 
********************************************************************************
*                                demos_screenshots_add.tpl
*                            ---------------------------------
*   begin                : wednesday, november 10, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : admin@atarilegend.com
*	 actual update        : Creation of file
*
*   Id: demos_screenshots_add.tpl,v 0.10 2005/11/10 13:26 ST Gravegrinder
*
*********************************************************************************/

///***********************************************************************************
// This is the sub template file to generate the demos main screenshot page
//************************************************************************************ 
*}

{literal}
<script type="text/javascript">
function delete_screenshot(screenshot_id, demo_id)
{	
	// CONFIRM REQUIRES ONE ARGUMENT
    var message = "Are you sure you want to delete the screenshot?";
    // CONFIRM IS BOOLEAN. THAT MEANS THAT
    // IT RETURNS TRUE IF 'OK' IS CLICKED
    // OTHERWISE IT RETURN FALSE
    var return_value = confirm(message);
	if (return_value !="0")
    {
      	url="demos_screenshot_add.php?demo_id="+demo_id+"&screenshot_id="+screenshot_id+"&action=delete_screen";
		location.href=url;
    }
}
</script>
{/literal}
				
<table align="center" class="HEADERBAR" width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
	<td style="vertical-align:top;" height="5" colspan=6>
	<span class="LEFTNAVHEADING">&nbsp;Demo screenshots - <a href="../demos/demos_detail.php?demo_id={$demo_id}" class="MAINNAV_WHITE">{$demo_name}</a></span>
	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="15" align="center" class="CELLCOLOR">
<tr>
	<td>
	<fieldset class="category_set">
		In this section you can add screenshots to a selected demo. Use the browse buttons to select the shots and press the 
		'Submit Query' button to link them to the demo.
	</fieldset> 
	<br>
	<br>
	<table width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td align="center" width="100%">
		<fieldset class="news_set">
		<legend class="links_legend">screenshots</legend>
		{if $screenshots_nr <> ''}
			{foreach from=$screenshots item=line}
				Image {$line.count} :: 
				<a href="javascript:delete_screenshot({$line.id},{$demo_id})" class="MAINNAV">Delete</a> ::    	
				<a href="javascript:void(window.open('../includes/show_image.php?file={$line.demo_screenshot_image}&resize=410,null,null,null&crop=left,top,410,260&minimum_size=410,260','4','width=460,height=290,toolbar=no,statusbar=no'))" class="MAINNAV">Look at image</a>
				<br>
			{/foreach}
		{else}
			No screenshots attached to this demo
		{/if}
		</fieldset>	
		</td>
	</tr>
	</table>
	</td>
</tr>

<tr>
	<td align="center">
		<fieldset class="news_set">
		<legend class="links_legend">Browse</legend>
		<form enctype="multipart/form-data" name="frmUploadShot" action="demos_screenshot_add.php" method="post">
		{section name=loop loop=11 start=1} 
			<input type="file" name="image[{$smarty.section.loop.index}]">
		{/section}	
		</fieldset> 
	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="15" align="center" class="CELLCOLOR">
<tr>
	<td>
	<input type="hidden" name="MAX_FILE_SIZE" value="100000">
	<input type="hidden" name="demo_id" value="{$demo_id}">
	<input type="hidden" name="action" value="add_screens">
	<input type="submit" name="cmdSubmit">
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
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
   		<td colspan="3" valign=top align=center>
			<b><a href="../demos/demos_detail.php?demo_id={$demo_id}" class="MAINNAV">back</a></b>
		</td>
	</tr>
</table>
<br>

{if $message <> ''}
	<table align="center" width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td align="center" >
			<br><br>
			<span class="MAINAV">{$message}</span>
		</td>
	</tr>
	</table>
{/if}

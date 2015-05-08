{* 
/***************************************************************************
 *                                demos_detail.tpl
 *                            ------------------------
 *   begin                : Sunday, October 30, 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : admin@atarilegend.com
 *
 *   Id: demos_detail.tpl,v 0.10 2005/10/11 14:50 Zombieman
 *
 ***************************************************************************/

//****************************************************************************************
// This is the detail page of a demo. Change all the specifics over here!
//**************************************************************************************** 
*}

{literal}
<script type="text/javascript">
function deletedemo(demo_id)
{
    // CONFIRM REQUIRES ONE ARGUMENT
    var message = "Are you sure you want to delete this demo?";
    // CONFIRM IS BOOLEAN. THAT MEANS THAT
    // IT RETURNS TRUE IF 'OK' IS CLICKED
    // OTHERWISE IT RETURN FALSE
    var return_value = confirm(message);

    if (return_value !="0")
    {
    	url="../demos/demos_detail.php?demo_id="+demo_id+"&action=delete_demo";
		location.href=url;
    }  
}

function delete_crew() 
{
	document.crew.method="post";
	document.crew.action="../demos/demos_detail.php?action=delete_crew";
   	document.crew.submit();
}

function add_crew() 
{
	document.crew.method="post";
	document.crew.action="../demos/demos_detail.php?action=add_crew";
   	document.crew.submit();
}

function delete_author() 
{
	document.creator.method="post";
	document.creator.action="../demos/demos_detail.php?action=delete_author";
   	document.creator.submit();
}

function add_author() 
{
	document.creator.method="post";
	document.creator.action="../demos/demos_detail.php?action=add_author";
   	document.creator.submit();
}
</script>
{/literal}

<table align="center" class="HEADERBAR" width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
	<td style="vertical-align:top;" height="5" colspan=6>
	<span class="LEFTNAVHEADING">&nbsp;Edit demo - {$demo_info.demo_name}</span>
	</td>
</tr>
</table>


<table width="100%" cellspacing="2" cellpadding="15" class="CELLCOLOR">
<tr>
	<td>
	<fieldset class="category_set">
		<legend class="links_legend">Crew/Creator info - help</legend>
		<table>
		<tr>
			<td width="100%" align="left" valign="top">
				A demo can be build by a crew, or can be created by an individual. If the demo is a one mans job, the crew data should not be filled.
				However, if the demo is constructed by a crew, the crew should be added in the crew box. As well as the members (of this crew) who participated on this
				demo, they should be added in the Creator box. You can link as many Crews/Creators to this demo as you wish.
			</td>
		</tr>
		</table>
	</fieldset> 
	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="15" class="CELLCOLOR">
<tr>
	<td width="50%">
	<form action="../demos/demos_detail.php" method="post" name="crew">
	<fieldset class="game_set">
		<legend class="links_legend">Crew info</legend>
			<table width="100%">
			<tr>
				<td>		
					{foreach from=$demo_crew item=line}
						<input type="checkbox" name="demo_crew_id[]" value="{$line.crew_id}">
					  		<a href="../crew/crew_search.php?crew_select={$line.crew_id}&crewsearch={$line.crew_name}&action=main" class="MAINNAV">{$line.crew_name}</a>				
					  	<br>
					  	<br>
					{/foreach}	
					{if $demo_crew_nr == 1} 				
						<img src="../templates/0/images/arrow_ltr.gif" alt="" width="38" height="22" border="0">		
						<input type="button" value="Delete" onclick="delete_crew()">
					{/if}
					<br>
					<br>
					<select name="crew_id_select" class="authorSelects">
					{foreach from=$crew item=line}
						<option value="{$line.crew_id}">{$line.crew_name}</option>
					{/foreach}
					</select>
					<input type="hidden" name="demo_id" value="{$demo_id}">	
					<input type="button" value="Add" onclick="add_crew()">
				</td>
			</tr>
			</table>
	</fieldset>
	</form>
	</td>
	<td align="50%">
	<form action="../demos/demos_detail.php" method="post" name="creator">
	<fieldset class="game_set">
		<legend class="links_legend">Creator info</legend>
			<table width="100%">
			<tr>
				<td>	
					{foreach from=$demo_author item=line}
						<input type="checkbox" name="demo_author_id[]" value="{$line.demo_author_id}">
					  		<a href="../individuals/individuals_edit.php?ind_id={$line.ind_id}" class="MAINNAV">{$line.ind_name}</a> <b>({$line.auhthor_type_info})</b>
					  	<br>
					  	<br>
					{/foreach}
					{if $demo_author_nr == 1} 
				 		<img src="../templates/0/images/arrow_ltr.gif" alt="" width="38" height="22" border="0">		
				 		<input type="button" value="Delete" onclick="delete_author()">
					{/if}
					<br>
					<br>
					<select name="ind_id" class="authorSelects">
					{foreach from=$individuals item=line}
						<option value="{$line.ind_id}">{$line.ind_name}</option>
					{/foreach}
					</select>
					<b>Name</b>		
					<br>
					<select name="author_type_id" class="authorSelects">
					{foreach from=$author_types item=line}
						<option value="{$line.author_type_id}">{$line.author_type}</option>
					{/foreach}
					</select>
					<b>Job</b>		
					<br><br>
					<input type="hidden" name="demo_id" value="{$demo_id}">	
					<input type="button" value="Add" onclick="add_author()">
				</td>
			</tr>
			</table>
	</fieldset>
	</form>
	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="15" class="CELLCOLOR">
<tr>
	<td>
	<fieldset class="category_set">
		<legend class="links_legend">Basic demo Info - help</legend>
		<table>
		<tr>
			<td width="75%" align="left" valign="top">
				Add this part of the screen you can add additional demo info. Just select what you think is neceasrry, and press the modify button to link it all to the demo.
				When you press the delete button, the complete demo and all table entries linked to this demo entity will be removed from the database!
			</td>
		</tr>
		</table>
	</fieldset> 
	</td>
</tr>
<tr>
	<td>
	<form action="../demos/demos_detail.php" method="post" name="edit">
	<fieldset class="game_set">
		<legend class="links_legend">Basic demo info</legend>
		<table>
		<tr>
			<td width="75%" align="left">
				<b>Demo name :</b> <input type="text" name="demo_name" value="{$demo_info.demo_name}">
			</td>
		</tr>
		<tr>
			<td width="25%" align="left">
				<b>Release year  :</b> {html_select_date time=$demo_info.demo_year start_year=1984 display_days=0 display_months=0}
			</td>
		</tr>
		<tr>
			<td width="75%" align="left">
				<table>
				<tr>
					<td align="left">
						{if $demo_info.demo_ste_enhan == 1}
							<input type="checkbox" name="ste_enhanced" value="1" checked>This demo is STE Enhanced&nbsp;
						{else}
							<input type="checkbox" name="ste_enhanced" value="1">This demo is STE Enhanced&nbsp;
						{/if}
					</td>
				</tr>
				<tr>
					<td align="left">
						{if $demo_info.demo_ste_only == 1}
							<input type="checkbox" name="ste_only" value="1" checked>This demo is STE ONLY&nbsp;
						{else}
							<input type="checkbox" name="ste_only" value="1">This demo is STE ONLY&nbsp;
						{/if}
					</td>
				</tr>
				<tr>
					<td align="left">
						{if $demo_info.demo_falcon_enhan == 1}
							<input type="checkbox" name="falcon_enhanced" value="1" checked>This demo is Falcon Enhanced&nbsp;
						{else}
							<input type="checkbox" name="falcon_enhanced" value="1">This demo is Falcon Enhanced&nbsp;
						{/if}
					</td>
				</tr>
				<tr>
					<td align="left">
						{if $demo_info.demo_falcon_only == 1}
							<input type="checkbox" name="falcon_only" value="1" checked>This demo is Falcon only&nbsp;
						{else}
							<input type="checkbox" name="falcon_only" value="1">This demo is Falcon only&nbsp;
						{/if}
					</td>
				</tr>		
				<tr>
					<td align="left">
						{if $demo_info.demo_mono_only == 1}
							<input type="checkbox" name="mono_only" value="1" checked>This demo is mono only&nbsp;
						{else}
							<input type="checkbox" name="mono_only" value="1">This demo is mono only&nbsp;
						{/if}
					</td>
				</tr>
				</table>
			</td>
			<td width="25%" align="left">
				<b>Category</b>
				<br>
				<select name="category[]" multiple size="8">
				{foreach from=$cat item=line}
					<option value="{$line.cat_id}" {$line.cat_selected}>{$line.cat_name}</option>
				{/foreach}
				</select>
			</td>
		</tr>
		<tr>
			<td width="100%" align="left" colspan="3">
				<br><br>
				<input type="submit" name="valider" value="Modify">
				<input type="button" name="delete" value="Delete" onClick="deletedemo({$demo_id}); return false;">	
				<input type="hidden" name="action" value="modify_demo">	
				<input type="hidden" name="demo_id" value="{$demo_id}">	
			</td>
		</tr>
		</table>
	</fieldset>
	</form>
	</td>	
</tr>	
</table>


<table width="100%" cellspacing="2" cellpadding="15" class="CELLCOLOR">
<tr>
	<td width="33%" align="center">
	<form action="../demos/demos_detail.php" method="post" name="aka">
	<fieldset class="game_set">
		<legend class="links_legend">Other Features</legend>
			<table width="100%">
			<tr>
				<td width="33%" align="center">	
					<b>Demo AKA :</b> <input type="text" name="demo_aka"><input type="submit" name="valider" value="Add">
					<input type="hidden" name="action" value="demo_aka">	
					<input type="hidden" name="demo_id" value="{$demo_id}">	
					<br>
					<br>
					{if $nr_aka <> 0}
					<b>Current AKA</b>
					<br>
						{foreach from=$aka item=line}
							<a href="../demos/demos_detail.php?demo_id={$line.demo_id}" class="MAINNAV">{$line.demo_aka_name}</a> - <b><a href="../demos/demos_detail.php?demo_aka_id={$line.demo_aka_id}&action=delete_aka&demo_id={$line.demo_id}" class="MAINNAV">delete</a></b> 
							<br>
						{/foreach}
					{/if}
					<br>
					<br>
					<b><a href="../demos/demos_upload.php?demo_id={$demo_info.demo_id}" class="MAINNAV">Add file download</a></b><br>
				  	<b><a href="../demos/demos_screenshot_add.php?demo_id={$demo_info.demo_id}&demo_name={$demo_info.demo_name}" class="MAINNAV">Add screenshots</a></b><br>
					<br>
					<b><a href="../administration/construction.php" class="MAINNAV">Moderate comments</a></b>
				</td>
			</tr>
			</table>
	</fieldset>
	</form>
	</td>
	<td width="33%" align="center">
	<fieldset class="game_set">
		<legend class="links_legend">Statistics</legend>
			<table width="100%">
			<tr>
				<td width="33%" align="center">	
					Nr of Screenshots - {$nr_screenshots}<br>
					Nr of music files - {$nr_music}<br>
				</td>
			</tr>
			</table>
	</fieldset>
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
			<b><a href="../demos/demos_main.php" class="MAINNAV">back</a></b>
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
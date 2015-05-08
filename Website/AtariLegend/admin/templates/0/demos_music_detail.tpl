{* 
/***************************************************************************
*                                demos_music_detail.tpl
*                            ------------------------------
*   begin                : saturday, November 19, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : admin@atarilegend.com
*						   Created file
*						
*   Id: demos_music_detail.tpl,v 0.10 2005/11/19 ST Graveyard
*
***************************************************************************/

//****************************************************************************************
// This is the detail page of a demo. Change all the specifics over here!
//**************************************************************************************** 
*}

{literal}
<script type="text/javascript">
function add_composer() 
{
	document.editmuzak.method="post";
	document.editmuzak.action="../demos/demos_music_detail.php?action=pick_composer";
   	document.editmuzak.submit();
}

function delete_music(demo_id) 
{
	document.editmuzak.method="post";
	document.editmuzak.action="../demos/demos_music_detail.php?demo_id="+demo_id+"&action=delete_music";
   	document.editmuzak.submit();
}
</script>
{/literal}

<table align="center" class="HEADERBAR" width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
	<td style="vertical-align:top;" height="5" colspan=6>
	<span class="LEFTNAVHEADING">&nbsp;Edit demo music - <a href="../demos/demos_detail.php?demo_id={$demo.demo_id}" class=MAINNAV_WHITE>{$demo.demo_name}</a></span>
	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="15" class="CELLCOLOR">
<tr>
	<td>
	<fieldset class="category_set">
		<legend class="links_legend">Demo Music</legend>
		<table>
		<tr>
			<td width="100%" align="left" valign="top">
				Add a new muzak or delete an existing one from the db. Choose the composer and go for it!
			</td>
		</tr>
		</table>
	</fieldset> 
	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="15" class="CELLCOLOR">
<tr>
	<td width="100%">
	<form action="../demos/demos_music_detail.php" method="post" name="editmuzak">
	<fieldset class="game_set">
		<legend class="links_legend">Edit existing files</legend>
			<table width="100%">
			<tr>
				<td width="100%">		
					{foreach from=$music item=line}
						<input type="checkbox" name="music_id_selected[]" value="{$line.music_id}">
					  	<a href="../demos/demos_music_detail.php?music_id={$line.music_id}&amp;action=play_music" class="MAINNAV">{$line.ind_name}_{$line.music_id}.{$line.extention}</a>
					  	<br>
					  	<br>
					{/foreach}					
					<img src="../templates/0/images/arrow_ltr.gif" alt="" width="38" height="22" border="0">		
					<input type="button" value="Delete" onclick="delete_music({$demo.demo_id})">
					<br>
					<br>
					<select name="individuals" class="continentSelects">
						<option value="-" selected>-</option>
						{foreach from=$ind item=line}
							<option value="{$line.ind_id}">{$line.ind_name}</option>							
						{/foreach}		
					</select>	
					<b>Composers</b>					
					<br><br>
					<input type="hidden" name="music_id" value="{$line.music_id}">
					<input type="hidden" name="demo_id" value="{$demo.demo_id}">
					<input type="button" value="Pick" onclick="add_composer()">
				</td>
			</tr>
			</table>
	</fieldset>
	</form>
	</td>
</tr>
</table>

{if $action == 'pick_composer'}
<table width="100%" cellspacing="2" cellpadding="15" class="CELLCOLOR">
<tr>
	<td width="100%">
		<form enctype="multipart/form-data" method="post" action="../demos/demos_music_detail.php" name="composer">		
		<fieldset class="game_set">
		<legend class="links_legend">Music files for {$ind_selected.ind_name}</legend>
			<table width="100%">
			<tr>
				<td width="100%">		
					{section name=loop loop=6 start=1} 
						<input type="file" name="music[{$smarty.section.loop.index}]">
						<br>
					{/section}	
					<input type="hidden" name="ind_id" value="{$ind_selected.ind_id}">
					<input type="hidden" name="MAX_FILE_SIZE" value="100000">
					<input type="hidden" name="action" value="upload_zaks">
					<input type="hidden" name="demo_id" value="{$demo.demo_id}">
					<input type="submit" name="valider" value="Upload">
					<br>
					<br>
					<a href="../demos/demos_music_detail.php?demo_id={$demo.demo_id}" class=MAINNAV> Pick another composer </a>
				</td>
			</tr>
			</table>
	</fieldset>
	</form>
	</td>
</tr>
</table>
{/if}

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
			<b><a href="../demos/demos_music.php" class="MAINNAV">back</a></b>
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
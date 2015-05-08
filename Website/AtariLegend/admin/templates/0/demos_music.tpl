{* 
/***************************************************************************
*                                demos_music.tpl
*                            --------------------------
*   begin                : saturday, November 19, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : admin@atarilegend.com
*						   Created file
*						
*   Id: demos_music.tpl,v 0.10 2005/11/19 ST Graveyard
*
***************************************************************************/

************************************************************************************************
The main demo music
************************************************************************************************
*}

<table align="center" class="HEADERBAR" width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
	<td style="vertical-align:top;" height="5" colspan=6>
	<span class="LEFTNAVHEADING">&nbsp;Add/Edit a demo music entry</span>
	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="15" align="center" class="CELLCOLOR">
<tr>
	<td colspan="2">
	<fieldset class="category_set">
		In this section you can add demo music files to the demos. They are used in the main pages! 
	</fieldset> 
	</td>
</tr>
<tr>
	<td align="center">
		<form action="../demos/demos_music.php" method="post" name="demo_music" id="demo_music">
		<fieldset class="interview_set">
		<legend class="links_legend">Search music</legend>
		<br>
		<table>
		<tr>
			<td>
				<b>By name :</b>
			</td>
			<td>
				<select name="demobrowse">
					<option value="" SELECTED>-</option>
					<option value="num">0-9</option>
					<option value="a">A</option>
					<option value="b">B</option>
					<option value="c">C</option>
					<option value="d">D</option>
					<option value="e">E</option>
					<option value="f">F</option>
					<option value="g">G</option>
					<option value="h">H</option>
					<option value="i">I</option>
					<option value="j">J</option>
					<option value="k">K</option>
					<option value="l">L</option>
					<option value="m">M</option>
					<option value="n">N</option>
					<option value="o">O</option>
					<option value="p">P</option>
					<option value="q">Q</option>
					<option value="r">R</option>
					<option value="s">S</option>
					<option value="t">T</option>
					<option value="u">U</option>
					<option value="v">V</option>
					<option value="w">W</option>
					<option value="x">X</option>
					<option value="y">Y</option>
					<option value="z">Z</option>
				</select>
				<input type="text" name="demosearch" value="">
			</td>
		</tr>
		</table>
		<br>
		<br>
		<input type="submit" value="Search">
		<br>
		</fieldset>
		<input type="hidden" name="action" id="action" value="search">
		<input type="hidden" name="user_id" id="user_id" value="{$user_id}">
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
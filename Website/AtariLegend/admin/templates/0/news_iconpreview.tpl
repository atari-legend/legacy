{* 
/***************************************************************************
*                                news_iconpreview.tpl
*                            --------------------------
*   begin                : Sunday may 1, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : maarten.martens@freebel.net
*
*   Id: news_iconpreview.tpl,v 0.10 2005/05/01 ST Graveyard
*
***************************************************************************/
//****************************************************************************************
// This is the sub template file to generate the newsicon add page
//**************************************************************************************** 

*}

<table align="center" class="HEADERBAR" width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
	<td style="vertical-align:top;" height="5" colspan=6>
	<span class="LEFTNAVHEADING">&nbsp;Preview news icons</span>
	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="15" align="center" class="CELLCOLOR">
<tr>
	<td align="center">	
		<table width="100%" cellspacing="2" cellpadding="0" align="center">
		{foreach from=$news_images item=line}
			{if $line.count=="1"}
				<tr>
			{/if}
					<td width="130" align="center">
						<img src="../includes/show_image.php?file={$line.image_link}&resize=410,null,null,null&crop=left,top,410,260&minimum_size=410,260" alt="newsbutton">
						<br>
						{$line.image_name}
					</td>
					{if $line.count=="3"}
				</tr>
			{/if}
		{/foreach}
		</table>			
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
<table align="center" width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	<td align="center" >
		<br><br>
		<a href="javascript:history.go(-1)" class="MAINNAV"><b>back</b></a>
	</td>
</tr>
</table>

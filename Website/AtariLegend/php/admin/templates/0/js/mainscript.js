<script language="JavaScript" type="text/javascript">
<!--
{literal}
function popUp(strURL,w,h,blnCentered,blnScroll,strOptions) 
{
	var name="popup"+parseInt(Math.random()*100)
	if(strOptions) strOptions+=","
	else var strOptions=""
	if(blnCentered)
	{
		var x = (screen.width - w) / 2
		x = (x<0) ? 0 : x
		var y = (screen.height - h) / 2
		y = (y<0) ? 0 : y
		strOptions+="left=" + x + ",top=" + y+ ","
	}
	if(w) strOptions+="width="+w + ","
	if(h) strOptions+="height="+h + ","
	if(blnScroll) strOptions+="scrollbars" + ","
	if(strOptions.substr(strOptions.length-1)==",") strOptions = strOptions.substr(0,strOptions.length-1)
	var win=window.open(strURL,name,strOptions);
}

function swapScreen(img_id,height,width,path,type,source) 
{
	if ( source == 'imgScreen' )
	{
		var bigpath = "../includes/showscreen.php?screenshot_id=" +img_id + "&ext={$firstscreenshots.imgext}"
		
		screenLocation = "screenshotpopup.php?screenshot_id=" + img_id + "&width=" + width + "&height=" + height + "&game_id=" + type + "&imgpath=" + path;
		screenHeight = height;
		screenWidth = width;
		document.images.imgScreen.src = path;
		document.images.imgScreen.width = width;
	}
	
	if ( source == 'imgBox' )
	{
		screenLocation_box = "boxpopup.php?game_name=" + type + "&screenshot_id=" + img_id + "&imgpath=" + path + "&width=" + width + "&height=" + height;
		screenHeight_box = height;
		screenWidth_box = width +10;
		document.images.imgBox.src = "../includes/showimage.php?w=88&shadow=0&bgcolour=cccccc&img=" + path;
		document.images.imgBox.width = 80;
	}
	
}
{/literal}
-->
</script>



//  div
// artist = 32, 154  -  191, 235
// song = 32, 266  -  287, 371
// info = 352, 266  -  569, 369
//  arrows
// artist upper 206, 152  -  229, 189
// artist lower 200, 198  -  223, 235
// song upper 302, 268  -   327, 313
// song lower 296, 322  -  319, 369
// info upper 580,267  -  611, 308
// info lower 573, 316  -  603, 357
var scrollInterval = false;

var img = document.createElement("img");
img.src = "../templates/0/images/jukebox_background.png";
img.width = 640;
img.height = 400;
img.style.position = "absolute";
img.style.zIndex = 0;
img.style.left = 0;
img.style.top = 0;
img.onmousedown = imgClick;
img.onmouseup = new Function("window.clearInterval(scrollInterval); scrollInterval = false;");
document.body.appendChild(img);

document.getElementById("artistHeader").style.display = "none";
document.getElementById("songHeader").style.display = "none";

var artistDiv = document.getElementById("artistDiv");
artistDiv.style.position = "absolute";
artistDiv.style.zIndex = 1;
artistDiv.style.overflow = "hidden";
artistDiv.style.width = "159px";
artistDiv.style.height = "81px";
artistDiv.style.left = "32px";
artistDiv.style.top = "154px";
if (typeof(artistScrollTop) != "undefined")
	if (artistScrollTop > 0)
		artistDiv.scrollTop = artistScrollTop;

var songDiv = document.getElementById("songDiv");
songDiv.style.position = "absolute";
songDiv.style.zIndex = 1;
songDiv.style.overflow = "hidden";
songDiv.style.width = "255px";
songDiv.style.height = "105px";
songDiv.style.left = "32px";
songDiv.style.top = "266px";

var infoDiv = document.getElementById("infoDiv");
infoDiv.style.position = "absolute";
infoDiv.style.zIndex = 1;
infoDiv.style.overflow = "hidden";
infoDiv.style.width = "217px";
infoDiv.style.height = "93px";
infoDiv.style.left = "352px";
infoDiv.style.top = "266px";


function imgClick(e) {
	var mouseX = getPageX(e);
	var mouseY = getPageY(e);
	
	if ((mouseX > 205 && mouseX < 230) && (mouseY > 151 && mouseY < 190)) {
		document.getElementById("artistDiv").scrollTop -= 2;
		if (!scrollInterval)
			scrollInterval = window.setInterval("document.getElementById('artistDiv').scrollTop -= 2;", 20);
	}
	if ((mouseX > 199 && mouseX < 224) && (mouseY > 197 && mouseY < 236)) {
		document.getElementById("artistDiv").scrollTop += 2;
		if (!scrollInterval)
			scrollInterval = window.setInterval("document.getElementById('artistDiv').scrollTop += 2;", 20);
	}

	if ((mouseX > 301 && mouseX < 328) && (mouseY > 267 && mouseY < 314)) {
		document.getElementById("songDiv").scrollTop -= 2;
		if (!scrollInterval)
			scrollInterval = window.setInterval("document.getElementById('songDiv').scrollTop -= 2;", 20);
	}
	if ((mouseX > 295 && mouseX < 320) && (mouseY > 321 && mouseY < 370)) {
		document.getElementById("songDiv").scrollTop += 2;
		if (!scrollInterval)
			scrollInterval = window.setInterval("document.getElementById('songDiv').scrollTop += 2;", 20);
	}

	if ((mouseX > 379 && mouseX < 612) && (mouseY > 266 && mouseY < 309)) {
		document.getElementById("infoDiv").scrollTop -= 2;
		if (!scrollInterval)
			scrollInterval = window.setInterval("document.getElementById('infoDiv').scrollTop -= 2;", 20);
	}
	if ((mouseX > 572 && mouseX < 604) && (mouseY > 315 && mouseY < 358)) {
		document.getElementById("infoDiv").scrollTop += 2;
		if (!scrollInterval)
			scrollInterval = window.setInterval("document.getElementById('infoDiv').scrollTop += 2;", 20);
	}
}


function getPageX(e) {
	if (window.event)
		e = window.event;
	if (e.pageX)
		return (e.pageX);
	if (e.clientX)
		return (document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft) + e.clientX;
}

function getPageY(e) {
	if (window.event)
		e = window.event;
	if (e.pageY)
		return (e.pageY);
	if (e.clientY)
		return (document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft) + e.clientY;
}

/*!
 * interviews.js
 * http://www.atarilegend.com
 *
 */

 $(document).ready(function() {
    $("select[name=members]").altAutocomplete();
    $("select[name=individual]").altAutocomplete();
}); 
 
function openTab(evt, tabName)
{
    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";

    //al the java code for the filling of the fields in the preview tab!
    if (tabName == 'preview')
    {
        //get the date field
        var day = document.getElementsByName("Date_Day")[0].value;
        document.getElementById("interview_preview_date").innerHTML = day;
        document.getElementById("interview_preview_date").innerHTML += '-';
        var month = document.getElementsByName("Date_Month")[0].value;
        document.getElementById("interview_preview_date").innerHTML += month;
        document.getElementById("interview_preview_date").innerHTML += '-';
        var year = document.getElementsByName("Date_Year")[0].value;
        document.getElementById("interview_preview_date").innerHTML += year;

        var user = document.getElementById("member_select");
        var strUser = user.options[user.selectedIndex].text;
        document.getElementById("interview_preview_user").innerHTML = strUser;

        //Do all the preps for the intro text!
        var intro = document.getElementsByName("textintro")[0].value;
        intro = previewText(intro);
        document.getElementById("interview_preview_intro").innerHTML = intro;

        //Do all the preps for the chapters text!
        var chapters = document.getElementsByName("textchapters")[0].value;
        chapters = previewText(chapters);
        document.getElementById("interview_preview_chapters").innerHTML = chapters;

        //Do all the preps for the actual interview text!
        var interview = document.getElementsByName("textfield")[0].value;
        interview = previewText(interview);
        document.getElementById("interview_preview_text").innerHTML = interview;

        //get the screenshots data
        for (i = 1; i <= {$screenshots_nr}; i++)
        {
            var string = "comment_";
            var string_comment = string.concat(i);
            var comment = document.getElementById(string_comment).value;

            if (comment == '')
            {
                var string3 = "output_";
                var string_output = string3.concat(i);
                var output = document.getElementById(string_output);
                output.style.display='none';
            }
            else
            {
                var string2 = "preview_comment_";
                var string_preview_comment = string2.concat(i);
                document.getElementById(string_preview_comment).innerHTML = comment;

                var string3 = "output_";
                var string_output = string3.concat(i);
                var output = document.getElementById(string_output);
                output.style.display='inline';
            }
        }
    }
}

//Delete the comments and the interview
window.deletecomment = function (str, str2) {
    $('#JSGenericModal').dialog({
        title: 'Delete screenshot?',
        open: $('#JSGenericModalText').text('Are you sure you want to delete the screenshot with its comment?'),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            'Delete': function () {
                $(this).dialog('close');
                var url = 'db_interview.php?interview_id=' + str2 + '&screenshot_id=' + str + '&action=delete_screenshot_comment';
                location.href = url;
            },
            Cancel: function () {
                $(this).dialog('close');
            }
        }
    });
}

//delete the interview
window.deleteinterview = function (str) {
    $('#JSGenericModal').dialog({
        title: 'Delete interview?',
        open: $('#JSGenericModalText').text('Are you sure you want to delete this interview?'),
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            'Delete': function () {
                $(this).dialog('close');
                var url = 'db_interview.php?action=delete_interview&interview_id=' + str;
                location.href = url;
            },
            Cancel: function () {
                $(this).dialog('close');
            }
        }
    });
}

//open the screenshot selection box
function popInterviewAddScreenshots(str) {
    if (str == "") {
        $('#interview_expand_screenshots').html('');
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("interview_expand_screenshots").innerHTML = xmlhttp.responseText;
                document.getElementById("screenshot_link").innerHTML = "<a onclick=\"closeAddScreenshots("+str+")\" style=\"cursor: pointer;\" class=\"left_nav_link\"><i class=\"fa fa-minus-square-o\" aria-hidden=\"true\"></i> Add screenshots</a>";
            }
        }
        xmlhttp.open("GET","../interviews/ajax_addscreenshots_interview.php?interview_id="+str,true);
        xmlhttp.send();
    }
}

//close the screenshot selection box
function closeAddScreenshots(str) {
        document.getElementById("interview_expand_screenshots").innerHTML = "";
        document.getElementById("screenshot_link").innerHTML = "<a onclick=\"popInterviewAddScreenshots("+str+")\" style=\"cursor: pointer;\" class=\"left_nav_link\"><i class=\"fa fa-plus-square-o\" aria-hidden=\"true\"></i> Add screenshots</a>";
        return;
}

//Save the screenshots to the interview
function addScreenshottoInterview(interview_id) {
    if (interview_id == "") {
        document.getElementById("interview_screenshot_list").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

                data = xmlhttp.responseText.split ( "[BRK]" );
                document.getElementById("interview_screenshot_list").innerHTML = data[0];

                $.notify_osd.create({
                    'text'        : data[1],             // notification message
                    'icon'        : '{$style_dir}images/osd_icons/star.png', // icon path, 48x48
                    'sticky'      : false,             // if true, timeout is ignored
                    'timeout'     : 4,                 // disappears after 6 seconds
                    'dismissable' : true               // can be dismissed manually
                    });

                document.getElementById("screenshot_add_to_interview").reset();
            }
        }

        var formData = new FormData( document.getElementById("screenshot_add_to_interview") );

        xmlhttp.open("POST","../interviews/db_interview.php?action2=add_screens",true);
        xmlhttp.send(formData);
    }
}

//the code for the screenshot selector
function myFunction() {
    $but = $('#file_upload_game_file');

    $("input:file[id=file_upload]").change(function() {
        document.getElementById('file_upload_game_screenshots').value = 'file(s) selected';
    });

    $("input:file[id=file_upload2]").change(function() {
        document.getElementById('file_upload_game_file').value = $(this).val();
    });
}

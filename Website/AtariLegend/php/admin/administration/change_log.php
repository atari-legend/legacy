<?php
/***************************************************************************
 *                                change_log.php
 *                            ---------------------------
 *   begin                : Wednesday, 17 august, 2016
 *   copyright            : (C) 2016 Atari Legend
 *   email                : martens_maarten@hotmail.com
 *   actual update        : File creation
 *
 ***************************************************************************/
//****************************************************************************************
// This is where we load the db changes from the log table and create links
//****************************************************************************************

include("../../config/common.php");
include("../../config/admin.php");

//load the changes per month tile
include("../../common/tiles/changes_per_month_tile.php");

//load the search fields of the quick search side menu
include("../../admin/games/quick_search_games.php");

if (isset($action)) {
} else {
    $action = "";
}

//get the number of log entries
$query_number = $mysqli->query("SELECT * FROM change_log") or die("Couldn't get the number of changes");
$v_log = $query_number->num_rows;

$smarty->assign('log_nr', $v_log);

if (empty($v_linkback)) {
    $v_linkback = '';
}
if (empty($v_linknext)) {
    $v_linknext = '';
}

$v_counter = (isset($_GET["v_counter"]) ? $_GET["v_counter"] : 0);

// if we are dealing with a log search, build the query
if ($action == 'log_search') {
    $log_timestamp = date_to_timestamp($Date_Year, $Date_Month, $Date_Day);
    $sql_log       = $mysqli->query("SELECT * FROM change_log WHERE timestamp < '$log_timestamp'
                               ORDER BY change_log_id DESC LIMIT  " . $v_counter . ", 25");

    $v_number = $sql_log->num_rows;
    $smarty->assign('rec_nr', $v_number);
} else {
    $sql_log = $mysqli->query("SELECT *
                             FROM change_log
                             ORDER BY change_log_id DESC LIMIT  " . $v_counter . ", 25");

    $v_number = $sql_log->num_rows;
    $smarty->assign('rec_nr', $v_number);
}

while ($log = $sql_log->fetch_array(MYSQLI_BOTH)) {
    $user_name = get_username_from_id($log['user_id']);
    $log_date  = date("j-m-y", $log['timestamp']);

    //  create the section link and the subsection link
    //  the GAMES SECTION
    if ($log['section'] == 'Games') {
        $section_link = ("../games/games_detail.php" . '?game_id=' . $log['section_id']);

        if ($log['sub_section'] == 'Game' or $log['sub_section'] == 'AKA' or $log['sub_section'] == 'Year' or $log['sub_section'] == 'Submission' ) {
            $subsection_link = ("../games/games_detail.php" . '?game_id=' . $log['sub_section_id']);
        }
        
         if ($log['sub_section'] == 'Release'){
            $subsection_link = "";
         }

        if ($log['sub_section'] == 'Creator') {
            $subsection_link = ("../individuals/individuals_edit.php" . '?ind_id=' . $log['sub_section_id']);
        }

        if ($log['sub_section'] == 'Publisher' or $log['sub_section'] == 'Developer') {
            $subsection_link = ("../company/company_edit.php" . '?comp_id=' . $log['sub_section_id']);
        }

        if ($log['sub_section'] == 'File') {
            $subsection_link = ("../downloads/downloads_game_detail.php" . '?game_id=' . $log['sub_section_id']);
        }

        if ($log['sub_section'] == 'Fact') {
            $subsection_link = ("../games/games_facts.php" . '?game_id=' . $log['sub_section_id'] . '&game_name=' . $log['section_name']);
        }

        if ($log['sub_section'] == 'Screenshot') {
            $subsection_link = ("../games/games_screenshot_add.php" . '?game_id=' . $log['sub_section_id'] . '&game_name=' . $log['section_name']);
        }

        if ($log['sub_section'] == 'Mag score') {
            $subsection_link = ("../magazine/magazine_review_score.php" . '?game_id=' . $log['sub_section_id'] . '&game_name=' . $log['section_name']);
        }

        if ($log['sub_section'] == 'Box back' or $log['sub_section'] == 'Box front') {
            $subsection_link = ("../games/games_box.php" . '?game_id=' . $log['sub_section_id'] . '&game_name=' . $log['section_name']);
        }

        if ($log['sub_section'] == 'Similar') {
            $subsection_link = ("../games/games_similar.php" . '?game_id=' . $log['sub_section_id'] . '&game_name=' . $log['section_name']);
        }

        if ($log['sub_section'] == 'Comment') {
            if ($log['action'] == 'Delete') {
                $subsection_link = ("../administration/change_log.php");
            } else {
                //$subsection_link = ("../games/games_comment_edit.php" . '?game_user_comments_id=' . $log['sub_section_id'] . '&v_counter=0');
                $subsection_link = ("../administration/comments.php");
            }
        }

        if ($log['sub_section'] == 'Review' or $log['sub_section'] == 'Review comment') {
            if ($log['action'] == 'Delete') {
                //$subsection_link = ("../games/games_review_add.php" . '?game_id=' . $log['section_id']);
                $subsection_link = ("../games/games_review.php");
            } else {
                $subsection_link = ("../games/games_review_edit.php" . '?reviewid=' . $log['sub_section_id'] . '&game_id=' . $log['section_id']);
            }
        }

        if ($log['sub_section'] == 'Music') {
            $subsection_link = ("../games/games_music_detail.php" . '?game_id=' . $log['sub_section_id']);
        }
    }

    //  the GAMES SERIES SECTION
    if ($log['section'] == 'Game series') {
        $section_link = ("../games/games_series_editor.php" . '?game_series_id=' . $log['section_id'] . '&series_page=series_editor');

        if ($log['sub_section'] == 'Series') {
            $subsection_link = ("../games/games_series_editor.php" . '?game_series_id=' . $log['section_id'] . '&series_page=series_editor');
        }

        if ($log['sub_section'] == 'Game') {
            $subsection_link = ("../games/games_detail.php" . '?game_id=' . $log['sub_section_id']);
        }
    }

    //  the TRIVIA SECTION
    if ($log['section'] == 'Trivia') {
        if ($log['sub_section'] == 'DYK') {
            $section_link    = ("../trivia/did_you_know.php");
            $subsection_link = ("../trivia/did_you_know.php");
        }

        if ($log['sub_section'] == 'Quote') {
            $section_link    = ("../trivia/manage_trivia_quotes.php");
            $subsection_link = ("../trivia/manage_trivia_quotes.php");
        }

        if ($log['sub_section'] == 'Spotlight') {
            $section_link    = ("../trivia/spotlight.php");
            $subsection_link = ("../trivia/spotlight.php");
        }
    }

    //  the USER SECTION
    if ($log['section'] == 'Users') {
        if ($log['sub_section'] == 'Avatar' or $log['sub_section'] == 'User') {
            if ($user_name == '0') {
                // This is a log event about a deleted user (e.g. an avatar change or profile update)
                // As they're deleted, we can't link to their profile
                $section_link = '';
                $subsection_link = '';
            } else {
                $section_link    = ("../user/user_detail.php" . '?user_id_selected=' . $log['section_id']);
                $subsection_link = ("../user/user_detail.php" . '?user_id_selected=' . $log['sub_section_id']);
            }
        }

        if ($log['sub_section'] == 'User' and $log['action'] == 'Delete') {
            // This is the log event when a user deleted another user
            // The deleted user doesn't exist in the database anymore, so we
            // can't link to their profile
            $section_link = '';
            $subsection_link = '';
        }
    }

    //  the LINKS SECTION
    if ($log['section'] == 'Links') {
        $section_link = ("../links/link_mod.php" . '?website_id=' . $log['section_id']);

        if ($log['sub_section'] == 'Link' or $log['sub_section'] == 'Category') {
            $subsection_link = ("../links/link_mod.php" . '?website_id=' . $log['section_id']);
        }

        if ($log['sub_section'] == 'Link submit') {
            // There's no screen to point to for a single link to validate
            // (They are all listed in the single "Validate link" page)
            // Point the main section link to this page
            // and point the subsection link to an anchor for the specific website to validate
            $section_link = ("../links/link_addnew.php");
            $subsection_link = ("../links/link_addnew.php#new-link-".$log['sub_section_id']);
        }
    }

    //  the LINKS CATEGORRY SECTION
    if ($log['section'] == 'Links cat') {
        $section_link    = ("../links/link_cat.php");
        $subsection_link = ("../links/link_cat.php");
    }

    //  the COMPANY SECTION
    if ($log['section'] == 'Company') {
        $section_link = ("../company/company_edit.php" . '?comp_id=' . $log['section_id']);

        if ($log['sub_section'] == 'Company' or $log['sub_section'] == 'Logo') {
            $subsection_link = $section_link;
        }
    }

    //  the INDIVIDUALS SECTION
    if ($log['section'] == 'Individuals') {
        $section_link = ("../individuals/individuals_edit.php" . '?ind_id=' . $log['section_id']);

        if ($log['sub_section'] == 'Individual' or $log['sub_section'] == 'Image' or $log['sub_section'] == 'Nickname') {
            $subsection_link = $section_link;
        }
    }

    //  the AUTHOR TYPE SECTION
    if ($log['section'] == 'Author type') {
        $section_link = ("../individuals/individuals_author.php");

        if ($log['sub_section'] == 'Author type') {
            $subsection_link = $section_link;
        }
    }

    //  the INTERVIEW SECTION
    if ($log['section'] == 'Interviews') {
        $section_link = ("../interviews/interviews_edit.php" . '?interview_id=' . $log['sub_section_id']);

        if ($log['sub_section'] == 'Interview' or $log['sub_section'] == 'Screenshots') {
            $subsection_link = $section_link;
        }

        if ($log['sub_section'] == 'Comment') {
            $section_link = ("../interviews/interviews_edit.php" . '?interview_id=' . $log['section_id']);
            if ($log['action'] == 'Delete') {
                $subsection_link = ("../administration/change_log.php");
            } else {
                //$subsection_link = ("../interviews/interviews_comment_edit.php" . '?interview_user_comments_id=' . $log['sub_section_id'] . '&v_counter=0');
                $subsection_link = ("../administration/comments.php");
            }
        }
    }

    //  the REVIEW SECTION
    if ($log['section'] == 'Reviews') {
        //$section_link = ("../games/games_review_comment_edit.php" . '?review_user_comments_id=' . $log['sub_section_id'] . '&v_counter=0');
        $section_link = ("../administration/comments.php");

        if ($log['sub_section'] == 'Comment') {
            if ($log['action'] == 'Delete') {
                $subsection_link = ("../administration/change_log.php");
            } else {
                //$subsection_link = ("../games/games_review_comment_edit.php" . '?review_user_comments_id=' . $log['sub_section_id'] . '&v_counter=0');
                $subsection_link = ("../administration/comments.php");
            }
        }
    }

    //  the NEWS SECTION
    if ($log['section'] == 'News') {
        if ($log['sub_section'] == 'News submit') {
            $section_link    = ("../news/news_approve.php");
            $subsection_link = $section_link;
        }

        if ($log['sub_section'] == 'News item') {
            $section_link    = ("../news/news_edit.php" . '?news_id=' . $log['sub_section_id']);
            $subsection_link = $section_link;
        }

        if ($log['sub_section'] == 'Image') {
            $section_link    = ("../news/news_edit_images.php");
            $subsection_link = $section_link;
        }
    }

    //  the MENU SET SECTION
    if ($log['section'] == 'Menu set') {
        $section_link = ("../menus/menus_disk_list.php" . '?menu_sets_id=' . $log['section_id']);

        if ($log['sub_section'] == 'Menu set' or $log['sub_section'] == 'Menu disk (multiple)' or $log['sub_section'] == 'Menu type' or $log['sub_section'] == 'Menu disk') {
            $subsection_link = $section_link;
        }

        if ($log['sub_section'] == 'Crew') {
            $subsection_link = "../crew/crew_editor.php?crewbrowse=&crewsearch=&crew_select=" . $log['sub_section_id'];
        }

        if ($log['sub_section'] == 'Individual') {
            $subsection_link = ("../individuals/individuals_edit.php" . '?ind_id=' . $log['sub_section_id']);
        }
    }

    //  the CREW SECTION
    if ($log['section'] == 'Crew') {
        $section_link = "../crew/crew_editor.php?crewbrowse=&crewsearch=&crew_select=" . $log['section_id'];

        if ($log['sub_section'] == 'Crew' or $log['sub_section'] == 'Logo') {
            $subsection_link = "../crew/crew_editor.php?crewbrowse=&crewsearch=&crew_select=" . $log['sub_section_id'];
        }

        if ($log['sub_section'] == 'Subcrew') {
            $subsection_link = "../crew/crew_editor.php?crewbrowse=&crewsearch=&crew_select=" . $log['sub_section_id'];
            $section_link    = "../crew/crew_genealogy.php?action=genealogy&crewbrowse=&crewsearch=&crew_select=" . $log['section_id'];
        }

        if ($log['sub_section'] == 'Member' or $log['sub_section'] == 'Nickname') {
            $subsection_link = ("../individuals/individuals_edit.php" . '?ind_id=' . $log['sub_section_id']);
            $section_link    = "../crew/crew_genealogy.php?action=genealogy&crewbrowse=&crewsearch=&crew_select=" . $log['section_id'];
        }
    }

    //  the MENU TYPE SECTION
    if ($log['section'] == 'Menu type') {
        $section_link = ("../menus/menus_type_edit.php" . '?menu_type_id=' . $log['section_id']);

        if ($log['sub_section'] == 'Menu type') {
            $subsection_link = ("../menus/menus_type_edit.php" . '?menu_type_id=' . $log['section_id']);
        }
    }

    //  the MENU DISK SECTION
    if ($log['section'] == 'Menu disk') {
        $section_link    = ("../menus/menus_disk_list.php" . '?menu_sets_id=' . $log['section_id']);
        $subsection_link = $section_link;

        if ($log['sub_section'] == 'Credits' or $log['sub_section'] == 'Nickname') {
            $subsection_link = ("../individuals/individuals_edit.php" . '?ind_id=' . $log['sub_section_id']);
        }

        if ($log['sub_section'] == 'Game' or $log['sub_section'] == 'Game doc' or $log['sub_section'] == 'Authors') {
            $subsection_link = ("../games/games_detail.php" . '?game_id=' . $log['sub_section_id']);
        }

        if ($log['sub_section'] == 'Demo' or $log['sub_section'] == 'Tool' or $log['sub_section'] == 'Tool doc') {
            $subsection_link = "../administration/construction.php"; //TO DO
        }

        if ($log['sub_section'] == 'Doc type') {
            $subsection_link = ("../docs/doc_type_edit.php" . '?doc_type_id=' . $log['sub_section_id']);
        }
    }

    //  the ARTICLES SECTION
    if ($log['section'] == 'Articles') {
        $section_link = ("../articles/articles_edit.php" . '?article_id=' . $log['sub_section_id']);

        if ($log['sub_section'] == 'Article' or $log['sub_section'] == 'Screenshots') {
            $subsection_link = $section_link;
        }
        
        if ($log['sub_section'] == 'Comment') {
            $section_link = ("../articles/articles_edit.php" . '?article_id=' . $log['section_id']);
            if ($log['action'] == 'Delete') {
                $subsection_link = ("../administration/comments.php");
            } else {
                //$subsection_link = ("../interviews/interviews_comment_edit.php" . '?interview_user_comments_id=' . $log['sub_section_id'] . '&v_counter=0');
                $subsection_link = ("../administration/comments.php");
            }
        }
    }

    //  the ARTICLE TYPE SECTION
    if ($log['section'] == 'Article type') {
        $section_link = ("../articles/article_type_edit.php" . '?article_type_id=' . $log['section_id']);

        if ($log['sub_section'] == 'Article type') {
            $subsection_link = ("../articles/article_type_edit.php" . '?article_type_id=' . $log['section_id']);
        }
    }

    //  the DOC TYPE SECTION
    if ($log['section'] == 'Doc type') {
        $section_link = ("../docs/doc_type_edit.php" . '?doc_type_id=' . $log['section_id']);

        if ($log['sub_section'] == 'Doc type') {
            $subsection_link = ("../docs/doc_type_edit.php" . '?doc_type_id=' . $log['section_id']);
        }
    }

    //  the DOC CATEGORRY SECTION
    if ($log['section'] == 'Doc category') {
        $section_link = ("../docs/doc_category_edit.php" . '?doc_category_id=' . $log['section_id']);

        if ($log['sub_section'] == 'Doc category') {
            $subsection_link = ("../docs/doc_category_edit.php" . '?doc_category_id=' . $log['section_id']);
        }
    }

    //  the DOWNLOAD FORMAT SECTION
    if ($log['section'] == 'Format') {
        $section_link = ("../downloads/download_format_edit.php" . '?format_id=' . $log['section_id']);

        if ($log['sub_section'] == 'Format') {
            $subsection_link = ("../downloads/download_format_edit.php" . '?format_id=' . $log['section_id']);
        }
    }

    //  the DOWNLOAD LINGO SECTION
    if ($log['section'] == 'Lingo') {
        $section_link = ("../downloads/download_lingo_edit.php" . '?lingo_id=' . $log['section_id']);

        if ($log['sub_section'] == 'Lingo') {
            $subsection_link = ("../downloads/download_lingo_edit.php" . '?lingo_id=' . $log['section_id']);
        }
    }

    //  the DOWNLOAD OPTIONS SECTION
    if ($log['section'] == 'Option') {
        $section_link = ("../downloads/download_options_edit.php" . '?option_id=' . $log['section_id']);

        if ($log['sub_section'] == 'Option') {
            $subsection_link = ("../downloads/download_options_edit.php" . '?option_id=' . $log['section_id']);
        }
    }

    //  the TOS VERSION SECTION
    if ($log['section'] == 'TOS') {
        $section_link = ("../downloads/download_tos_edit.php" . '?tos_id=' . $log['section_id']);

        if ($log['sub_section'] == 'TOS') {
            $subsection_link = ("../downloads/download_tos_edit.php" . '?tos_id=' . $log['section_id']);
        }
    }

    //  the TRAINER OPTION SECTION
    if ($log['section'] == 'Trainer') {
        $section_link = ("../downloads/download_trainer_edit.php" . '?trainer_id=' . $log['section_id']);

        if ($log['sub_section'] == 'Trainer') {
            $subsection_link = ("../downloads/download_trainer_edit.php" . '?trainer_id=' . $log['section_id']);
        }
    }

    //  the DOWNLOAD EDIT SECTION
    if ($log['section'] == 'Downloads') {
        $section_link = ("../downloads/downloads_game_detail.php" . '?game_id=' . $log['section_id']);

        if ($log['sub_section'] == 'Options') {
            $subsection_link = ("../downloads/download_options_edit.php" . '?option_id=' . $log['sub_section_id']);
        }

        if ($log['sub_section'] == 'TOS') {
            $subsection_link = ("../downloads/download_tos_edit.php" . '?tos_id=' . $log['sub_section_id']);
        }

        if ($log['sub_section'] == 'Details') {
            $subsection_link = $section_link;
        }

        if ($log['sub_section'] == 'Menudisk') {
            $subsection_link = $section_link;
        }

        if ($log['sub_section'] == 'Chain') {
            $subsection_link = $section_link;
        }

        if ($log['sub_section'] == 'Trainer') {
            $subsection_link = ("../downloads/download_trainer_edit.php" . '?trainer_id=' . $log['sub_section_id']);
        }

        if ($log['sub_section'] == 'Crew') {
            $subsection_link = ("../crew/crew_editor.php?crewbrowse=&crewsearch=&crew_select=" . $log['sub_section_id']);
        }

        if ($log['sub_section'] == 'Authors') {
            $subsection_link = ("../individuals/individuals_edit.php" . '?ind_id=' . $log['sub_section_id']);
        }
    }

    //  the BUG REPORT TYPE SECTION
    if ($log['section'] == 'Bug type') {
        $section_link = ("../administration/bug_report_type_edit.php" . '?type_id=' . $log['section_id']);

        if ($log['sub_section'] == 'Bug type') {
            $subsection_link = ("../administration/bug_report_type_edit.php" . '?type_id=' . $log['section_id']);
        }
    }

    //  the BUG REPORT SECTION
    if ($log['section'] == 'Bug') {
        $section_link    = ("../administration/bug_report.php");
        $subsection_link = ("../administration/bug_report.php");
    }
    
    //  the GAMES CONFIG SECTION
    if ($log['section'] == 'Games Config') {
        $section_link    = ("../games/games_config.php");
        $subsection_link = ("../games/games_config.php");
    }
    
    //  the GAMES RELEASE SECTION
    if ($log['section'] == 'Game Release') {
        $section_link    = ("../games/games_release_detail.php" . '?game_id=' . $log['section_id'] . '&release_id=' . $log['sub_section_id']);
        if ($log['sub_section'] == 'Game Release' OR $log['sub_section'] == 'Release Info' OR $log['sub_section'] == 'Release AKA' OR $log['sub_section'] == 'Compatibility'
            OR $log['sub_section'] == 'Distributor' OR $log['sub_section'] == 'Scene' OR $log['sub_section'] == 'Memory Enhancement' OR $log['sub_section'] == 'Minimum Memory'
            OR $log['sub_section'] == 'Tos') {
            $subsection_link = ("../games/games_release_detail.php" . '?game_id=' . $log['section_id'] . '&release_id=' . $log['sub_section_id']);
        }
    }

    $smarty->append('log', array(
        'log_user_name' => $user_name,
        'log_user_id' => $log['user_id'],
        'log_date' => $log_date,
        'log_section_link' => $section_link,
        'log_subsection_link' => $subsection_link,
        'log_action' => $log['action'],
        'log_section' => $log['section'],
        'log_section_name' => $log['section_name'],
        'log_subsection_name' => $log['sub_section_name'],
        'log_subsection' => $log['sub_section']
    ));
}

//Check if back arrow is needed
if ($v_counter > 0) {
    // Build the link
    if ($action == 'log_search') {
        $v_linkback = ("change_log.php?action=log_search" . '&Date_Year=' . ($Date_Year) . '&Date_Month=' . ($Date_Month) . '&Date_Day=' . ($Date_Day) . '&v_counter=' . ($v_counter - 25));
    } else {
        $v_linkback = ("change_log.php" . '?v_counter=' . ($v_counter - 25));
    }
}

//Check if we need to place a next arrow
if ($v_log > ($v_counter + 25)) {
    // Build the link
    if ($action == 'log_search') {
        $v_linknext = ("change_log.php?action=log_search" . '&Date_Year=' . ($Date_Year) . '&Date_Month=' . ($Date_Month) . '&Date_Day=' . ($Date_Day) . '&v_counter=' . ($v_counter + 25));
    } else {
        $v_linknext = ("change_log.php" . '?v_counter=' . ($v_counter + 25));
    }
}

$smarty->assign('links', array(
    'linkback' => $v_linkback,
    'linknext' => $v_linknext
));

$smarty->assign("user_id", $_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "change_log.html");

//close the connection
mysqli_close($mysqli);

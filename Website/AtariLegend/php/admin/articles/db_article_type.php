<?php
/***************************************************************************
*                                db_article_type.php
*                            --------------------------
*   begin                : October 10, 2016
*   copyright            : (C) 2016 Atari Legend
*   email                : martens_maarten@hotmail.com
*                           Created file
*
***************************************************************************/

// We are using the action var to separate all the queries.
include("../../includes/common.php");
include("../../includes/admin.php");

//update the article type
if (isset($article_type_id) and isset($action) and $action == 'update')
{
  $sdbquery = $mysqli->query("UPDATE article_type SET article_type = '$article_type_name' WHERE article_type_id = $article_type_id")
                              or die("Couldn't Update the article type");

  $_SESSION['edit_message'] = "Article type succesfully updated";

  create_log_entry('Article type', $article_type_id, 'Article type', $article_type_id, 'Update', $_SESSION['user_id']);

  header("Location: ../articles/article_type_edit.php?article_type_id=$article_type_id");
}

if (isset($article_type_id) and isset($action) and $action == 'delete_article_type')
{
  // first see if this menu type is used for a menu set or menu disk
  $sql = $mysqli->query("SELECT * FROM article_main
                          WHERE article_type_id = '$article_type_id'") or die ("error selecting article");
  if ( $sql->num_rows > 0 )
  {
    $_SESSION['edit_message'] = 'Deletion failed - This article type is linked to an article';
  }
  else
  {
    create_log_entry('Article type', $article_type_id, 'Article type', $article_type_id, 'Delete', $_SESSION['user_id']);

    $mysqli->query("DELETE FROM article_type WHERE article_type_id = $article_type_id")
            or die("Failed to delete article type");

    $_SESSION['edit_message'] = "Article type succesfully deleted";
  }

  header("Location: ../articles/article_type.php");
}

if (isset($action) and $action == 'insert_type')
{
  if ( $type_name == '' )
  {
    $_SESSION['edit_message'] = "Please fill in a article type name";
    header("Location: ../articles/article_type.php");
  }
  else
  {
    $sql_article_type = $mysqli->query("INSERT INTO article_type (article_type) VALUES ('$type_name')") or die ("error inserting article type");

    $new_article_type_id = $mysqli->insert_id;

    create_log_entry('Article type', $new_article_type_id, 'Article type', $new_Article_type_id, 'Insert', $_SESSION['user_id']);

    $_SESSION['edit_message'] = "article type succesfully inserted";
    header("Location: ../articles/article_type.php");
  }
}


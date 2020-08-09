<?php
require_once __DIR__."/../../config/common.php";
require_once __DIR__."/../DAO/ValidateLinkDAO.php";

if (isset($name)
    && isset($url)
    && isset($description)) {
    $dao = new AL\Common\DAO\ValidateLinkDAO($mysqli);
    $id = $dao->addValidateLink($name, $url, $description);

    create_log_entry('Links', $id, 'Link submit', $id, 'Insert', $_SESSION['user_id']);

    $_SESSION['edit_message'] = "Link submitted successfully - Waiting for approval by admin";
} else {
    $_SESSION['edit_message'] = "Please fill in all required fields";
}


header("Location: ../../main/links/links_main.php");

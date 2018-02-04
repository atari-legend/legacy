<?php
/**
 * Generate the general sitemap for all content pages except the games
 */

require_once __DIR__."/../../config/common.php";
require_once __DIR__."/../../common/DAO/LinkCategoryDAO.php";

// Retrieve all interview ids
$stmt = $mysqli->prepare("SELECT interview_id FROM interview_main ORDER BY interview_id")
    or die($mysqli->error);
$stmt->execute() or die($mysqli->error);
$stmt->bind_result($interview_id) or die($mysqli->error);

$interview_ids = [];
while ($stmt->fetch()) {
    $interview_ids[] = $interview_id;
}
$stmt->close();
$smarty->assign("interview_ids", $interview_ids);

// Retrieve all review ids
$stmt = $mysqli->prepare("SELECT review_id FROM review_main ORDER BY review_id")
    or die($mysqli->error);
$stmt->execute() or die($mysqli->error);
$stmt->bind_result($review_id) or die($mysqli->error);

$review_ids = [];
while ($stmt->fetch()) {
    $review_ids[] = $review_id;
}
$stmt->close();
$smarty->assign("review_ids", $review_ids);

// Retrieve all Link categories
$linkCategoryDao = new AL\Common\DAO\LinkCategoryDAO($mysqli);
$smarty->assign("link_categories", $linkCategoryDao->getAllCategories());

header("Content-Type: application/xml");

$smarty->display("file:${mainsite_template_folder}sitemap_general.xml");

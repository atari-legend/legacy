<?php
// RSS feed for the latest news
require_once __DIR__."/../../config/common.php";
require_once __DIR__."/../../common/DAO/NewsDAO.php";

$newsDao = new AL\Common\DAO\NewsDAO($mysqli);
$news = $newsDao->getLatestNews();
$smarty->assign('news', $news);

// Set the last updated date of the entire feed.
// It will be the updated date of the latest article
if (count($news) > 0) {
    $smarty->assign('last_updated', $news[0]->getDate());
} else {
    $smarty->assign('last_updated', 0);
}

// header("Content-Type: application/atom+xml");
$smarty->display("file:${mainsite_template_folder}news_atom.xml");



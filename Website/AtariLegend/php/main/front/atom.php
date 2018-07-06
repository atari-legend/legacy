<?php
/**
 * RSS feed for the latest news, reviews and interviews
 * -
 * Get the latest 20 news, reviews and interviews, sort them by
 * descending date, and retain the most recent 20 items
 */
require_once __DIR__."/../../config/common.php";
require_once __DIR__."/../../common/DAO/NewsDAO.php";
require_once __DIR__."/../../common/DAO/GameReviewDAO.php";
require_once __DIR__."/../../common/DAO/InterviewDAO.php";
require_once __DIR__."/../../common/DAO/ArticleDAO.php";

$items = [];

// Get latest news
$newsDao = new AL\Common\DAO\NewsDAO($mysqli);
$news = $newsDao->getLatestNews();
foreach ($news as $article) {
    $items[] = array(
        "title" => "News: ".$article->getHeadline(),
        "link" => REQUEST_SITEURL."/news/news.php",
        "id" => REQUEST_SITEURL."/news/news.php?id=".$article->getId(),
        "updated" => $article->getDate(),
        "author" => $article->getUser()->getName(),
        "content" => $article->getHtmlText()
    );
}

// Get latest reviews
$gameReviewDao = new AL\Common\DAO\GameReviewDAO($mysqli);
$gameReviews = $gameReviewDao->getLatestGameReviews();
foreach ($gameReviews as $review) {
    $items[] = array(
        "title" => "Review: ".$review->getGameName(),
        "link" => REQUEST_SITEURL."/games/games_reviews_detail.php?review_id=".$review->getId(),
        "id" => REQUEST_SITEURL."/games/games_reviews_detail.php?review_id=".$review->getId(),
        "updated" => $review->getDate(),
        "author" => $review->getUser(),
        "content" => $review->getFrontPageHtml()
    );
}

// Get latest interviews
$interviewDao = new AL\Common\DAO\InterviewDAO($mysqli);
$interviews = $interviewDao->getLatestInterviews();
foreach ($interviews as $interview) {
    $items[] = array(
        "title" => "Interview: ".$interview->getIndividual(),
        "link" => REQUEST_SITEURL."/interviews/interviews_detail.php?selected_interview_id=".$interview->getId(),
        "id" => REQUEST_SITEURL."/interviews/interviews_detail.php?selected_interview_id=".$interview->getId(),
        "updated" => $interview->getDate(),
        "author" => $interview->getUser(),
        "content" => $interview->getIntroHtml()
    );
}

// Get latest articles
$articleDao = new AL\Common\DAO\ArticleDAO($mysqli);
$articles = $articleDao->getLatestArticles();
foreach ($articles as $article) {
    $items[] = array(
        "title" => "Article: ".$article->getTitle(),
        "link" => REQUEST_SITEURL."/articles/articles_detail.php?selected_article_id=".$article->getId(),
        "id" => REQUEST_SITEURL."/articles/articles_detail.php?selected_article_id=".$article->getId(),
        "updated" => $article->getDate(),
        "author" => $article->getUser(),
        "content" => $article->getIntroHtml()
    );
}

/**
 * Sort Atom items by date
 * @param array First atom item
 * @param array Second atom item
 * @return integer Compared value of items
 */
function sort_by_date($a, $b) {
    return $b["updated"] - $a["updated"];
}

// Sort items by descending date
usort($items, "sort_by_date");
// Only retain the 20 first items
$smarty->assign('items', array_slice($items, 0, 20));

// Set the last updated date of the entire feed.
// It will be the updated date of the latest item
if (count($items) > 0) {
    $smarty->assign('last_updated', $items[0]["updated"]);
} else {
    $smarty->assign('last_updated', 0);
}

// header("Content-Type: application/atom+xml");
$smarty->display("file:${mainsite_template_folder}atom.xml");



<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/News/News.php" ;

/**
 * DAO for News
 */
class NewsDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Return the latest news, sorted by descending date
     *
     * @param integer $limit How many news to return
     * @return \AL\Common\Model\News\News[] An array of news
     */
    public function getLatestNews($limit = 20) {
        $stmt = \AL\Db\execute_query(
            "NewsDAO: getLatestNews",
            $this->mysqli,
            "SELECT
                news.news_id,
                news.news_headline,
                news.news_text,
                news.news_date,
                CONCAT(news_image.news_image_name, \".\", news_image.news_image_ext) as news_image,
                users.userid
            FROM
                news
            LEFT JOIN news_image ON
                (news.news_image_id = news_image.news_image_id)
            LEFT JOIN users ON
                (news.user_id = users.user_id)
            ORDER BY
                news.news_date DESC
            LIMIT ?",
            "i", $limit
        );

        \AL\Db\bind_result(
            "NewsDAO: getLatestNews",
            $stmt,
            $id, $headline, $text, $date, $image, $user
        );

        $news = [];
        while ($stmt->fetch()) {
            $news[] = new \AL\Common\Model\News\News(
                $id,
                $headline,
                $text,
                $date,
                $image,
                $user
            );
        }

        $stmt->close();

        return $news;
    }
}

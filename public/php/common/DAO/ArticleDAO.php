<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Article/Article.php" ;

/**
 * DAO for Article
 */
class ArticleDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Return the latest Articles, sorted by descending date
     *
     * @param integer $limit How many articles to return
     * @return \AL\Common\Model\Article\Article[] An array of Articles
     */
    public function getLatestArticles($limit = 20) {
        $stmt = \AL\Db\execute_query(
            "ArticleDAO: getLatestArticles",
            $this->mysqli,
            "SELECT
                article_main.article_id,
                article_text.article_title,
                article_text.article_intro,
                article_text.article_date,
                users.userid
            FROM
                article_main
            LEFT JOIN article_text ON article_text.article_id = article_main.article_id
            LEFT JOIN users ON article_main.user_id = users.user_id
            ORDER BY
                article_date
            DESC
            LIMIT ?",
            "i", $limit
        );

        \AL\Db\bind_result(
            "ArticleDAO: getLatestArticles",
            $stmt,
            $id, $title, $intro, $date, $user
        );

        $articles = [];
        while ($stmt->fetch()) {
            $articles[] = new \AL\Common\Model\Article\Article(
                $id,
                $title,
                $intro,
                $date,
                $user
            );
        }

        $stmt->close();

        return $articles;
    }
}

<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/News/News.php" ;
require_once __DIR__."/../Model/User/User.php" ;

/**
 * DAO for News
 */
class NewsDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    private function getLatestNewsQuery($user_id = null, $last_timestamp = null, $words = null) {
        // DISTINCT is currently needed because there may
        // be multiple matches for a word in news_search_wordlist, one for
        // the word is in the title and one for the word in the content.
        // That result in the same news being returned twice. It would be
        // preferable to fix the DB structure, but we have other priorities
        // for now...
        $query = "SELECT
                DISTINCT(news.news_id),
                news.news_headline,
                news.news_text,
                news.news_date,
                news.user_id,
                CONCAT(news_image.news_image_id, '.', news_image.news_image_ext) as news_image,
                news_image.news_image_id,
                users.user_id,
                users.userid,
                users.email,
                users.join_date,
                users.karma,
                users.avatar_ext,
                (SELECT COUNT(*)
                    FROM news
                    WHERE news.user_id = users.user_id) AS user_news_count
            FROM news
            LEFT JOIN news_image ON news.news_image_id = news_image.news_image_id
            LEFT JOIN users ON news.user_id = users.user_id";

        if ($words != null) {
            $query .= " LEFT JOIN news_search_wordmatch
                    ON news_search_wordmatch.news_id = news.news_id
                LEFT JOIN news_search_wordlist
                    ON news_search_wordlist.news_word_id = news_search_wordmatch.news_word_id";
        }

        $constraints = [];
        if ($user_id != null) {
            $constraints[] = "news.user_id = ?";
        }
        if ($last_timestamp != null) {
            $constraints[] = "news.news_date < ?";
        }
        if ($words != null) {
            $constraints[] = "news_search_wordlist.news_word_text = ?";
        }

        $query .= \AL\Db\assemble_constraints($constraints);

        $query .= " ORDER BY news_date DESC LIMIT ?";

        return $query;
    }

    /**
     * Return the latest news, sorted by descending date
     *
     * @param integer $limit How many news to return
     * @param integer $user_id To retrieve the news of a specific user only
     * @param integer $user_id To retrieve only the news before a given timestamp
     * @return \AL\Common\Model\News\News[] An array of news
     */
    public function getLatestNews($limit = 20, $user_id = null, $last_timestamp = null, $words = null) {
        $query = $this->getLatestNewsQuery($user_id, $last_timestamp, $words);
        $bind_string = "";
        $bind_params = array();

        if ($user_id != null) {
            $bind_string .= "i";
            $bind_params[] = $user_id;
        }
        if ($last_timestamp != null) {
            $bind_string .= "i";
            $bind_params[] = $last_timestamp;
        }
        if ($words != null) {
            $bind_string .= "s";
            $bind_params[] = $words;
        }

        $bind_string .= "i";
        $bind_params[] = $limit;

        $stmt = \AL\Db\execute_query(
            "NewsDAO: getLatestNews",
            $this->mysqli,
            $query,
            $bind_string, ...$bind_params
        );

        \AL\Db\bind_result(
            "NewsDAO: getLatestNews",
            $stmt,
            $id,
            $headline,
            $text,
            $date,
            $userid,
            $image,
            $image_id,
            $user_id,
            $user_userid,
            $user_email,
            $user_join_date,
            $user_karma,
            $user_avatar_ext,
            $user_news_count
        );

        $news = [];
        while ($stmt->fetch()) {
            $user = new \AL\Common\Model\User\User(
                $user_id,
                $user_userid,
                $user_email,
                $user_join_date,
                $user_karma,
                $user_avatar_ext,
                $user_news_count
            );

            $news[] = new \AL\Common\Model\News\News(
                $id,
                $headline,
                $text,
                $date,
                $image,
                $image_id,
                $user
            );
        }

        $stmt->close();

        return $news;
    }

    /**
    * Return a specific news article

    * @return \AL\Common\Model\News\News A single news
    */
    public function getNews($news_id) {
        $stmt = \AL\Db\execute_query(
            "NewsDAO: getNews",
            $this->mysqli,
            "SELECT
                news.news_id,
                news.news_headline,
                news.news_text,
                news.news_date,
                news.user_id,
                CONCAT(news_image.news_image_id, '.', news_image.news_image_ext) as news_image,
                news_image.news_image_id,
                users.user_id,
                users.userid,
                users.email,
                users.join_date,
                users.karma,
                users.avatar_ext,
                (SELECT COUNT(*)
                    FROM news
                    WHERE news.user_id = users.user_id) AS user_news_count
            FROM news
            LEFT JOIN news_image ON news.news_image_id = news_image.news_image_id
            LEFT JOIN users ON news.user_id = users.user_id
            WHERE news.news_id = ?",
            "i", $news_id
        );

        \AL\Db\bind_result(
            "NewsDAO: getNews",
            $stmt,
            $id,
            $headline,
            $text,
            $date,
            $userid,
            $image,
            $image_id,
            $user_id,
            $user_userid,
            $user_email,
            $user_join_date,
            $user_karma,
            $user_avatar_ext,
            $user_news_count
        );

        $news = null;

        if ($stmt->fetch()) {
            $user = new \AL\Common\Model\User\User(
                $user_id,
                $user_userid,
                $user_email,
                $user_join_date,
                $user_karma,
                $user_avatar_ext,
                $user_news_count
            );

            $news = new \AL\Common\Model\News\News(
                $id,
                $headline,
                $text,
                $date,
                $image,
                $image_id,
                $user
            );
        }

        $stmt->close();

        return $news;
    }

    /**
    * Get the total count of news on the website
    * @return number Total number of news
    */
    public function getNewsCount() {
        $stmt = \AL\Db\execute_query(
            "NewsDAO: getNewsCount",
            $this->mysqli,
            "SELECT COUNT(*) FROM news",
            null,
            null
        );

        \AL\Db\bind_result(
            "NewsDAO: getNewsCount",
            $stmt,
            $count
        );

        $stmt->fetch();
        $stmt->close();

        return $count;
    }
}

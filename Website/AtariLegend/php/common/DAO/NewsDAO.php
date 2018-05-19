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
    
    private function getNewsQuery($user_id = null, $last_timestamp = null, $action = null, $view = null) {
            
        $query =  "SELECT
                news.news_id,
                news.news_headline,
                news.news_text,
                news.news_date as date,
                news.news_date as timestamp,
                news_image.news_image_id,
                CONCAT(news_image.news_image_id, \".\", news_image.news_image_ext) as news_image,
                users.user_id,
                users.userid,
                users.email,
                users.join_date,
                users.karma,
                users.avatar_ext,
                (SELECT COUNT(*) 
                        FROM news 
                            WHERE news.user_id = users.user_id) AS user_news_count
            FROM
                news
            LEFT JOIN news_image ON
                (news.news_image_id = news_image.news_image_id)
            LEFT JOIN users ON
                (news.user_id = users.user_id)";
                
        if (isset($view) and $view == "users_news") {
            $query .= " WHERE news.user_id = $user_id";
        }
        
        if (isset($action) and $action=="autoload") {
            if (isset($view) and $view == "users_news") {
                if (isset($user_id)) {
                    $query .= " AND news.news_date < $last_timestamp ";
                } else {
                    $query .= " WHERE news.news_date < $last_timestamp ";
                }
            } else {
                    $query .= " WHERE news.news_date < $last_timestamp ";
            }
        }
        
        //This is added when we save, we don't want the news page to 'refresh'
        if (isset($action) and $action=="autoload_save") {
            if (isset($view) and $view == "users_news") {
                if (isset($user_id)) {
                    $query .= " AND news.news_date >= $last_timestamp ORDER BY news_date DESC";
                } else {
                    $query .= " WHERE news.news_date >= $last_timestamp ORDER BY news_date DESC";
                }
            } else {
                    $query .= " WHERE news.news_date >= $last_timestamp ORDER BY news_date DESC";
            }
        } else {
            $query .= " ORDER BY news_date DESC LIMIT 5";
        }
            
        return $query;
    }

    /**
     * Return the latest news, sorted by descending date
     *
     * @param integer $limit How many news to return
     * @return \AL\Common\Model\News\News[] An array of news
     */
    public function getLatestNews($user_id = null, $last_timestamp = null, $action = null, $view = null) {
        $stmt = \AL\Db\execute_query(
            "NewsDAO: getLatestNews",
            $this->mysqli,
            $this->getNewsQuery($user_id, $last_timestamp, $action, $view),
            null, null
        );

        \AL\Db\bind_result(
            "NewsDAO: getLatestNews",
            $stmt,
            $id,
            $headline,
            $text,
            $timestamp,
            $date,
            $image_id,
            $image,
            $userid,
            $username,
            $email,
            $join_date,
            $karma,
            $avatar_ext,
            $user_news_count
        );

        $news = [];
        while ($stmt->fetch()) {
            $text = nl2br($text);
            $text = InsertALCode($text);
            $text = trim($text);
            $text = RemoveSmillies($text);
            
            $news[] = new \AL\Common\Model\News\News(
                $id,
                $headline,
                $text,
                $timestamp,
                $date,
                $image_id,
                $image,
                $userid,
                $username,
                $email,
                $join_date,
                $karma,
                $avatar_ext,
                $user_news_count
            );
        }

        $stmt->close();

        return $news;
    }
    
    
    /**
    * Return all news posts, sorted by descending date
    * @return \AL\Common\Model\News\News[] An array of news
    */
 /**   public function getAllNewsForUser($user_id = null, $last_timestamp = null, $action = null, $view = null) {
         $stmt = \AL\Db\execute_query(
            "NewsDAO: getAllNewsForUser",
            $this->mysqli,
            $this->getNewsQuery($user_id, $last_timestamp, $action, $view),
            null, null
        );

        \AL\Db\bind_result(
            "NewsDAO: getLatestNews",
            $stmt,
            $id,
            $headline,
            $text,
            $timestamp,
            $date,
            $image_id,
            $image,
            $userid,
            $username,
            $email,
            $join_date,
            $karma,
            $avatar_ext,
            $user_news_count
        );

        $news = [];
        while ($stmt->fetch()) {
            $text = nl2br($text);
            $text = InsertALCode($text);
            $text = trim($text);
            $text = RemoveSmillies($text);

            $news[] = new \AL\Common\Model\News\News(
                $id,
                $headline,
                $text,
                $timestamp,
                $date,
                $image_id,
                $image,
                $userid,
                $username,
                $email,
                $join_date,
                $karma,
                $avatar_ext,
                $user_news_count
            );
        }

        $stmt->close();

        return $news;
    }
**/
     /**
    * Get the total count of news on the website
    *
    * @param  integer $user_id Optional ID of a user to count comments for
    * @return integer Number of comments     */
    public function getNewsCount($user_id = null) {
        if (isset($user_id)) {
            $stmt = \AL\Db\execute_query(
                "NewsDAO: Get news count for user_id $user_id",
                $this->mysqli,
                "SELECT COUNT(*) FROM news WHERE user_id = ?",
                "i",
                $user_id
            );
        } else {
            $stmt = \AL\Db\execute_query(
                "NewsDAO: Get news count in database",
                $this->mysqli,
                "SELECT COUNT(*) FROM news",
                null,
                null
            );
        }

        \AL\Db\bind_result(
            "NewsDAO: Get news count",
            $stmt,
            $count
        );

        $stmt->fetch();
        $stmt->close();

        return $count;
    }
    
        /**
    * Return a specific news submissions
    * @return \AL\Common\Model\News\News[] An array of news
    */
    public function getSpecificNews($news_id) {
        $stmt = \AL\Db\execute_query(
            "NewsDAO: getSpecificSubmissions",
            $this->mysqli,
            "SELECT
            news.news_id,
            news.news_headline,
            news.news_text,
            news.news_date as date,
            news.news_date as timestamp,
            news_image.news_image_id,
            CONCAT(news_image.news_image_id, \".\", news_image.news_image_ext) as news_image,
            users.user_id,
            users.userid,
            users.email,
            users.join_date,
            users.karma,
            users.avatar_ext,
            (SELECT COUNT(*) 
                    FROM news 
                        WHERE news.user_id = users.user_id) AS user_news_count
            FROM
                news
            LEFT JOIN news_image ON
                (news.news_image_id = news_image.news_image_id)
            LEFT JOIN users ON
                (news.user_id = users.user_id)
            WHERE news.news_id = ?",
            "i",
            $news_id
        );

        \AL\Db\bind_result(
            "NewsDAO: get specific News post",
            $stmt,
            $id,
            $headline,
            $text,
            $timestamp,
            $date,
            $image_id,
            $image,
            $userid,
            $username,
            $email,
            $join_date,
            $karma,
            $avatar_ext,
            $user_news_count
        );

        $news = [];
        
        while ($stmt->fetch()) {
            //$text = nl2br($text);
            //$text = InsertALCode($text);
            //$text = trim($text);
            //$text = RemoveSmillies($text);
            $breaks = array("<br />","<br>","<br/>");
            $text = str_ireplace($breaks, "\r\n", $text);
    
            $news[] = new \AL\Common\Model\News\News(
                $id,
                $headline,
                $text,
                $timestamp,
                $date,
                $image_id,
                $image,
                $userid,
                $username,
                $email,
                $join_date,
                $karma,
                $avatar_ext,
                $user_news_count
            );
        }

        $stmt->close();

        return $news;
    }
}

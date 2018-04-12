<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/News/News.php" ;

/**
 * DAO for News
 */
class NewsSearchDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }
    
    private function getNewsSearchQuery($user_id = null, $date = null, $text = null) {
            
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
            LEFT JOIN news_search_wordmatch ON (news_search_wordmatch.news_id = news.news_id) 
            LEFT JOIN news_search_wordlist ON (news_search_wordlist.news_word_id = news_search_wordmatch.news_word_id) 
            LEFT JOIN news_image ON
                (news.news_image_id = news_image.news_image_id)
            LEFT JOIN users ON
                (news.user_id = users.user_id)";
                
        if (isset($text) and $text != '') {
            $query .= " WHERE news_search_wordlist.news_word_text LIKE '$text'";
        } else {
            $query .= " WHERE news_search_wordlist.news_word_text LIKE '%'";
        }
             
        if (isset($user_id) and $user_id != '-') {
            $query .= " AND news.user_id = $user_id";
        }
        
        $query .= " AND news.news_date < $date";
             
        $query .= " GROUP BY news.news_id ORDER BY news_date DESC";
            
        return $query;
    }
    
    private function getNewsSearchCountQuery($user_id = null, $date = null, $text = null) {
            
        $query =  "SELECT count(news.news_id)
            FROM
                news
            LEFT JOIN news_search_wordmatch ON (news_search_wordmatch.news_id = news.news_id) 
            LEFT JOIN news_search_wordlist ON (news_search_wordlist.news_word_id = news_search_wordmatch.news_word_id) 
            LEFT JOIN news_image ON
                (news.news_image_id = news_image.news_image_id)
            LEFT JOIN users ON
                (news.user_id = users.user_id)";
                
        if (isset($text) and $text != '') {
            $query .= " WHERE news_search_wordlist.news_word_text LIKE '$text'";
        } else {
            $query .= " WHERE news_search_wordlist.news_word_text LIKE '%'";
        }
             
        if (isset($user_id) and $user_id != '-') {
            $query .= " AND news.user_id = $user_id";
        }
        
        $query .= " AND news.news_date < $date";
             
        $query .= " GROUP BY news.news_id";
            
        return $query;
    }

    /**
     * Return the latest news, sorted by descending date
     *
     * @param integer $limit How many news to return
     * @return \AL\Common\Model\News\News[] An array of news
     */
    public function getSearchNews($user_id = null, $date = null, $text = null) {
        $stmt = \AL\Db\execute_query(
            "NewsSearchDAO: getSearchNews",
            $this->mysqli,
            $this->getNewsSearchQuery($user_id, $date, $text),
            null, null
        );

        \AL\Db\bind_result(
            "NewsSearchDAO: getSearchNews",
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
    
    public function getSearchNewsCount($user_id = null, $date = null, $text = null) {
        $stmt = \AL\Db\execute_query(
            "NewsSearchDAO: getSearchNewsCount",
            $this->mysqli,
            $this->getNewsSearchCountQuery($user_id, $date, $text),
            null, null
        );

        \AL\Db\bind_result(
            "NewsSearchDAO: getSearchNewsCount",
            $stmt,
            $count
        );

        $stmt->fetch();
        $stmt->close();

        return $count;
    }
}

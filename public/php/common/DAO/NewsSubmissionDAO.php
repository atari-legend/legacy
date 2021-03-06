<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../../lib/functions.php" ;
require_once __DIR__."/../Model/News/NewsSubmission.php" ;

use AL\Common\Model\NewsSubmission;

/**
 * DAO for News Submlissions
 */
 
class NewsSubmissionDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }
    
    private function getSubmissionQuery($user_id = null, $news_id = null) {
        $query =  "SELECT
                news_submission.news_submission_id,
                  news_submission.news_headline,
                  news_submission.news_text, 
                  news_submission.news_date,
                  news_image.news_image_id,
                  CONCAT(news_image.news_image_id, \".\", news_image.news_image_ext) as news_image,
                  news_submission.user_id,
                  users.userid,
                  users.email,
                  users.join_date,
                  users.karma,
                  users.show_email,
                  users.avatar_ext,
                  (SELECT COUNT(*) 
                        FROM news_submission 
                            WHERE news_submission.user_id = users.user_id) AS user_submission_count
                  FROM news_submission
                  LEFT JOIN news_image ON (news_submission.news_image_id = news_image.news_image_id)
                  LEFT JOIN users ON (news_submission.user_id = users.user_id)";
              
        if (isset($user_id)) {
            $query .= " WHERE news_submission.user_id = ?";
        }

        $query .= " ORDER BY news_date DESC";

        return $query;
    }
    
    /**
    * Return all news submissions, sorted by descending date
    * @return \AL\Common\Model\News\News[] An array of news
    */
    public function getAllSubmissions() {
        $stmt = \AL\Db\execute_query(
            "NewsSubmissionDAO: getAllSubmissions",
            $this->mysqli,
            $this->getSubmissionQuery(),
            null, null
        );

        \AL\Db\bind_result(
            "NewsSubmissionDAO: get All Submissions",
            $stmt,
            $id,
            $headline,
            $text,
            $date,
            $image_id,
            $image,
            $userid,
            $username,
            $email,
            $join_date,
            $karma,
            $show_email,
            $avatar_ext,
            $user_subm_count
        );

        $news = [];
        
        while ($stmt->fetch()) {
            $text = nl2br($text);
            $text = InsertALCode($text);
            $text = trim($text);
            $text = RemoveSmillies($text);
        
            $news[] = new \AL\Common\Model\NewsSubmission\NewsSubmission(
                $id,
                $headline,
                $text,
                $date,
                $image_id,
                $image,
                $userid,
                $username,
                $email,
                $join_date,
                $karma,
                $show_email,
                $avatar_ext,
                $user_subm_count
            );
        }

        $stmt->close();

        return $news;
    }
    
    /**
    * Return all news submissions, sorted by descending date
    * @return \AL\Common\Model\News\News[] An array of news
    */
    public function getAllSubmissionsForUser($user_id) {
        $stmt = \AL\Db\execute_query(
            "NewsSubmissionDAO: getAllSubmissions",
            $this->mysqli,
            $this->getSubmissionQuery($user_id),
            "i", $user_id
        );

        \AL\Db\bind_result(
            "NewsSubmissionDAO: get All Submissions",
            $stmt,
            $id,
            $headline,
            $text,
            $date,
            $image_id,
            $image,
            $userid,
            $username,
            $email,
            $join_date,
            $karma,
            $show_email,
            $avatar_ext,
            $user_subm_count
        );

        $news = [];
        
        while ($stmt->fetch()) {
            $text = nl2br($text);
            $text = InsertALCode($text);
            $text = trim($text);
            $text = RemoveSmillies($text);
        
            $news[] = new \AL\Common\Model\NewsSubmission\NewsSubmission(
                $id,
                $headline,
                $text,
                $date,
                $image_id,
                $image,
                $userid,
                $username,
                $email,
                $join_date,
                $karma,
                $show_email,
                $avatar_ext,
                $user_subm_count
            );
        }

        $stmt->close();

        return $news;
    }
    
    
    /**
    * Return a specific news submissions
    * @return \AL\Common\Model\News\News[] An array of news
    */
    public function getSpecificSubmissions($news_id) {
        $stmt = \AL\Db\execute_query(
            "NewsSubmissionDAO: getSpecificSubmissions",
            $this->mysqli,
            "SELECT
            news_submission.news_submission_id,
            news_submission.news_headline,
            news_submission.news_text, 
            news_submission.news_date,
            news_image.news_image_id,
            CONCAT(news_image.news_image_id, \".\", news_image.news_image_ext) as news_image,
            news_submission.user_id,
            users.userid,
            users.email,
            users.join_date,
            users.karma,
            users.show_email,
            users.avatar_ext,
            (SELECT COUNT(*) 
                FROM news_submission 
                    WHERE news_submission.user_id = users.user_id) AS user_submission_count
            FROM news_submission
            LEFT JOIN news_image ON (news_submission.news_image_id = news_image.news_image_id)
            LEFT JOIN users ON (news_submission.user_id = users.user_id)
            WHERE news_submission.news_submission_id = ?",
            "i",
            $news_id
        );

        \AL\Db\bind_result(
            "NewsSubmissionDAO: get specific Submissions",
            $stmt,
            $id,
            $headline,
            $text,
            $date,
            $image_id,
            $image,
            $userid,
            $username,
            $email,
            $join_date,
            $karma,
            $show_email,
            $avatar_ext,
            $user_subm_count
        );

        $news = [];
        
        while ($stmt->fetch()) {
            //$text = nl2br($text);
            //$text = InsertALCode($text);
            //$text = trim($text);
            //$text = RemoveSmillies($text);
            $breaks = array("<br />","<br>","<br/>");
            $text = str_ireplace($breaks, "\r\n", $text);
        
            $news[] = new \AL\Common\Model\NewsSubmission\NewsSubmission(
                $id,
                $headline,
                $text,
                $date,
                $image_id,
                $image,
                $userid,
                $username,
                $email,
                $join_date,
                $karma,
                $show_email,
                $avatar_ext,
                $user_subm_count
            );
        }

        $stmt->close();

        return $news;
    }
  
    /**
    * Get the total count of comments on the website
    *
    * @param  integer $user_id Optional ID of a user to count comments for
    * @return integer Number of comments     */
    public function getSubmissionCount($user_id = null) {
        if (isset($user_id)) {
            $stmt = \AL\Db\execute_query(
                "NewsSubmissionDAO: Get submission count for user_id $user_id",
                $this->mysqli,
                "SELECT COUNT(*) FROM news_submission WHERE user_id = ?",
                "i",
                $user_id
            );
        } else {
            $stmt = \AL\Db\execute_query(
                "NewsSubmissionDAO: Get submission count in database",
                $this->mysqli,
                "SELECT COUNT(*) FROM news_submission",
                null,
                null
            );
        }

        \AL\Db\bind_result(
            "NewsSubmissionDAO: Get submissino count",
            $stmt,
            $count
        );

        $stmt->fetch();
        $stmt->close();

        return $count;
    }
    
    /**
    * Get the comment text for a specific comment
    *
    * @param  integer $comments_id ID of a comment
    * @return text the text of the comment
    */
    public function getNewsText($news_id = null) {
        if (isset($news_id)) {
            $stmt = \AL\Db\execute_query(
                "NewsSubmissionDAO: Get news text for news_id $news_id",
                $this->mysqli,
                "SELECT news_text FROM news_submission WHERE news_submission_id = ?",
                "i",
                $news_id
            );
        }

        \AL\Db\bind_result(
            "NewsSubmissionDAO: Get news text",
            $stmt,
            $news
        );

        $stmt->fetch();
        $stmt->close();

        return $news;
    }
}

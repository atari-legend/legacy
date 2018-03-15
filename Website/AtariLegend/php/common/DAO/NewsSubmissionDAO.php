<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/News/NewsSubmission.php" ;

/**
 * DAO for News Submlissions
 */
 
class NewsSubmissionDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }
    
     /**
     * Return all news submissions, sorted by descending date
     * @return \AL\Common\Model\News\News[] An array of news
     */
    public function getAllSubmissions() {
        $stmt = \AL\Db\execute_query(
            "NewsSubmissionDAO: getAllSubmissions",
            $this->mysqli,
            "SELECT
              news_submission.news_submission_id,
              news_submission.news_headline,
              news_submission.news_text, 
              news_submission.news_date,
              CONCAT(news_image.news_image_id, \".\", news_image.news_image_ext) as news_image,
              news_submission.user_id,
              users.userid,
              users.email,
              users.join_date,
              users.karma,
              users.avatar_ext,
              (SELECT COUNT(*) 
                    FROM news_submission 
                        WHERE news_submission.user_id = users.user_id) AS user_submission_count
              FROM news_submission
              LEFT JOIN news_image ON (news_submission.news_image_id = news_image.news_image_id)
              LEFT JOIN users ON (news_submission.user_id = users.user_id)
              ORDER BY news_date DESC".
               null, null
        );

        \AL\Db\bind_result(
            "NewsSubmissionDAO: getAllSubmissions",
            $stmt,
            $id,
            $headline,
            $text,
            $date,
            $image,
            $userid,
            $username,
            $email,
            $join_date,
            $karma,
            $avatar_ext,
            $user_subm_count
        );

        $news = [];
        while ($stmt->fetch()) {
            $news[] = new \AL\Common\Model\News\NewsSubmission(
                $id,
                $headline,
                $text,
                $date,
                $image,
                $userid,
                $username,
                $email,
                $join_date,
                $karma,
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
}

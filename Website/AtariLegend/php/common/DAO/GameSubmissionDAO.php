<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Game/GameSubmission.php" ;

use AL\Common\Model\GameSubmission;

/**
 * DAO for Game Submissions
 */
class GameSubmissionDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }
    
    private function getGameSubmissionQuery($user_id = null, $last_timestamp = null, $action = null, $done = null) {
            
        $query =  "SELECT
                game.game_id,
                game.game_name,
                game_submitinfo.timestamp,
                game_submitinfo.timestamp as date,
                game_submitinfo.submit_text,
                game_submitinfo.game_submitinfo_id,
                game_submitinfo.game_done,
                users.user_id,
                users.userid,
                users.email,
                users.join_date,
                users.karma,
                users.avatar_ext,
                (SELECT COUNT(*) FROM game_submitinfo 
                    WHERE game_submitinfo.user_id = users.user_id) AS user_subm_count,
                (SELECT COUNT(*) FROM comments 
                    WHERE comments.user_id = users.user_id) AS user_comment_count               
                FROM game_submitinfo
                LEFT JOIN game ON (game_submitinfo.game_id = game.game_id)
                LEFT JOIN users ON (game_submitinfo.user_id = users.user_id)";

        if (isset($done) and $done == "1") {
            $query .= " WHERE game_done = '1'";
        } elseif (isset($done) and $done == "2") {
            $query .= " WHERE game_done <> '1'";
        } else {
            $query .= " WHERE ( game_done <> '1' or game_done = '1')";
        }

        if (isset($user_id) and $user_id <> '') {
            $query .= " AND users.user_id = $user_id";
        }

        if (isset($action) and $action=="autoload") {
            $query .= " AND game_submitinfo.timestamp < $last_timestamp ";
        } elseif (isset($action) and $action=="search") {
            $query .= " AND game_submitinfo.timestamp <= $last_timestamp ";
        }

        $query .= " ORDER BY game_submitinfo.timestamp DESC LIMIT 10";
        return $query;
    }
    
    /**
     * Return the latest game submissions, sorted by descending date
     *
     * @return \AL\Common\Model\Game\GameSubmission[] An array of news
     */
    public function getLatestSubmissions($user_id = null, $last_timestamp = null, $action = null, $done = null) {
        $stmt = \AL\Db\execute_query(
            "GameSubmissionDAO: getLatestSubmissions",
            $this->mysqli,
            $this->getGameSubmissionQuery($user_id, $last_timestamp, $action, $done),
            null, null
        );

        \AL\Db\bind_result(
            "GameSubmissionDAO: getLatestSubmissions",
            $stmt,
            $game_id,
            $game_name,
            $timestamp,
            $date,
            $comment,
            $submission_id,
            $done,
            $userid,
            $username,
            $email,
            $join_date,
            $karma,
            $avatar_ext,
            $user_subm_count,
            $user_comment_count
        );

        $submissions = [];
        while ($stmt->fetch()) {
            $comment = nl2br($comment);
            $comment = InsertALCode($comment);
            $comment = trim($comment);
            $comment = RemoveSmillies($comment);
            
            $submission = new \AL\Common\Model\GameSubmission\GameSubmission(
                $game_id,
                $game_name,
                $timestamp,
                $date,
                $comment,
                $submission_id,
                $done,
                $userid,
                $username,
                $email,
                $join_date,
                $karma,
                $avatar_ext,
                $user_subm_count,
                $user_comment_count,
                null
            );
            
            $submissions[] = $submission;
        }

        $stmt->close();

        return $submissions;
    }
    
     /**
    * Get the total count of submissions
    *
    * @param  integer $user_id Optional ID of a user to count comments for
    * @return integer Number of comments     */
    public function getGameSubmissionCount($user_id = null) {
        if (isset($user_id)) {
            $stmt = \AL\Db\execute_query(
                "GameSubmissionDAO: Get submission count for user_id $user_id",
                $this->mysqli,
                "SELECT COUNT(*) FROM game_submitinfo WHERE user_id = ?",
                "i",
                $user_id
            );
        } else {
            $stmt = \AL\Db\execute_query(
                "GameSubmissionDAO:  Get submissions count in database",
                $this->mysqli,
                "SELECT COUNT(*) FROM game_submitinfo",
                null,
                null
            );
        }

        \AL\Db\bind_result(
            "GameSubmissionDAO: Get submission count",
            $stmt,
            $count
        );

        $stmt->fetch();
        $stmt->close();

        return $count;
    }
    
    
    /**
    * Get the submission screenshots
    *
    * @param  integer $submission_id
    * @return screenshots links    */
    /*public function getGameSubmissionScreenshots($submission_id = null) {
        $stmt = \AL\Db\execute_query(
            "GameSubmissionDAO: Get the screenshots of the submission",
            $this->mysqli,
            "SELECT screenshot_id, imgext FROM screenshot_main
                LEFT JOIN screenshot_game_submitinfo 
                    ON (screenshot_main.screenshot_id = screenshot_game_submitinfo.screenshot_id)
                WHERE screenshot_game_submitinfo.game_submitinfo_id  = ?",
            "i",
            $submission_id
        );
        
        \AL\Db\bind_result(
            "GameSubmissionDAO: Get the screenshots of the submission",
            $stmt,
            $screenshot_id,
            $imgext
        );

        $screenshots = [];
        while ($stmt->fetch()) {
            $new_path = $game_submit_screenshot_path;
            $new_path .= $screenshot_id;
            $new_path .= ".";
            $new_path .= $imgext;
            $screenshots[] = new \AL\Common\Model\GameSubmission\GameSubmission(
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                $new_path
            );
        }
        
        $stmt->close();

        return $screenshots;
    }*/
}

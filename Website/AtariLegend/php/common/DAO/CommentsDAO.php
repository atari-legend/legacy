<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php";
require_once __DIR__."/../Model/Comments/Comments.php";

/**
 * DAO for Comments
 */
class CommentsDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Get the SQL query to get game comments, either all or comments for a
     * specific user
     *
     * @param  integer $user_id Optional ID of the cuser to retrieve comments for
     * @return string SQL query
     */
    public function getGameCommentQuery($user_id = null) {
        $query = "SELECT
                comments.comments_id,
                comments.timestamp,
                users.user_id,
                (SELECT COUNT(*) FROM comments WHERE comments.user_id = users.user_id) AS user_comment_count,
                (SELECT COUNT(*) FROM game_submitinfo WHERE game_submitinfo.user_id = users.user_id) AS user_subm_count,
                users.userid,
                users.email,
                users.join_date,
                users.karma,
                users.avatar_ext,
                game.game_id,
                game.game_name,
                'game_comment' AS comment_type,
                null
            FROM game_user_comments
            LEFT JOIN comments
                ON ( game_user_comments.comment_id = comments.comments_id )
            LEFT JOIN users
                ON ( comments.user_id = users.user_id )
            LEFT JOIN game
                ON ( game_user_comments.game_id = game.game_id )";

        if (isset($user_id)) {
            $query .= " WHERE users.user_id = $user_id";
        }

        return $query;
    }

    /**
     * Get the SQL query to get game review comments, either all or comments for a
     * specific user
     *
     * @param  integer $user_id Optional ID of the cuser to retrieve comments for
     * @return string SQL query
     */
    public function getGameReviewCommentQuery($user_id = null) {
        $query = "SELECT
                comments.comments_id,
                comments.timestamp,
                users.user_id,
                (SELECT COUNT(*) FROM comments WHERE comments.user_id = users.user_id) AS user_comment_count,
                (SELECT COUNT(*) FROM game_submitinfo WHERE game_submitinfo.user_id = users.user_id) AS user_subm_count,
                users.userid,
                users.email,
                users.join_date,
                users.karma,
                users.avatar_ext,
                game.game_id AS game_id,
                game.game_name AS game_name,
                'game_review_comment' AS comment_type,
                review_game.review_id as review_id
            FROM review_user_comments
            LEFT JOIN comments
                ON ( review_user_comments.comment_id = comments.comments_id )
            LEFT JOIN review_game
                ON (review_user_comments.review_id = review_game.review_id )
            LEFT JOIN game
                ON ( review_game.game_id = game.game_id )
            LEFT JOIN users
                ON ( comments.user_id = users.user_id )";

        if (isset($user_id)) {
            $query .= " WHERE users.user_id = $user_id";
        }

        return $query;
    }

    /**
     * Get the SQL query to get interview comments, either all or comments for a
     * specific user
     *
     * @param  integer $user_id Optional ID of the user to retrieve comments for
     * @return string SQL query
     */
    public function getInterviewCommentQuery($user_id = null) {
        $query = "SELECT
                comments.comments_id,
                comments.timestamp,
                users.user_id,
                (SELECT COUNT(*) FROM comments WHERE comments.user_id = users.user_id) AS user_comment_count,
                (SELECT COUNT(*) FROM game_submitinfo WHERE game_submitinfo.user_id = users.user_id) AS user_subm_count,
                users.userid,
                users.email,
                users.join_date,
                users.karma,
                users.avatar_ext,
                interview_main.interview_id AS game_id,
                individuals.ind_name AS game_name,
                'interview_comment' AS comment_type,
                null
            FROM interview_user_comments
            LEFT JOIN comments
                ON ( interview_user_comments.comment_id = comments.comments_id )
            LEFT JOIN interview_main
                ON (interview_user_comments.interview_id = interview_main.interview_id )
            LEFT JOIN individuals
                ON (interview_main.ind_id = individuals.ind_id )
            LEFT JOIN users
                ON ( comments.user_id = users.user_id )";

        if (isset($user_id)) {
            $query .= " WHERE users.user_id = $user_id";
        }

        return $query;
    }

    /**
     * Get the SQL query to create a temporary table to hold the comments
     *
     * @param  integer $mysqli Optional ID of the user to retrieve comments for
     * @return string SQL query
     */
    private function createTemporaryTableCommentsQuery($mysqli = null) {
        $query = "CREATE TEMPORARY TABLE temp (
            comments_id int(11),
            timestamp varchar(32),
            user_id int(11),
            user_comment_count int(11),
            user_subm_count int(11),
            userid varchar(255),
            email varchar(255),
            join_date varchar(32),
            karma int(11),
            avatar_ext varchar(255),
            game_id int(11),
            game_name varchar(255),
            comment_type varchar(255),
            review_id int(11)
        )";

        return $query;
    }

    /**
     * Get the SQL query to create a temporary table to hold the comments
     *
     * @param  string $view Optional string to id what kind of list of comments to be rendered
     * @param  string $action Optional string to id scroll autoload
     * @param  integer $last_timestamp timestamp used for the autoload
     * @return string SQL query
     */
    private function getTemporaryTableCommentsQuery($view = null, $action = null, $last_timestamp = null) {
        if ($view == "comments_game_comments") {
            $where_clause = "WHERE temp.comment_type = 'game_comment'";
        } elseif ($view == "comments_game_review_comments") {
            $where_clause = "WHERE temp.comment_type = 'game_review_comment'";
        } elseif ($view == "comments_interview_comments") {
            $where_clause = "WHERE temp.comment_type = 'interview_comment'";
        } else {
            $where_clause = "";
        }
        if (isset($action) and $action=="autoload") {
            if (strlen($where_clause) >1) {
                $where_clause .= " AND temp.timestamp < $last_timestamp ";
            } elseif (strlen($where_clause) == 0) {
                $where_clause .= " WHERE temp.timestamp < $last_timestamp ";
            }
        }

        $query = "SELECT
            temp.comments_id,
            temp.timestamp,
            temp.user_id,
            temp.user_comment_count,
            temp.user_subm_count,
            temp.userid,
            temp.email,
            temp.join_date,
            temp.karma,
            temp.avatar_ext,
            temp.game_id,
            temp.game_name,
            temp.comment_type,
            comments.comment,
            temp.review_id
        FROM temp
        LEFT JOIN comments
            ON (temp.comments_id = comments.comments_id)
        ". $where_clause ."
        ORDER BY temp.timestamp DESC LIMIT 5";

        return $query;
    }

    /**
     * Get list of comments
     *
     * @param  integer $user_id Optional ID of a user
     * @param  string $view Optional string to id what kind of list of comments to be rendered
     * @param  string $action Optional string to id scroll autoload
     * @param  integer $last_timestamp timestamp used for the autoload
     * @return integer Number of comments
     */
    public function getCommentsBuild($view = null, $user_id = null, $action = null, $last_timestamp = null) {

        //Create temporary table
        $stmt = \AL\Db\execute_query(
            "CommentsDAO: Create temporary table",
            $this->mysqli,
            $this->createTemporaryTableCommentsQuery(),
            null,
            null
        );

        //Populate temporary TABLE
        if (isset($view) and $view == "users_comments") {
            if (isset($user_id)) {
                $sql_build_game = $this->getGameCommentQuery($user_id);
                $sql_build_gamereview = $this->getGameReviewCommentQuery($user_id);
                $sql_build_interview = $this->getInterviewCommentQuery($user_id);
            }
        } else {
            $sql_build_game = $this->getGameCommentQuery();
            $sql_build_gamereview = $this->getGameReviewCommentQuery();
            $sql_build_interview = $this->getInterviewCommentQuery();
        }
        // Insert game comments
        $stmt = \AL\Db\execute_query(
            "CommentsDAO: Insert game comments into temp table",
            $this->mysqli,
            "INSERT INTO temp $sql_build_game",
            null,
            null
        );
        // Insert game review comments
        $stmt = \AL\Db\execute_query(
            "CommentsDAO: Insert game review comments into temp table",
            $this->mysqli,
            "INSERT INTO temp $sql_build_gamereview",
            null,
            null
        );
        // Insert Interview comments
        $stmt = \AL\Db\execute_query(
            "CommentsDAO: Insert interview comments into temp table",
            $this->mysqli,
            "INSERT INTO temp $sql_build_interview",
            null,
            null
        );

        // Query temporary table
        $stmt = \AL\Db\execute_query(
            "CommentsDAO: Query temporary comments table",
            $this->mysqli,
            $this->getTemporaryTableCommentsQuery($view, $action, $last_timestamp),
            null,
            null
        );

        \AL\Db\bind_result(
            "CommentsDAO: Get comments",
            $stmt,
            $comments_id,
            $timestamp,
            $user_id,
            $user_comment_count,
            $user_subm_count,
            $userid,
            $email,
            $join_date,
            $karma,
            $avatar_ext,
            $game_id,
            $game_name,
            $comment_type,
            $comment,
            $review_id
        );

        $comments = [];
        while ($stmt->fetch()) {
            $comments[] = new \AL\Common\Model\Comments\Comments(
                $comments_id,
                $timestamp,
                $user_id,
                $user_comment_count,
                $user_subm_count,
                $userid,
                $email,
                $join_date,
                $karma,
                $avatar_ext,
                $game_id,
                $game_name,
                $comment_type,
                $comment,
                $review_id
            );
        }

        $stmt->close();

        return $comments;
    }

    /**
     * Get the total count of comments on the website
     *
     * @param  integer $user_id Optional ID of a user to count comments for
     * @return integer Number of comments
     */
    public function getCommentCount($user_id = null) {
        if (isset($user_id)) {
            $stmt = \AL\Db\execute_query(
                "CommentsDAO: Get comment count for user_id $user_id",
                $this->mysqli,
                "SELECT COUNT(*) FROM comments WHERE user_id = ?",
                "i",
                $user_id
            );
        } else {
            $stmt = \AL\Db\execute_query(
                "CommentsDAO: Get number of comments in database",
                $this->mysqli,
                "SELECT COUNT(*) FROM comments",
                null,
                null
            );
        }

        \AL\Db\bind_result(
            "CommentsDAO: Get comments count",
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
    public function getCommentText($comments_id = null) {
        if (isset($comments_id)) {
            $stmt = \AL\Db\execute_query(
                "CommentsDAO: Get comment text for comments_id $comments_id",
                $this->mysqli,
                "SELECT comment FROM comments WHERE comments_id = ?",
                "i",
                $comments_id
            );
        }

        \AL\Db\bind_result(
            "CommentsDAO: Get comment text",
            $stmt,
            $comment
        );

        $stmt->fetch();
        $stmt->close();

        return $comment;
    }

    /**
     * Update the comment text for a specific comment
     *
     * @param  integer $comments_id ID of a comment
     * @param  text $comments_text the text of the comment
     * @return text the text of the comment
     */
    public function saveCommentText($comments_id, $comment_text, $comment_type) {
        if (isset($comments_id)) {
            $stmt = \AL\Db\execute_query(
                "CommentsDAO: Save comment text for comments_id $comments_id",
                $this->mysqli,
                "UPDATE comments SET comment = ? WHERE comments_id = ?",
                "si",
                $comment_text,
                $comments_id
            );

            if ($comment_type ==  "game_comment") {
                create_log_entry('Games', $comments_id, 'Comment', $comments_id, 'Update', $_SESSION['user_id']);
            } elseif ($comment_type ==  "game_review_comment") {
                create_log_entry('Reviews', $comments_id, 'Comment', $comments_id, 'Update', $_SESSION['user_id']);
            } elseif ($comment_type ==  "interview_comment") {
                create_log_entry('Interviews', $comments_id, 'Comment', $comments_id, 'Update', $_SESSION['user_id']);
            }
        }

        $stmt->fetch();
        $stmt->close();

        return;
    }
}

<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Review/GameReview.php" ;

/**
 * DAO for Game Review
 */
class GameReviewDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Return the latest game reviews, sorted by descending date
     *
     * @param integer $limit How many reviews to return
     * @return \AL\Common\Model\Review\GaneReview[] An array of reviews
     */
    public function getLatestGameReviews($limit = 20) {
        $stmt = \AL\Db\execute_query(
            "GameReviewDAO: getLatestGameReviews",
            $this->mysqli,
            "SELECT
                review_main.review_id,
                review_main.review_text,
                review_main.review_date,
                users.userid,
                game.game_name
            FROM
                review_game
            LEFT JOIN review_main ON review_main.review_id = review_game.review_id
            LEFT JOIN game ON game.game_id = review_game.game_id
            LEFT JOIN users ON review_main.user_id = users.user_id
            ORDER BY
                review_date
            DESC
            LIMIT ?",
            "i", $limit
        );

        \AL\Db\bind_result(
            "GameReviewDAO: getLatestGameReviews",
            $stmt,
            $id, $text, $date, $user, $game_name
        );

        $reviews = [];
        while ($stmt->fetch()) {
            $reviews[] = new \AL\Common\Model\Review\GameReview(
                $id,
                $text,
                $date,
                $user,
                $game_name
            );
        }

        $stmt->close();

        return $reviews;
    }
}

<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Game/Game.php" ;

/**
 * DAO for Games
 */
class GameDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    public function getGame($game_id) {
        $stmt = \AL\Db\execute_query(
            "GameDAO: getGame: $game_id",
            $this->mysqli,
            "SELECT game_id, game_name FROM game WHERE game_id = ?",
            "i", $game_id
        );

        \AL\Db\bind_result(
            "GameDAO: getGame: $game_id",
            $stmt,
            $game_id, $game_name
        );

        $game = null;
        if ($stmt->fetch()) {
            $game = new \AL\Common\Model\Game\Game(
                $game_id, $game_name
            );
        }

        $stmt->close();

        return $game;
    }

    public function getRandomScreenshot($game_id) {
        $stmt = \AL\Db\execute_query(
            "GameDAO: getRandomScreenshot: $game_id",
            $this->mysqli,
            "SELECT screenshot_game.screenshot_id, imgext FROM screenshot_game
            LEFT JOIN screenshot_main ON (screenshot_game.screenshot_id  = screenshot_main.screenshot_id)
            WHERE screenshot_game.game_id = ?
            ORDER BY RAND() LIMIT 1",
            "i", $game_id
        );

        \AL\Db\bind_result(
            "GameDAO: getRandomScreenshot: $game_id",
            $stmt,
            $screenshot_id, $imgext
        );

        $screenshot = null;
        if ($stmt->fetch()) {
            $screenshot = $screenshot_id.".".$imgext;
        }

        $stmt->close();

        return $GLOBALS['game_screenshot_path']."/".$screenshot;
    }
}

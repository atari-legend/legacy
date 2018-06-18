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
}

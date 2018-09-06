<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Game/Engine.php" ;

/**
 * DAO for game engines
 */
class EngineDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Get all egines
     *
     * @return \AL\Common\Model\Game\GameGenres[] An array of genres
     */
    public function getAllEngines() {
        $stmt = \AL\Db\execute_query(
            "EngineDAO: getAllEngines",
            $this->mysqli,
            "SELECT id, name, description FROM engine ORDER BY name",
            null, null
        );

        \AL\Db\bind_result(
            "EngineDAO: getAllEngines",
            $stmt,
            $id, $name, $description
        );

        $game_engines = [];
        while ($stmt->fetch()) {
            $game_engines[] = new \AL\Common\Model\Game\Engine(
                $id, $name, $description
            );
        }

        $stmt->close();

        return $game_engines;
    }

    /**
     * Get list of game_engines for a game
     *
     * @param integer Game ID
     */
    public function getGameEnginesForGame($game_id) {
        $stmt = \AL\Db\execute_query(
            "EngineDAO: getGameEnginesForGame",
            $this->mysqli,
            "SELECT engine_id, name, description
            FROM game_engine LEFT JOIN engine ON (game_engine.engine_id = engine.id)
            WHERE game_id = ?",
            "i", $game_id
        );

        \AL\Db\bind_result(
            "EngineDAO: getGameEnginesForGame",
            $stmt,
            $engine_id, $name, $description
        );

        $game_engines = [];
        while ($stmt->fetch()) {
            $game_engines[] = new \AL\Common\Model\Game\Engine(
                $engine_id, $name, $description
            );
        }

        $stmt->close();

        return $game_engines;
    }
    
    /**
     * Set the list of game engines for this game
     *
     * @param integer Game ID
     * @param integer[] List of game genre IDs
     */
    public function setGameEngineForGame($game_id, $game_engine_id) {
        $stmt = \AL\Db\execute_query(
            "EngineDAO: setGameEngineForGame",
            $this->mysqli,
            "DELETE FROM game_engine WHERE game_id = ?",
            "i", $game_id
        );

        foreach ($game_engine_id as $id) {
            $stmt = \AL\Db\execute_query(
                "EngineDAO: setGameEngineForGame",
                $this->mysqli,
                "INSERT INTO game_engine (game_id, engine_id) VALUES (?, ?)",
                "ii", $game_id, $id
            );
        }

        $stmt->close();
    }
}

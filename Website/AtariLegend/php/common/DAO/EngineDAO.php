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
     * add a game engine type to the database
     *
     * @param varchar Engine
     */
    public function addGameEngine($engine) {
        $stmt = \AL\Db\execute_query(
            "EngineDAO: addGameEngine",
            $this->mysqli,
            "INSERT INTO engine (`name`) VALUES (?)",
            "s", $engine
        );

        $stmt->close();
    }
    
    /**
     * delete a game engine type
     *
     * @param int Engine_id
     */
    public function deleteGameEngine($engine_id) {
        $stmt = \AL\Db\execute_query(
            "EngineDAO: deleteGameEngine",
            $this->mysqli,
            "DELETE FROM engine WHERE id = ?",
            "i", $engine_id
        );

        $stmt->close();
    }
    
        /**
     * update a game engine type
     *
     * @param int Engine_id
     * @param varchar Engine_name
     */
    public function updateGameEngine($engine_id, $engine_name) {
        $stmt = \AL\Db\execute_query(
            "EngineDAO: updateGameEngine",
            $this->mysqli,
            "UPDATE engine SET name = ? WHERE id = ?",
            "si", $engine_name, $engine_id
        );
        
        $stmt->close();
    }
}

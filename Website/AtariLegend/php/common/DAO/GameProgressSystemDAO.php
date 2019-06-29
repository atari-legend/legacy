<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Game/GamePogressSystem.php" ;

/**
 * DAO for GameProgressSystems
 */
class GameProgressSystemDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Get all progress systems
     *
     * @return \AL\Common\Model\Game\GameProgressSystem[] An array of systems
     */
    public function getAllProgressSystems() {
        $stmt = \AL\Db\execute_query(
            "GameProgressSystemDAO: getAllProgressSystems",
            $this->mysqli,
            "SELECT id, name FROM game_progress_system ORDER BY name",
            null, null
        );

        \AL\Db\bind_result(
            "GameProgressSystemDAO: getAllProgressSystems",
            $stmt,
            $id, $name
        );

        $systems = [];
        while ($stmt->fetch()) {
            $systems[] = new \AL\Common\Model\Game\GameProgressSystem(
                $id, $name
            );
        }

        $stmt->close();

        return $systems;
    }

     /**
     * Get the progress system for a game
     *
     * @param integer Game ID
     *
     * @return progress system of the game
     */
    public function getProgressSystemForGame($game_id) {
        $stmt = \AL\Db\execute_query(
            "GameProgressSystemDAO: getProgressSystemForGame",
            $this->mysqli,
            "SELECT progress_system_id, name
            FROM game_progress_system LEFT JOIN game ON (game.progress_system_id = game_progress_system.id)
            WHERE game_id = ?",
            "i", $game_id
        );

        \AL\Db\bind_result(
            "GameProgressSystemDAO: getProgressSystemForGame",
            $stmt,
            $progress_system_id, $name
        );

        $game_progress_system = null;
        while ($stmt->fetch()) {
            $game_progress_system = new \AL\Common\Model\Game\GameProgressSystem(
                $progress_system_id, $name
            );
        }

        $stmt->close();

        return $game_progress_system;
    }

    /**
     * Set the game progress system for this game
     *
     * @param integer Game ID
     * @param integer pogrress_system ID
     */
    public function setProgressSystemForGame($game_id, $progress_system_id) {
        $stmt = \AL\Db\execute_query(
            "GameProgressSystemDAO: setProgressSystemForGame",
            $this->mysqli,
            "UPDATE game
            SET
                `progress_system_id` = ?
            WHERE game_id = ?",
            "ii", $progress_system_id, $game_id
        );

        $stmt->close();
    }

        /**
     * add a progres system to the database
     *
     * @param varchar name
     */
    public function addProgressSystem($name) {
        $stmt = \AL\Db\execute_query(
            "GameProgressSystemDAO: addProgressSystem",
            $this->mysqli,
            "INSERT INTO game_progress_system (`name`) VALUES (?)",
            "s", $name
        );

        $stmt->close();
    }

    /**
     * delete a progress system
     *
     * @param int progress_system_id
     */
    public function deleteProgressSystem($progress_system_id) {
        $stmt = \AL\Db\execute_query(
            "GameProgressSystemDAO: deleteProgressSystem",
            $this->mysqli,
            "DELETE FROM game_progress_system WHERE id = ?",
            "i", $progress_system_id
        );

        $stmt->close();
    }

        /**
     * update a progress system
     *
     * @param int progress_system_id
     * @param varchar name
     */
    public function updateProgressSystem($progress_system_id, $name) {
        $stmt = \AL\Db\execute_query(
            "GameProgressSystemDAO: updateProgressSystem",
            $this->mysqli,
            "UPDATE game_progress_system SET name = ? WHERE id = ?",
            "si", $name, $progress_system_id
        );

        $stmt->close();
    }
}

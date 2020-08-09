<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Game/Control.php" ;

/**
 * DAO for game controls
 */
class ControlDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Get all controls
     *
     * @return \AL\Common\Model\Game\GameControls[] An array of controls
     */
    public function getAllControls() {
        $stmt = \AL\Db\execute_query(
            "ControlDAO: getAllControls",
            $this->mysqli,
            "SELECT id, name FROM control ORDER BY name",
            null, null
        );

        \AL\Db\bind_result(
            "ControlDAO: getAllControls",
            $stmt,
            $id, $name
        );

        $game_controls = [];
        while ($stmt->fetch()) {
            $game_controls[] = new \AL\Common\Model\Game\Control(
                $id, $name
            );
        }

        $stmt->close();

        return $game_controls;
    }

    /**
     * Get list of game_controls for a game
     *
     * @param integer Game ID
     */
    public function getGameControlsForGame($game_id) {
        $stmt = \AL\Db\execute_query(
            "ControlDAO: getGameControlsForGame",
            $this->mysqli,
            "SELECT control_id, name
            FROM game_control LEFT JOIN control ON (game_control.control_id = control.id)
            WHERE game_id = ?",
            "i", $game_id
        );

        \AL\Db\bind_result(
            "ControlDAO: getGameControlsForGame",
            $stmt,
            $engine_id, $name
        );

        $game_controls = [];
        while ($stmt->fetch()) {
            $game_controls[] = new \AL\Common\Model\Game\Control(
                $engine_id, $name
            );
        }

        $stmt->close();

        return $game_controls;
    }
    
    /**
     * Set the list of game controls for this game
     *
     * @param integer Game ID
     * @param integer[] List of game control IDs
     */
    public function setGameControlForGame($game_id, $game_control_ids) {
        $stmt = \AL\Db\execute_query(
            "ControlDAO: setGameControlForGame",
            $this->mysqli,
            "DELETE FROM game_control WHERE game_id = ?",
            "i", $game_id
        );

        foreach ($game_control_ids as $id) {
            $stmt = \AL\Db\execute_query(
                "ControlDAO: setGameControlForGame",
                $this->mysqli,
                "INSERT INTO game_control (game_id, control_id) VALUES (?, ?)",
                "ii", $game_id, $id
            );
        }

        $stmt->close();
    }
    
     /**
     * add a control to the database
     *
     * @param varchar control
     */
    public function addControl($control) {
        $stmt = \AL\Db\execute_query(
            "ControlDAO: addControl",
            $this->mysqli,
            "INSERT INTO control (`name`) VALUES (?)",
            "s", $control
        );

        $stmt->close();
    }
    
    /**
     * delete a control
     *
     * @param int control_id
     */
    public function deleteControl($control_id) {
        $stmt = \AL\Db\execute_query(
            "ControlDAO: deleteControl",
            $this->mysqli,
            "DELETE FROM control WHERE id = ?",
            "i", $control_id
        );

        $stmt->close();
    }
    
     /**
     * update a control
     *
     * @param int control_id
     * @param varchar control_name
     */
    public function updateControl($control_id, $control_name) {
        $stmt = \AL\Db\execute_query(
            "ControlDAO: updateControl",
            $this->mysqli,
            "UPDATE control SET name = ? WHERE id = ?",
            "si", $control_name, $control_id
        );
        
        $stmt->close();
    }
}

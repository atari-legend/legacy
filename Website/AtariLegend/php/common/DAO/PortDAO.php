<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Game/Port.php" ;

/**
 * DAO for ports
 */
class PortDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Get all port systems
     *
     * @return \AL\Common\Model\Game\Port[] An array of ports
     */
    public function getAllPorts() {
        $stmt = \AL\Db\execute_query(
            "PortDAO: getAllPorts",
            $this->mysqli,
            "SELECT id, port FROM port ORDER BY port",
            null, null
        );

        \AL\Db\bind_result(
            "PortDAO: getAllPorts",
            $stmt,
            $id, $port
        );

        $ports = [];
        while ($stmt->fetch()) {
            $ports[] = new \AL\Common\Model\Game\Port(
                $id, $port
            );
        }

        $stmt->close();

        return $ports;
    }

     /**
     * Get the game port for a game
     *
     * @param integer Game ID
     */
    public function getGamePortForGame($game_id) {
        $stmt = \AL\Db\execute_query(
            "PortDAO: getGamePortForGame",
            $this->mysqli,
            "SELECT port_id, port
            FROM game LEFT JOIN port ON (game.port_id = port.id)
            WHERE game_id = ?",
            "i", $game_id
        );

        \AL\Db\bind_result(
            "PortDAO: getGamePortForGame",
            $stmt,
            $port_id, $port
        );

        $game_port;
        while ($stmt->fetch()) {
            $game_port = new \AL\Common\Model\Game\Port(
                $port_id, $port
            );
        }

        $stmt->close();

        return $game_port;
    }
    
    /**
     * Set the game port for this game
     *
     * @param integer Game ID
     * @param integer Port ID
     */
    public function setPortForGame($game_id, $port_id) {
        $stmt = \AL\Db\execute_query(
            "PortDAO: setPortForGame",
            $this->mysqli,
            "UPDATE game
            SET
                `port_id` = ?
            WHERE game_id = ?",
            "ii", $port_id, $game_id
        );

        $stmt->close();
    }
}

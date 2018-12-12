<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Game/Game.php" ;

/**
 * DAO for Games
 */
class GameDAO {
    private $mysqli;
    
    const MULTIPLAY_TYPE_SIMULTANEOUS = 'Simultaneous';
    const MULTIPLAY_TYPE_TURN_BY_TURN = 'Turn by turn';
    
    const MULTIPLAY_HARDWARE_CARTRIDGE = 'Cartridge';
    const MULTIPLAY_HARDWARE_MIDI_LINK = 'Midi-Link';

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }
    
    /**
     * Get all the multiplayer types
     * @return String[] A list of multiplayer types
     */
    public function getMultiplayerTypes() {
        return array(
            GameDAO::MULTIPLAY_TYPE_SIMULTANEOUS,
            GameDAO::MULTIPLAY_TYPE_TURN_BY_TURN
        );
    }
    
    /**
     * Get all the multiplayer hardware
     * @return String[] A list of multiplayer hardware
     */
    public function getMultiplayerHardware() {
        return array(
            GameDAO::MULTIPLAY_HARDWARE_CARTRIDGE,
            GameDAO::MULTIPLAY_HARDWARE_MIDI_LINK
        );
    }

    /**
     * Get a single game
     * @param number $game_id ID of the game to retrieve
     * @return \AL\Common\Model\Game\Game The game
     */
    public function getGame($game_id) {
        $stmt = \AL\Db\execute_query(
            "GameDAO: getGame",
            $this->mysqli,
            "SELECT game_id, game_name, game_series_id, nr_players_on_same_machine,
                nr_player_multiple_machines, multiplayer_type, multiplayer_hardware FROM game WHERE game_id = ?",
            "i", $game_id
        );

        \AL\Db\bind_result(
            "GameDAO: getGame",
            $stmt,
            $game_id, $game_name, $game_series_id, $nr_players_on_same_machine, $nr_player_multiple_machines, 
            $multiplayer_type, $multiplayer_hardware
        );

        $game = null;
        if ($stmt->fetch()) {
            $game = new \AL\Common\Model\Game\Game(
                $game_id, $game_name, $game_series_id, $nr_players_on_same_machine, $nr_player_multiple_machines,
                $multiplayer_type, $multiplayer_hardware
            );
        }

        $stmt->close();

        return $game;
    }
    
    /**
     * Update the multiplayer attributes of a game
     *
     * @param integer $release_id ID of the release to update
     */
    public function updateGameMultiplayer($game_id, $players_same, $players_other, $multiplayer_type, $multiplayer_hardware) {
        $stmt = \AL\Db\execute_query(
            "GameDAO: updateGameMultiplayer",
            $this->mysqli,
            "UPDATE game
            SET
                `nr_players_on_same_machine` = ?,
                `nr_player_multiple_machines` = ?,
                `multiplayer_type` = ?,
                `multiplayer_hardware` = ?               
            WHERE game_id = ?",
            "iissi", $players_same, $players_other, $multiplayer_type, $multiplayer_hardware, $game_id
        );

        $stmt->close();
    }
 
    /**
     * Get a random screenshot for a game
     * @param number $game_id ID of the game to get a screenshot for
     * @return String The relative URL of a screenshot
     */
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
            if ($screenshot_id == null) {
                $screenshot = null;
            } else {
                $screenshot = $screenshot_id.".".$imgext;
            }
        }

        $stmt->close();

        if ($screenshot == null) {
            return $screenshot;
        } else {
            return $GLOBALS['game_screenshot_path']."/".$screenshot;
        }
    }

    /**
     * Remove an individual from a game
     * @param number $game_id ID of the game to remove the individual from
     * @param number $individual_id ID of the individual to remove
     * @param number $individual_role_id ID of the type of individual to remove
     */
    public function removeIndividual($game_id, $individual_id, $individual_role_id) {
        if ($individual_role_id != null && $individual_role_id != '') {
            $stmt = \AL\Db\execute_query(
                "GameDAO: removeIndividual",
                $this->mysqli,
                "DELETE FROM game_individual
                WHERE game_id = ? AND individual_id = ? AND individual_role_id = ?",
                "iii", $game_id, $individual_id, $individual_role_id
            );
        } else {
            $stmt = \AL\Db\execute_query(
                "GameDAO: removeIndividual",
                $this->mysqli,
                "DELETE FROM game_individual
                WHERE game_id = ? AND individual_id = ?",
                "ii", $game_id, $individual_id
            );
        }

        $stmt->close();
    }

    /**
     * Add a new individual to a game
     * @param number $game_id ID of the game to add the individual to
     * @param number $individual_id ID of the individual to add
     * @param number individual_role_id ID of the type of individual to add
     */
    public function addIndividual($game_id, $individual_id, $individual_role_id) {
        if ($individual_role_id == null && $individual_role_id == '') {
            $stmt = \AL\Db\execute_query(
                "GameDAO: addIndividual",
                $this->mysqli,
                "INSERT INTO game_individual (game_id, individual_id, individual_role_id) VALUES (?, ?, null)",
                "ii", $game_id, $individual_id
            );
        } else {
            $stmt = \AL\Db\execute_query(
                "GameDAO: addIndividual",
                $this->mysqli,
                "INSERT INTO game_individual (game_id, individual_id, individual_role_id) VALUES (?, ?, ?)",
                "iii", $game_id, $individual_id, $individual_role_id
            );
        }

        $stmt->close();
    }

    /**
     * Update the individual role on a game
     * @param number $game_id ID of the game to update the individual for
     * @param number $individual_id ID of the individual to update the type for
     * @param number individual_role_id Previous individual role ID
     * @param number $new_individual_role_id New individual role ID
     */
    public function updateIndividual($game_id, $individual_id, $individual_role_id, $new_individual_role_id) {
        if ($new_individual_role_id == null && $new_individual_role_id == '') {
            $query = "UPDATE game_individual SET individual_role_id = null
                WHERE game_id = ? AND individual_id = ? ";
            $bind_string = "ii";
            $bind_params = array($game_id, $individual_id);
        } else {
            $query = "UPDATE game_individual SET individual_role_id = ?
                WHERE game_id = ? AND individual_id = ? ";
            $bind_string = "iii";
            $bind_params = array($new_individual_role_id, $game_id, $individual_id);
        }

        if ($individual_role_id != null && $individual_role_id != '') {
            $query .= "AND individual_role_id = ?";
            $bind_string .= "i";
            $bind_params[] = $individual_role_id;
        } else {
            $query .= "AND individual_role_id IS NULL";
        }

        $stmt = \AL\Db\execute_query(
            "GameDAO: updateIndividual",
            $this->mysqli,
            $query,
            $bind_string, ...$bind_params
        );

        $stmt->close();
    }

    /**
     * Remove a developer from a game
     * @param number $game_id ID of the game to remove the developer from
     * @param number $pub_dev_id ID of the developer to remove
     * @param number $developer_role_id ID of the developer role to remove
     */
    public function removeDeveloper($game_id, $pub_dev_id, $developer_role_id) {
        $query = "DELETE FROM game_developer WHERE game_id = ? AND dev_pub_id = ?";
        $bind_string = "ii";
        $bind_params = array($game_id, $pub_dev_id);

        if ($developer_role_id != null && $developer_role_id != '') {
            $query .= " AND developer_role_id = ?";
            $bind_string .= "i";
            $bind_params[] = $developer_role_id;
        } else {
            $query .= " AND developer_role_id IS NULL";
        }


        $stmt = \AL\Db\execute_query(
            "GameDAO: removeDeveloper",
            $this->mysqli,
            $query,
            $bind_string, ...$bind_params
        );

        $stmt->close();
    }

    /**
     * Add a developer to a game
     * @param number $game_id ID of the game to add the developer to
     * @param number $pub_dev_id ID of the developer to add
     * @param number $developer_role_id ID of the developer role to add
     */
    public function addDeveloper($game_id, $pub_dev_id, $developer_role_id) {
        $stmt = \AL\Db\execute_query(
            "GameDAO: addDeveloper",
            $this->mysqli,
            "INSERT INTO game_developer (game_id, dev_pub_id, developer_role_id)
            VALUES (?, ?, ?)",
            "iii", $game_id, $pub_dev_id,
            $developer_role_id == '' ? null : $developer_role_id
        );

        $stmt->close();
    }

    /**
     * Update the developer on a game
     * @param number $game_id ID of the game to update the developer for
     * @param number $pub_dev_id ID of the developer to update
     * @param number $developer_role_id ID of the developer role to update
     * @param number $new_developer_role_id New ID of the developer role to update
     */
    public function updateDeveloper(
        $game_id,
        $pub_dev_id,
        $developer_role_id,
        $new_developer_role_id
    ) {

        $query = "UPDATE game_developer SET developer_role_id = ?
            WHERE game_id = ? AND dev_pub_id = ?";
        $bind_string = "iii";
        $bind_params = array(
            $new_developer_role_id != '' ? $new_developer_role_id : null,
            $game_id,
            $pub_dev_id);

        if ($developer_role_id != null && $developer_role_id != '') {
            $query .= " AND developer_role_id = ?";
            $bind_string .= "i";
            $bind_params[] = $developer_role_id;
        } else {
            $query .= " AND developer_role_id IS NULL";
        }

        $stmt = \AL\Db\execute_query(
            "GameDAO: updateDeveloper",
            $this->mysqli,
            $query,
            $bind_string, ...$bind_params
        );

        $stmt->close();
    }

    /**
     * Remove a publisher from a game
     * @param number $game_id ID of the game to remove the publisher from
     * @param number $pub_dev_id ID of the publisher to remove
     * @param number $continent_id ID of the continent to remove
     * @param number $game_extra_info_id ID of the extra info to remove
     */
    public function removePublisher($game_id, $pub_dev_id, $continent_id, $game_extra_info_id) {
        $query = "DELETE FROM game_publisher WHERE game_id = ? AND pub_dev_id = ?";
        $bind_string = "ii";
        $bind_params = array($game_id, $pub_dev_id);

        if ($continent_id != null && $continent_id != '') {
            $query .= " AND continent_id = ?";
            $bind_string .= "i";
            $bind_params[] = $continent_id;
        } else {
            $query .= " AND continent_id IS NULL";
        }

        if ($game_extra_info_id != null && $game_extra_info_id != '') {
            $query .= " AND game_extra_info_id = ?";
            $bind_string .= "i";
            $bind_params[] = $game_extra_info_id;
        } else {
            $query .= " AND game_extra_info_id IS NULL";
        }


        $stmt = \AL\Db\execute_query(
            "GameDAO: removePublisher",
            $this->mysqli,
            $query,
            $bind_string, ...$bind_params
        );

        $stmt->close();
    }

    /**
     * Add a publisher to a game
     * @param number $game_id ID of the game to add the publisher to
     * @param number $pub_dev_id ID of the publisher to add
     * @param number $continent_id ID of the continent to add
     * @param number $game_extra_info_id ID of the extra info to add
     */
    public function addPublisher($game_id, $pub_dev_id, $continent_id, $game_extra_info_id) {
        $stmt = \AL\Db\execute_query(
            "GameDAO: addPublisher",
            $this->mysqli,
            "INSERT INTO game_publisher (game_id, pub_dev_id, continent_id, game_extra_info_id)
            VALUES (?, ?, ?, ?)",
            "iiii", $game_id, $pub_dev_id,
            $continent_id == '' ? null : $continent_id,
            $game_extra_info_id == '' ? null : $game_extra_info_id
        );

        $stmt->close();
    }

    /**
     * Update the publisher on a game
     * @param number $game_id ID of the game to update the publisher for
     * @param number $pub_dev_id ID of the publisher to update
     * @param number $continent_id ID of the continent to update
     * @param number $game_extra_info_id ID of the extra info to update
     * @param number $new_continent_id New ID of the continent to update
     * @param number $new_game_extra_info_id New ID of the extra info to update
     */
    public function updatePublisher(
        $game_id,
        $pub_dev_id,
        $continent_id,
        $game_extra_info_id,
        $new_continent_id,
        $new_game_extra_info_id
    ) {

        $query = "UPDATE game_publisher SET continent_id = ?, game_extra_info_id = ?
            WHERE game_id = ? AND pub_dev_id = ?";
        $bind_string = "iiii";
        $bind_params = array(
            $new_continent_id != '' ? $new_continent_id : null,
            $new_game_extra_info_id != '' ? $new_game_extra_info_id : null,
            $game_id,
            $pub_dev_id);

        if ($continent_id != null && $continent_id != '') {
            $query .= " AND continent_id = ?";
            $bind_string .= "i";
            $bind_params[] = $continent_id;
        } else {
            $query .= " AND continent_id IS NULL";
        }

        if ($game_extra_info_id != null && $game_extra_info_id != '') {
            $query .= " AND game_extra_info_id = ?";
            $bind_string .= "i";
            $bind_params[] = $game_extra_info_id;
        } else {
            $query .= " AND game_extra_info_id IS NULL";
        }

        $stmt = \AL\Db\execute_query(
            "GameDAO: updatePublisher",
            $this->mysqli,
            $query,
            $bind_string, ...$bind_params
        );

        $stmt->close();
    }
}

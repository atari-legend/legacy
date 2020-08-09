<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Game/SoundHardware.php" ;

/**
 * DAO for Sound Hardware
 */
class SoundHardwareDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Get all Sound Hardware Types

     * @return \AL\Common\Model\Game\SoundHardware[] An array of SoundHardware types
     */
    public function getAllSoundHardware() {
        $stmt = \AL\Db\execute_query(
            "SoundHardwareDAO: getAllSoundHardware",
            $this->mysqli,
            "SELECT id, name FROM sound_hardware ORDER BY name",
            null, null
        );

        \AL\Db\bind_result(
            "SoundHardwareDAO: getAllSoundHardware",
            $stmt,
            $id, $name
        );

        $sound_hardware_types = [];
        while ($stmt->fetch()) {
            $sound_hardware_types[] = new \AL\Common\Model\Game\SoundHardware(
                $id, $name, null
            );
        }

        $stmt->close();

        return $sound_hardware_types;
    }

    /**
     * Get list of sound_hardware IDs for a game
     *
     * @param integer game ID
     */
    public function getSoundHardwareForGame($game_id) {
        $stmt = \AL\Db\execute_query(
            "SoundHardwareDAO: getSoundHardwareForGame",
            $this->mysqli,
            "SELECT sound_hardware_id, name, description
            FROM game_sound_hardware LEFT JOIN 
            sound_hardware ON (game_sound_hardware.sound_hardware_id = sound_hardware.id)
            WHERE game_id = ?",
            "i", $game_id
        );

        \AL\Db\bind_result(
            "SoundHardwareDAO: getSoundHardwareForGame",
            $stmt,
            $sound_hardware_id, $name, $description
        );

        $sound_hardware_types = [];
        while ($stmt->fetch()) {
            $sound_hardware_types[] = new \AL\Common\Model\Game\SoundHardware(
                $sound_hardware_id, $name, $description
            );
        }

        $stmt->close();

        return $sound_hardware_types;
    }
    
     /**
     * Add sound hardware to game
     *
     * @param integer Game ID
     * @param integer hardware ID
     * $param text description
     */
    public function addSoundHardwareToGame($game_id, $hardware_id) {
       
        $stmt = \AL\Db\execute_query(
            "SoundHardwareDAO: addSoundHardwareToGame",
            $this->mysqli,
            "INSERT INTO game_sound_hardware (game_id, sound_hardware_id) VALUES (?, ?)",
            "ii", $game_id, $hardware_id
        );

        $stmt->close();
    }
    
     /**
     * Delete sound hardware from game
     *
     * @param integer Game ID
     * @param integer hardware ID
     */
    public function deleteSoundHardwareFromGame($game_id, $hardware_id) {
        $stmt = \AL\Db\execute_query(
            "SoundHardwareDAO: deleteSoundHardwareFromGame",
            $this->mysqli,
            "DELETE FROM game_sound_hardware
            WHERE game_id = ? AND sound_hardware_id = ?",
            "ii", $game_id, $hardware_id
        );

        $stmt->close();
    }
     
     /**
     * add a sound hardware type to the database
     *
     * @param varchar sound hardware type
     */
    public function addSoundHardware($sound_hardware) {
        $stmt = \AL\Db\execute_query(
            "SoundHardwareDAO: addSoundHardware",
            $this->mysqli,
            "INSERT INTO sound_hardware (`name`) VALUES (?)",
            "s", $sound_hardware
        );

        $stmt->close();
    }
    
    /**
     * delete a sound hardware
     *
     * @param int $hardware_id
     */
    public function deleteSoundHardware($hardware_id) {
        $stmt = \AL\Db\execute_query(
            "SoundHardwareDAO: deleteSoundHardware",
            $this->mysqli,
            "DELETE FROM sound_hardware WHERE id = ?",
            "i", $hardware_id
        );

        $stmt->close();
    }
    
        /**
     * update a sound hardware
     *
     * @param int sound_hardware_id
     * @param varchar sound_hardware
     */
    public function updateSoundHardware($sound_hardware_id, $sound_hardware) {
        $stmt = \AL\Db\execute_query(
            "SoundHardwareDAO: updateSoundHardware",
            $this->mysqli,
            "UPDATE sound_hardware SET name = ? WHERE id = ?",
            "si", $sound_hardware, $sound_hardware_id
        );
        
        $stmt->close();
    }
}

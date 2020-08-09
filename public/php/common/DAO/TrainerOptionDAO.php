<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Game/TrainerOption.php" ;

/**
 * DAO for Trainer Option
 */
class TrainerOptionDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Get all Trainer Options
     *
     * @return \AL\Common\Model\Game\TrainerOptions[] An array of options
     */
    public function getAllTrainerOptions() {
        $stmt = \AL\Db\execute_query(
            "TrainerOptionDAO: getAllTrainerOptions",
            $this->mysqli,
            "SELECT id, name FROM trainer_option ORDER BY name",
            null, null
        );

        \AL\Db\bind_result(
            "TrainerOptionDAO: getAllTrainerOptions",
            $stmt,
            $id, $name
        );

        $trainer_options = [];
        while ($stmt->fetch()) {
            $trainer_options[] = new \AL\Common\Model\Game\TrainerOption(
                $id, $name
            );
        }

        $stmt->close();

        return $trainer_options;
    }

    /**
     * Get list of trainer_option IDs for a game release
     *
     * @param integer release ID
     */
    public function getTrainerOptionsForRelease($release_id) {
        $stmt = \AL\Db\execute_query(
            "TrainerOptionDAO: getTrainerOptionsForRelease",
            $this->mysqli,
            "SELECT trainer_option_id, name
            FROM game_release_trainer_option LEFT JOIN 
            trainer_option ON (game_release_trainer_option.trainer_option_id = trainer_option.id)
            WHERE release_id = ?",
            "i", $release_id
        );

        \AL\Db\bind_result(
            "TrainerOptionDAO: getTrainerOptionsForRelease",
            $stmt,
            $trainer_option_id, $name
        );

        $trainer_options = [];
        while ($stmt->fetch()) {
            $trainer_options[] = new \AL\Common\Model\Game\TrainerOption(
                $trainer_option_id, $name
            );
        }

        $stmt->close();

        return $trainer_options;
    }
    
    /**
     * Set the list of trainer options for this release
     *
     * @param integer release ID
     * @param integer[] List of trainer option IDs
     */
    public function setTrainerOptionsForRelease($release_id, $trainer_option_id) {
        $stmt = \AL\Db\execute_query(
            "TrainerOptionDAO: setTrainerOptionsForRelease",
            $this->mysqli,
            "DELETE FROM game_release_trainer_option WHERE release_id = ?",
            "i", $release_id
        );

        foreach ($trainer_option_id as $id) {
            $stmt = \AL\Db\execute_query(
                "TrainerOptionDAO: setTrainerOptionsForRelease",
                $this->mysqli,
                "INSERT INTO game_release_trainer_option (release_id, trainer_option_id) VALUES (?, ?)",
                "ii", $release_id, $id
            );
        }

        $stmt->close();
    }
     
     /**
     * add a trainer_option to the database
     *
     * @param varchar trainer_option
     */
    public function addTrainerOption($trainer_option) {
        $stmt = \AL\Db\execute_query(
            "TrainerOptionDAO: addTrainerOption",
            $this->mysqli,
            "INSERT INTO trainer_option (`name`) VALUES (?)",
            "s", $trainer_option
        );

        $stmt->close();
    }
    
    /**
     * delete a $trainer_option
     *
     * @param int $trainer_option_id
     */
    public function deleteTrainerOption($trainer_option_id) {
        $stmt = \AL\Db\execute_query(
            "TrainerOptionDAO: deleteTrainerOption",
            $this->mysqli,
            "DELETE FROM trainer_option WHERE id = ?",
            "i", $trainer_option_id
        );

        $stmt->close();
    }
    
        /**
     * update a trainer_option
     *
     * @param int trainer_option_id
     * @param varchar trainer_option_name
     */
    public function updateTrainerOption($trainer_option_id, $trainer_option_name) {
        $stmt = \AL\Db\execute_query(
            "TrainerOptionDAO: updateTrainerOption",
            $this->mysqli,
            "UPDATE trainer_option SET name = ? WHERE id = ?",
            "si", $trainer_option_name, $trainer_option_id
        );
        
        $stmt->close();
    }
}

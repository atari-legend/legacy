<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Game/Emulator.php" ;

/**
 * DAO for Emulators
 */
class EmulatorDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Get all emulators
     *
     * @return \AL\Common\Model\Game\Emulator[] An array of emulators
     */
    public function getAllEmulators() {
        $stmt = \AL\Db\execute_query(
            "EmulatorDAO: getAllEmulator",
            $this->mysqli,
            "SELECT id, name FROM emulator ORDER by name",
            null, null
        );

        \AL\Db\bind_result(
            "EmulatorDAO: getAllEmulator",
            $stmt,
            $id, $name
        );

        $emulators = [];
        while ($stmt->fetch()) {
            $emulators[] = new \AL\Common\Model\Game\Emulator(
                $id, $name
            );
        }

        $stmt->close();

        return $emulators;
    }

    /**
     * Get a map containing all emulators, indexed by ID
     *
     * @return \AL\Common\Model\Game\Emulator[] A map of emulators
     */
    public function getAllEmulatorsAsMap() {
        $emulators = $this->getAllEmulators();
        $emulatorsMap = array();
        foreach ($emulators as $emulator) {
            $emulatorsMap[$emulator->getId()] = $emulator;
        }

        return $emulatorsMap;
    }

    /**
     * Get all emulator IDs incompatible with a release
     *
     * @param integer Release ID
     * @return integer[] List of incompatible emulator IDs
     */
    public function getIncompatibleEmulatorIdsForRelease($release_id) {
        $stmt = \AL\Db\execute_query(
            "EmulatorDAO: getIncompatibleEmulatorIdsForRelease",
            $this->mysqli,
            "SELECT emulator_id FROM game_release_emulator_incompatibility WHERE release_id = ?",
            "i", $release_id
        );

        \AL\Db\bind_result(
            "EmulatorDAO: getIncompatibleEmulatorIdsForRelease",
            $stmt,
            $emulator_id
        );

        $emulators = [];
        while ($stmt->fetch()) {
            $emulators[] = $emulator_id;
        }

        $stmt->close();

        return $emulators;
    }

    /**
     * Get all emulator incompatible with a release
     *
     * @param integer Release ID
     * @return integer[] List of incompatible emulators
     */
    public function getIncompatibleEmulatorForRelease($release_id) {
        $stmt = \AL\Db\execute_query(
            "EmulatorDAO: getIncompatibleEmulatorForRelease",
            $this->mysqli,
            "SELECT emulator.id, emulator.name
            FROM game_release_emulator_incompatibility
            JOIN emulator on game_release_emulator_incompatibility.emulator_id = emulator.id
            WHERE release_id = ?",
            "i", $release_id
        );

        \AL\Db\bind_result(
            "EmulatorDAO: getIncompatibleEmulatorForRelease",
            $stmt,
            $id, $name
        );

        $emulators = [];
        while ($stmt->fetch()) {
            $emulators[] = new \AL\Common\Model\Game\Emulator(
                $id, $name
            );
        }

        $stmt->close();

        return $emulators;
    }


     /**
     * Get all emulator IDs incompatible with a release
     *
     * @param integer Release ID
     * @return integer[] List of incompatible emulator IDs
     */
    public function getIncompatibleEmulatorsWithNameForRelease($release_id) {
        $stmt = \AL\Db\execute_query(
            "EmulatorDAO: getIncompatibleEmulatorIdsForRelease",
            $this->mysqli,
            "SELECT game_release_emulator_incompatibility.emulator_id,
                    emulator.name FROM game_release_emulator_incompatibility
                    LEFT JOIN emulator ON (game_release_emulator_incompatibility.emulator_id = emulator.id)
                    WHERE release_id = ?",
            "i", $release_id
        );

        \AL\Db\bind_result(
            "EmulatorDAO: getIncompatibleEmulatorIdsForRelease",
            $stmt,
            $emulator_id, $emulator_name
        );

        $emulators = [];
        while ($stmt->fetch()) {
            $emulators[] = new \AL\Common\Model\Game\Emulator($emulator_id, $emulator_name);
        }

        $stmt->close();

        return $emulators;
    }

    /**
     * Set the list of emulators a release is incompatible with
     *
     * @param integer Release ID
     * @param integer[] List of emulator IDs
     */
    public function setIncompatibleEmulatorsForRelease($release_id, $emulators) {
        $stmt = \AL\Db\execute_query(
            "EmulatorDAO: setIncompatibleEmulatorsForRelease",
            $this->mysqli,
            "DELETE FROM game_release_emulator_incompatibility WHERE release_id = ?",
            "i", $release_id
        );

        foreach ($emulators as $id) {
            $stmt = \AL\Db\execute_query(
                "EmulatorDAO: setIncompatibleEmulatorsForRelease",
                $this->mysqli,
                "INSERT INTO game_release_emulator_incompatibility (release_id, emulator_id) VALUES (?, ?)",
                "ii", $release_id, $id
            );
        }

        $stmt->close();
    }

        /**
     * add a emulator to the database
     *
     * @param varchar emulator
     */
    public function addEmulator($emulator) {
        $stmt = \AL\Db\execute_query(
            "EmulatorDAO: addEmulator",
            $this->mysqli,
            "INSERT INTO emulator (`name`) VALUES (?)",
            "s", $emulator
        );

        $stmt->close();
    }

    /**
     * delete a emulator
     *
     * @param int emulator_id
     */
    public function deleteEmulator($emulator_id) {
        $stmt = \AL\Db\execute_query(
            "EmulatorDAO: deleteEmulator",
            $this->mysqli,
            "DELETE FROM emulator WHERE id = ?",
            "i", $emulator_id
        );

        $stmt->close();
    }

        /**
     * update a emulator
     *
     * @param int emulator_id
     * @param varchar emulator_name
     */
    public function updateEmulator($emulator_id, $emulator_name) {
        $stmt = \AL\Db\execute_query(
            "EmulatorDAO: updateEmulator",
            $this->mysqli,
            "UPDATE emulator SET name = ? WHERE id = ?",
            "si", $emulator_name, $emulator_id
        );

        $stmt->close();
    }
}

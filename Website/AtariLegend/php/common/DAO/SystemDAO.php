<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Game/System.php" ;
require_once __DIR__."/../Model/Game/enhancement.php" ;

/**
 * DAO for systems
 */
class SystemDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Get all systems
     *
     * @return \AL\Common\Model\Game\System[] An array of systems
     */
    public function getAllSystems() {
        $stmt = \AL\Db\execute_query(
            "SystemDAO: getAllSystems",
            $this->mysqli,
            "SELECT id, name FROM system ORDER by name",
            null, null
        );

        \AL\Db\bind_result(
            "SystemDAO: getAllSystems",
            $stmt,
            $id, $name
        );

        $systems = [];
        while ($stmt->fetch()) {
            $systems[] = new \AL\Common\Model\Game\System(
                $id, $name, null
            );
        }

        $stmt->close();

        return $systems;
    }

    /**
     * Get a map containing all systems, indexed by ID
     *
     * @return \AL\Common\Model\Game\System[] A map of systems
     */
    public function getAllSystemsAsMap() {
        $systems = $this->getAllSystems();
        $systemsMap = array();
        foreach ($systems as $system) {
            $systemsMap[$system->getId()] = $system;
        }

        return $systemsMap;
    }

    /**
     * Get all system IDs incompatible with a release
     *
     * @param integer Release ID
     * @return integer[] List of incompatible system IDs
     */
    public function getIncompatibleSystemsForRelease($release_id) {
        $stmt = \AL\Db\execute_query(
            "SystemDAO: getIncompatibleSystemsForRelease",
            $this->mysqli,
            "SELECT system_id FROM game_release_system_incompatible WHERE game_release_id = ?",
            "i", $release_id
        );

        \AL\Db\bind_result(
            "SystemDAO: getIncompatibleSystemsForRelease",
            $stmt,
            $system_id
        );

        $systems = [];
        while ($stmt->fetch()) {
            $systems[] = $system_id;
        }

        $stmt->close();

        return $systems;
    }

    /**
     * Set the list of systems a release is incompatible with
     *
     * @param integer Release ID
     * @param integer[] List of system IDs
     */
    public function setIncompatibleSystemsForRelease($release_id, $systems) {
        $stmt = \AL\Db\execute_query(
            "SystemDAO: setIncompatibleSystemsForRelease",
            $this->mysqli,
            "DELETE FROM game_release_system_incompatible WHERE game_release_id = ?",
            "i", $release_id
        );

        foreach ($systems as $id) {
            $stmt = \AL\Db\execute_query(
                "SystemDAO: setIncompatibleSystemsForRelease",
                $this->mysqli,
                "INSERT INTO game_release_system_incompatible (game_release_id, system_id) VALUES (?, ?)",
                "ii", $release_id, $id
            );
        }

        $stmt->close();
    }

    /**
     * Get all system IDs enhanced for a release
     *
     * @param integer Release ID
     * @return integer[] List of enhanced system IDs
     */
    public function getEnhancedSystemsForRelease($release_id) {
        $stmt = \AL\Db\execute_query(
            "SystemDAO: getEnhancedSystemsForRelease",
            $this->mysqli,
            "SELECT system_id, system.name, enhancement_id, enhancement.name 
            FROM game_release_system_enhanced 
            LEFT JOIN system ON (game_release_system_enhanced.system_id = system.id)
            LEFT JOIN enhancement ON (game_release_system_enhanced.enhancement_id = enhancement.id)
            WHERE game_release_id = ?",
            "i", $release_id
        );

        \AL\Db\bind_result(
            "SystemDAO: getEnhancedSystemsForRelease",
            $stmt,
            $system_id, $system, $enhancement_id, $enhancement
        );

        $systems = [];
        while ($stmt->fetch()) {
            $systems[] = new \AL\Common\Model\Game\System(
                $system_id, $system,
                ($enhancement_id != null)
                    ? new \AL\Common\Model\Game\Enhancement($enhancement_id, $enhancement)
                    : null
            );
        }

        $stmt->close();

        return $systems;
    }

    /**
     * Set the list of systems a release is enhanced for
     *
     * @param integer Release ID
     * @param integer[] List of system IDs
     */
    public function setEnhancedSystemsForRelease($release_id, $systems) {
        $stmt = \AL\Db\execute_query(
            "SystemDAO: setEnhancedSystemsForRelease",
            $this->mysqli,
            "DELETE FROM game_release_system_enhanced WHERE game_release_id = ?",
            "i", $release_id
        );

        foreach ($systems as $id) {
            $stmt = \AL\Db\execute_query(
                "SystemDAO: setEnhancedSystemsForRelease",
                $this->mysqli,
                "INSERT INTO game_release_system_enhanced (game_release_id, system_id) VALUES (?, ?)",
                "ii", $release_id, $id
            );
        }

        $stmt->close();
    }
    
        /**
     * Set the list of system enhancements for a release
     *
     * @param integer Release ID
     * @param integer[] system ID
     * @param integer[] enhancement IDs
     */
    public function addEnhancedSystemForRelease($release_id, $system_id, $enhancement_id) {

        $stmt = \AL\Db\execute_query(
            "SystemDAO: addEnhancedSystemForRelease",
            $this->mysqli,
            "INSERT INTO game_release_system_enhanced (game_release_id, system_id, enhancement_id) VALUES (?, ?, ?)",
            "iii", $release_id, $system_id, $enhancement_id
        );

        $stmt->close();
    }
    
    
        /**
     * update system enhancements for a release
     *
     * @param integer Release ID
     * @param integer[] system ID
     * @param integer[] enhancement IDs
     */
    public function updateEnhancedSystemForRelease($release_id, $system_id, $enhancement_id) {

        $stmt = \AL\Db\execute_query(
            "SystemDAO: updateEnhancedSystemForRelease",
            $this->mysqli,
            "UPDATE game_release_system_enhanced
            SET
                `enhancement_id` = ?
            WHERE game_release_id = ? AND system_id = ?",
            "iii", $enhancement_id, $release_id, $system_id
        );

        $stmt->close();
    }

        /**
     * delete system enhancements for a release
     *
     * @param integer Release ID
     * @param integer[] system ID
     */
    public function deleteEnhancedSystemForRelease($release_id, $system_id) {

        $stmt = \AL\Db\execute_query(
            "SystemDAO: deleteEnhancedSystemForRelease",
            $this->mysqli,
            "DELETE FROM game_release_system_enhanced
            WHERE game_release_id = ? AND system_id = ?",
            "ii", $release_id, $system_id
        );
    }
    
        /**
     * add a system to the database
     *
     * @param varchar system
     */
    public function addSystem($system) {
        $stmt = \AL\Db\execute_query(
            "SystemDAO: addSystem",
            $this->mysqli,
            "INSERT INTO system (`name`) VALUES (?)",
            "s", $system
        );

        $stmt->close();
    }
    
    /**
     * delete a system
     *
     * @param int system_id
     */
    public function deleteSystem($system_id) {
        $stmt = \AL\Db\execute_query(
            "SystemDAO: deleteSystem",
            $this->mysqli,
            "DELETE FROM system WHERE id = ?",
            "i", $system_id
        );

        $stmt->close();
    }
    
        /**
     * update a system
     *
     * @param int system_id
     * @param varchar system_name
     */
    public function updateSystem($system_id, $system_name) {
        $stmt = \AL\Db\execute_query(
            "SystemDAO: updateSystem",
            $this->mysqli,
            "UPDATE system SET name = ? WHERE id = ?",
            "si", $system_name, $system_id
        );
        
        $stmt->close();
    }
}

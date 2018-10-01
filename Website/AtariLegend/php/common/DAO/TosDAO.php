<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Game/Tos.php" ;

/**
 * DAO for Tos versions
 */
class TosDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Get all Tos versions
     *
     * @return \AL\Common\Model\Game\Emulator[] An array of Tos versions
     */
    public function getAllTos() {
        $stmt = \AL\Db\execute_query(
            "TosDAO: getAllTos",
            $this->mysqli,
            "SELECT id, name FROM tos ORDER by name",
            null, null
        );

        \AL\Db\bind_result(
            "TosDAO: getAllTos",
            $stmt,
            $id, $name
        );

        $tos_versions = [];
        while ($stmt->fetch()) {
            $tos_versions[] = new \AL\Common\Model\Game\Tos(
                $id, $name
            );
        }

        $stmt->close();

        return $tos_versions;
    }

    /**
     * Get a map containing all tos versions, indexed by ID
     *
     * @return \AL\Common\Model\Game\Tos[] A map of tos versions
     */
    public function getAllTosAsMap() {
        $tos = $this->getAllTos();
        $tosMap = array();
        foreach ($tos as $tos_version) {
            $tosMap[$tos->getId()] = $tos_version;
        }

        return $tosMap;
    }

    /**
     * Get all TOS IDs incompatible with a release
     *
     * @param integer Release ID
     * @return integer[] List of incompatible TOS IDs
     */
    public function getIncompatibleTosForRelease($release_id) {
        $stmt = \AL\Db\execute_query(
            "TosDAO: getIncompatibleTosForRelease",
            $this->mysqli,
            "SELECT tos_id FROM game_release_tos_version_incompatibility WHERE release_id = ?",
            "i", $release_id
        );

        \AL\Db\bind_result(
            "TosDAO: getIncompatibleTosForRelease",
            $stmt,
            $tos_id
        );

        $tos_versions = [];
        while ($stmt->fetch()) {
            $tos_versions[] = $tos_id;
        }

        $stmt->close();

        return $tos_versions;
    }
    
        
     /**
     * Get all tos IDs incompatible with a release
     *
     * @param integer Release ID
     * @return integer[] List of incompatible TOS IDs
     */
    public function getIncompatibleTosWithNameForRelease($release_id) {
        $stmt = \AL\Db\execute_query(
            "TosDAO: getIncompatibleTosWithNameForRelease",
            $this->mysqli,
            "SELECT game_release_tos_version_incompatibility.tos_id,
                    tos.name FROM game_release_tos_version_incompatibility 
                    LEFT JOIN tos ON (game_release_tos_version_incompatibility.tos_id = tos.id)
                    WHERE release_id = ?",
            "i", $release_id
        );

        \AL\Db\bind_result(
            "TosDAO: getIncompatibleTosWithNameForRelease",
            $stmt,
            $tos_id, $tos_name
        );

        $tos_versions = [];
        while ($stmt->fetch()) {
            $tos_versions[] = new \AL\Common\Model\Game\Tos($tos_id, $tos_name);
        }

        $stmt->close();

        return $tos_versions;
    }

    /**
     * Set the list of tos versions a release is incompatible with
     *
     * @param integer Release ID
     * @param integer[] List of TOS IDs
     */
    public function setIncompatibleTosForRelease($release_id, $tos) {
        $stmt = \AL\Db\execute_query(
            "TosDAO: setIncompatibleTosForRelease",
            $this->mysqli,
            "DELETE FROM game_release_tos_version_incompatibility WHERE release_id = ?",
            "i", $release_id
        );

        foreach ($tos as $id) {
            $stmt = \AL\Db\execute_query(
                "TosDAO: setIncompatibleTosForRelease",
                $this->mysqli,
                "INSERT INTO game_release_tos_version_incompatibility (release_id, tos_id) VALUES (?, ?)",
                "ii", $release_id, $id
            );
        }

        $stmt->close();
    }
    
     /**
     * add a tos to the database
     *
     * @param varchar tos
     */
    public function addTos($tos) {
        $stmt = \AL\Db\execute_query(
            "TosDAO: addTos",
            $this->mysqli,
            "INSERT INTO tos (`name`) VALUES (?)",
            "s", $tos
        );

        $stmt->close();
    }
    
    /**
     * delete a tos version
     *
     * @param int tos_id
     */
    public function deleteTos($tos_id) {
        $stmt = \AL\Db\execute_query(
            "TosDAO: deleteTos",
            $this->mysqli,
            "DELETE FROM tos WHERE id = ?",
            "i", $tos_id
        );

        $stmt->close();
    }
    
     /**
     * update a tos version
     *
     * @param int tos_id
     * @param varchar tos_name
     */
    public function updateTos($tos_id, $tos_name) {
        $stmt = \AL\Db\execute_query(
            "TosDAO: updateTos",
            $this->mysqli,
            "UPDATE tos SET name = ? WHERE id = ?",
            "si", $tos_name, $tos_id
        );
        
        $stmt->close();
    }
}

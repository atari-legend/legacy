<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Game/Resolution.php" ;

/**
 * DAO for resolutions
 */
class ResolutionDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Get all resolutions
     */
    public function getAllResolutions() {
        $stmt = \AL\Db\execute_query(
            "ResolutionDAO: getAllResolutions",
            $this->mysqli,
            "SELECT id, name FROM resolution ORDER BY id",
            null, null
        );

        \AL\Db\bind_result(
            "ResolutionDAO: getAllResolutions",
            $stmt,
            $id, $name
        );

        $resolutions = [];
        while ($stmt->fetch()) {
            $resolutions[] = new \AL\Common\Model\Game\Resolution(
                $id, $name
            );
        }

        $stmt->close();

        return $resolutions;
    }

    /**
     * Get list of resolution IDs for a release
     *
     * @param integer Release ID
     */
    public function getResolutionsForRelease($release_id) {
        $stmt = \AL\Db\execute_query(
            "ResolutionDAO: getResolutionsForRelease",
            $this->mysqli,
            "SELECT resolution_id FROM game_release_resolution WHERE game_release_id = ?",
            "i", $release_id
        );

        \AL\Db\bind_result(
            "ResolutionDAO: getResolutionsForRelease",
            $stmt,
            $resolution_id
        );

        $resolutions = [];
        while ($stmt->fetch()) {
            $resolutions[] = $resolution_id;
        }

        $stmt->close();

        return $resolutions;
    }

    /**
     * Set the list of resolutions supported by a release
     *
     * @param integer Release ID
     * @param integer[] List of resolution IDs
     */

    public function setResolutionsForRelease($release_id, $resolutions) {
        $stmt = \AL\Db\execute_query(
            "ResolutionDAO: setResolutionsForRelease",
            $this->mysqli,
            "DELETE FROM game_release_resolution WHERE game_release_id = ?",
            "i", $release_id
        );

        foreach ($resolutions as $id) {
            $stmt = \AL\Db\execute_query(
                "ResolutionDAO: setResolutionsForRelease",
                $this->mysqli,
                "INSERT INTO game_release_resolution (game_release_id, resolution_id) VALUES (?, ?)",
                "ii", $release_id, $id
            );
        }

        $stmt->close();
    }
}

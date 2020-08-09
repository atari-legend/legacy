<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Game/GameReleaseScan.php" ;

/**
 * DAO for Game Release Scans
 */
class GameReleaseScanDAO {
    private $mysqli;

    const TYPES = [
        "Box front", "Box back", "Goodie", "Other"
    ];

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Get the list of supported scan types
     *
     * @return string[] List of types
     */
    public function getScanTypes() {
        return self::TYPES;
    }

    /**
     * Add a scan to game release
     *
     * @param int $game_release_id ID of the release to add the scan to
     * @param string $type Type of scan
     * @param string $imgext Image extension
     *
     * @return int ID of the newly created scan
    */
    public function addScanToRelease($game_release_id, $type, $imgext, $notes) {
        $stmt = \AL\Db\execute_query(
            "GameReleaseScanDAO: addScanToRelease",
            $this->mysqli,
            "INSERT INTO game_release_scan (`game_release_id`, `type`, `imgext`, `notes`) VALUES (?, ?, ?, ?)",
            "isss", $game_release_id, $type, $imgext, $notes
        );

        $last_id = $stmt->insert_id;

        $stmt->close();

        return $last_id;
    }

    /**
     * Get all scans for a release
     *
     * @param int $game_release_id ID of the release to get scans for
     * @return \AL\Common\Model\Game\GameReleaseScan[] A list of scans
     */
    public function getScansForRelease($game_release_id) {
        $stmt = \AL\Db\execute_query(
            "GameReleaseScanDAO: getScansForRelease",
            $this->mysqli,
            "SELECT id, game_release_id, type, imgext, notes
            FROM game_release_scan
            WHERE game_release_id = ?",
            "i", $game_release_id
        );

        \AL\Db\bind_result(
            "GameReleaseScanDAO: getScansForRelease",
            $stmt,
            $id, $game_release_id, $type, $imgext, $notes
        );

        $scans = [];

        while ($stmt->fetch()) {
            $scans[] = new \AL\Common\Model\Game\GameReleaseScan(
                $id, $game_release_id, $type, $imgext, $notes
            );
        }

        $stmt->close();

        return $scans;
    }

    /**
     * Retrieve a sing scan
     *
     * @param int $scan_id ID of the scan to retrieve
     * @return \AL\Common\Model\Game\GameReleaseScan A scan
     */
    public function getScan($scan_id) {
        $stmt = \AL\Db\execute_query(
            "GameReleaseScanDAO: getScan",
            $this->mysqli,
            "SELECT id, game_release_id, type, imgext, notes
            FROM game_release_scan
            WHERE id = ?",
            "i", $scan_id
        );

        \AL\Db\bind_result(
            "GameReleaseScanDAO: getScansForRelease",
            $stmt,
            $id, $game_release_id, $type, $imgext, $notes
        );

        $scan = null;

        if ($stmt->fetch()) {
            $scan = new \AL\Common\Model\Game\GameReleaseScan(
                $id, $game_release_id, $type, $imgext, $notes
            );
        }

        $stmt->close();

        return $scan;
    }

    /**
     * Delete a scan
     *
     * @param int $scan_id ID of the scan to delete
     */
    public function deleteScan($scan_id) {
        $stmt = \AL\Db\execute_query(
            "GameReleaseScanDAO: deleteScan",
            $this->mysqli,
            "DELETE FROM game_release_scan WHERE id = ?",
            "i", $scan_id
        );

        $stmt->close();
    }
}

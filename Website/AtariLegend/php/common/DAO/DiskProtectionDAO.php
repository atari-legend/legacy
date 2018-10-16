<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Game/DiskProtection.php" ;

/**
 * DAO for Disk Protection
 */
class DiskProtectionDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Get all Disk Protection Types
     *
     * @return \AL\Common\Model\Game\DiskProtection[] An array of disk protection types
     */
    public function getAllDiskProtections() {
        $stmt = \AL\Db\execute_query(
            "diskProtectionDAO: getAllDiskProtections",
            $this->mysqli,
            "SELECT id, name FROM disk_protection ORDER BY name",
            null, null
        );

        \AL\Db\bind_result(
            "diskProtectionDAO: getAllDiskProtections",
            $stmt,
            $id, $name
        );

        $disk_protection_types = [];
        while ($stmt->fetch()) {
            $disk_protection_types[] = new \AL\Common\Model\Game\diskProtection(
                $id, $name, null
            );
        }

        $stmt->close();

        return $disk_protection_types;
    }

    /**
     * Get list of disk_protection IDs for a game release
     *
     * @param integer release ID
     */
    public function getDiskProtectionsForRelease($release_id) {
        $stmt = \AL\Db\execute_query(
            "diskProtectionDAO: getDiskProtectionsForRelease",
            $this->mysqli,
            "SELECT disk_protection_id, name, notes
            FROM game_release_disk_protection LEFT JOIN 
            disk_protection ON (game_release_disk_protection.disk_protection_id = disk_protection.id)
            WHERE release_id = ?",
            "i", $release_id
        );

        \AL\Db\bind_result(
            "diskProtectionDAO: getDiskProtectionsForRelease",
            $stmt,
            $disk_protection_id, $name, $notes
        );

        $disk_protection_types = [];
        while ($stmt->fetch()) {
            $disk_protection_types[] = new \AL\Common\Model\Game\DiskProtection(
                $disk_protection_id, $name, $notes
            );
        }

        $stmt->close();

        return $disk_protection_types;
    }
    
     /**
     * Add diskProtection for release
     *
     * @param integer Game Release ID
     * @param integer protection ID
     * $param text note
     */
    public function addDiskProtectionForRelease($game_release_id, $protection_id, $note) {
       
        $stmt = \AL\Db\execute_query(
            "diskProtectionDAO: addDiskProtectionForRelease",
            $this->mysqli,
            "INSERT INTO game_release_disk_protection (release_id, disk_protection_id, notes) VALUES (?, ?, ?)",
            "iis", $game_release_id, $protection_id, $note
        );

        $stmt->close();
    }
    
     /**
     * Delete diskProtection for release
     *
     * @param integer Game Release ID
     * @param integer protection ID
     */
    public function deleteDiskProtectionForRelease($game_release_id, $protection_id) {
        $stmt = \AL\Db\execute_query(
            "diskProtectionDAO: deleteDiskProtectionForRelease",
            $this->mysqli,
            "DELETE FROM game_release_disk_protection
            WHERE release_id = ? AND disk_protection_id = ?",
            "ii", $game_release_id, $protection_id
        );

        $stmt->close();
    }
     
     /**
     * add a disk protection to the database
     *
     * @param varchar Disk_protection
     */
    public function addDiskProtection($disk_protection) {
        $stmt = \AL\Db\execute_query(
            "diskProtectionDAO: addDiskProtection",
            $this->mysqli,
            "INSERT INTO disk_protection (`name`) VALUES (?)",
            "s", $disk_protection
        );

        $stmt->close();
    }
    
    /**
     * delete a disk_protection
     *
     * @param int $disk_protection_id
     */
    public function deleteDiskProtection($disk_protection_id) {
        $stmt = \AL\Db\execute_query(
            "diskProtectionDAO: deleteDiskProtection",
            $this->mysqli,
            "DELETE FROM disk_protection WHERE id = ?",
            "i", $disk_protection_id
        );

        $stmt->close();
    }
    
        /**
     * update a disk_protection
     *
     * @param int disk_protection_id
     * @param varchar disk_protection
     */
    public function updateDiskProtection($disk_protection_id, $disk_protection_name) {
        $stmt = \AL\Db\execute_query(
            "diskProtectionDAO: updateDiskProtection",
            $this->mysqli,
            "UPDATE disk_protection SET name = ? WHERE id = ?",
            "si", $disk_protection_name, $disk_protection_id
        );
        
        $stmt->close();
    }
}

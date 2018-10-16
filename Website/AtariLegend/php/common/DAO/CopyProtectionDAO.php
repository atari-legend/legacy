<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Game/CopyProtection.php" ;

/**
 * DAO for Copy Protection
 */
class CopyProtectionDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Get all Copy Protection Types
     *
     * @return \AL\Common\Model\Game\CopyProtection[] An array of copy protection types
     */
    public function getAllCopyProtections() {
        $stmt = \AL\Db\execute_query(
            "CopyProtectionDAO: getAllCopyProtections",
            $this->mysqli,
            "SELECT id, name FROM copy_protection ORDER BY name",
            null, null
        );

        \AL\Db\bind_result(
            "CopyProtectionDAO: getAllCopyProtections",
            $stmt,
            $id, $name
        );

        $copy_protection_types = [];
        while ($stmt->fetch()) {
            $copy_protection_types[] = new \AL\Common\Model\Game\CopyProtection(
                $id, $name, null
            );
        }

        $stmt->close();

        return $copy_protection_types;
    }

    /**
     * Get list of copy_protection IDs for a game release
     *
     * @param integer release ID
     */
    public function getCopyProtectionsForRelease($release_id) {
        $stmt = \AL\Db\execute_query(
            "CopyProtectionDAO: getCopyProtectionsForRelease",
            $this->mysqli,
            "SELECT copy_protection_id, name, notes
            FROM game_release_copy_protection LEFT JOIN 
            copy_protection ON (game_release_copy_protection.copy_protection_id = copy_protection.id)
            WHERE release_id = ?",
            "i", $release_id
        );

        \AL\Db\bind_result(
            "CopyProtectionDAO: getCopyProtectionsForRelease",
            $stmt,
            $copy_protection_id, $name, $notes
        );

        $copy_protection_types = [];
        while ($stmt->fetch()) {
            $copy_protection_types[] = new \AL\Common\Model\Game\CopyProtection(
                $copy_protection_id, $name, $notes
            );
        }

        $stmt->close();

        return $copy_protection_types;
    }
    
     /**
     * Add copy Protection for release
     *
     * @param integer Game Release ID
     * @param integer protection ID
     * $param text note
     */
    public function addCopyProtectionForRelease($game_release_id, $protection_id, $note) {
       
        $stmt = \AL\Db\execute_query(
            "copyProtectionDAO: addCopyProtectionForRelease",
            $this->mysqli,
            "INSERT INTO game_release_copy_protection (release_id, copy_protection_id, notes) VALUES (?, ?, ?)",
            "iis", $game_release_id, $protection_id, $note
        );

        $stmt->close();
    }
    
     /**
     * Delete copy Protection for release
     *
     * @param integer Game Release ID
     * @param integer protection ID
     */
    public function deleteCopyProtectionForRelease($game_release_id, $protection_id) {
        $stmt = \AL\Db\execute_query(
            "copyProtectionDAO: deleteCopyProtectionForRelease",
            $this->mysqli,
            "DELETE FROM game_release_copy_protection
            WHERE release_id = ? AND copy_protection_id = ?",
            "ii", $game_release_id, $protection_id
        );

        $stmt->close();
    }
     
     /**
     * add a copy protection to the database
     *
     * @param varchar copy_protection
     */
    public function addCopyProtection($copy_protection) {
        $stmt = \AL\Db\execute_query(
            "CopyProtectionDAO: addCopyProtection",
            $this->mysqli,
            "INSERT INTO copy_protection (`name`) VALUES (?)",
            "s", $copy_protection
        );

        $stmt->close();
    }
    
    /**
     * delete a copy_protection
     *
     * @param int $copy_protection_id
     */
    public function deleteCopyProtection($copy_protection_id) {
        $stmt = \AL\Db\execute_query(
            "CopyProtectionDAO: deleteCopyProtection",
            $this->mysqli,
            "DELETE FROM copy_protection WHERE id = ?",
            "i", $copy_protection_id
        );

        $stmt->close();
    }
    
        /**
     * update a copy_protection
     *
     * @param int copy_protection_id
     * @param varchar copy_protection
     */
    public function updateCopyProtection($copy_protection_id, $copy_protection_name) {
        $stmt = \AL\Db\execute_query(
            "CopyProtectionDAO: updateCopyProtection",
            $this->mysqli,
            "UPDATE copy_protection SET name = ? WHERE id = ?",
            "si", $copy_protection_name, $copy_protection_id
        );
        
        $stmt->close();
    }
}

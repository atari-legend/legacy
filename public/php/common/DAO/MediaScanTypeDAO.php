<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Dump/MediaScanType.php" ;

/**
 * DAO for Media Scan Type
 */
class MediaScanTypeDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Get all Media Scan Types
     *
     * @return \AL\Common\Model\Dump\MediaType[] An array of media types
     */
    public function getAllMediaScanTypes() {
        $stmt = \AL\Db\execute_query(
            "MediaScanTypeDAO: getAllMediaScanTypes",
            $this->mysqli,
            "SELECT id, name FROM media_scan_type ORDER BY name",
            null, null
        );

        \AL\Db\bind_result(
            "MediaScanTypeDAO: getAllMediaScanTypes",
            $stmt,
            $id, $name
        );

        $media_scan_types = [];
        while ($stmt->fetch()) {
            $media_scan_types[] = new \AL\Common\Model\Dump\MediaScanType(
                $id, $name
            );
        }

        $stmt->close();

        return $media_scan_types;
    }

     /**
     * add a media scan type to the database
     *
     * @param varchar media_type
     */
    public function addMediaScanType($media_scan_type) {
        $stmt = \AL\Db\execute_query(
            "MediaScanTypeDAO: addMediaScanType",
            $this->mysqli,
            "INSERT INTO media_scan_type (`name`) VALUES (?)",
            "s", $media_scan_type
        );

        $stmt->close();
    }
    
    /**
     * delete a media_scan_type
     *
     * @param int $media_scan_type_id
     */
    public function deleteMediaScanType($media_scan_type_id) {
        $stmt = \AL\Db\execute_query(
            "MediaScanTypeDAO: deleteScanMediaType",
            $this->mysqli,
            "DELETE FROM media_scan_type WHERE id = ?",
            "i", $media_scan_type_id
        );

        $stmt->close();
    }
    
        /**
     * update a media_scan_type
     *
     * @param int media_scan_type_id
     * @param varchar media_scan_type
     */
    public function updateMediaScanType($media_scan_type_id, $media_scan_type_name) {
        $stmt = \AL\Db\execute_query(
            "MediaScanTypeDAO: updateMediaScanType",
            $this->mysqli,
            "UPDATE media_scan_type SET name = ? WHERE id = ?",
            "si", $media_scan_type_name, $media_scan_type_id
        );
        
        $stmt->close();
    }
}

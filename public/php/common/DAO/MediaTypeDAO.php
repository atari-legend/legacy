<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Dump/MediaType.php" ;

/**
 * DAO for Media Type
 */
class MediaTypeDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Get all Media Types
     *
     * @return \AL\Common\Model\Dump\MediaType[] An array of media types
     */
    public function getAllMediaTypes() {
        $stmt = \AL\Db\execute_query(
            "MediaTypeDAO: getAllMediaTypes",
            $this->mysqli,
            "SELECT id, name FROM media_type ORDER BY name",
            null, null
        );

        \AL\Db\bind_result(
            "MediaTypeDAO: getAllMediaTypes",
            $stmt,
            $id, $name
        );

        $media_types = [];
        while ($stmt->fetch()) {
            $media_types[] = new \AL\Common\Model\Dump\MediaType(
                $id, $name
            );
        }

        $stmt->close();

        return $media_types;
    }

     /**
     * add a media type to the database
     *
     * @param varchar media_type
     */
    public function addMediaType($media_type) {
        $stmt = \AL\Db\execute_query(
            "MediaTypeDAO: addMediaType",
            $this->mysqli,
            "INSERT INTO media_type (`name`) VALUES (?)",
            "s", $media_type
        );

        $stmt->close();
    }
    
    /**
     * delete a media_type
     *
     * @param int $media_type_id
     */
    public function deleteMediaType($media_type_id) {
        $stmt = \AL\Db\execute_query(
            "MediaTypeDAO: deleteMediaType",
            $this->mysqli,
            "DELETE FROM media_type WHERE id = ?",
            "i", $media_type_id
        );

        $stmt->close();
    }
    
        /**
     * update a media_type
     *
     * @param int media_type_id
     * @param varchar media_type
     */
    public function updateMediaType($media_type_id, $media_type_name) {
        $stmt = \AL\Db\execute_query(
            "MediaTypeDAO: updateMediaType",
            $this->mysqli,
            "UPDATE media_type SET name = ? WHERE id = ?",
            "si", $media_type_name, $media_type_id
        );
        
        $stmt->close();
    }
}

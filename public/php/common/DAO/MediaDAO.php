<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Dump/Media.php" ;
require_once __DIR__."/../Model/Dump/MediaType.php" ;

/**
 * DAO for Media
 */
class MediaDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Get all Media from Release
     *
     * @return \AL\Common\Model\Dump\Media[] An array of media
     */
    public function getAllMediaFromRelease($release_id) {
        $stmt = \AL\Db\execute_query(
            "MediaTypeDAO: getAllMediaFromRelease",
            $this->mysqli,
            "SELECT media.id, media.label, media.media_type_id, media_type.name FROM media
            LEFT JOIN media_type ON (media.media_type_id = media_type.id)
            WHERE release_id = ? order by media.media_type_id, media.id",
            "i", $release_id
        );

        \AL\Db\bind_result(
            "MediaDAO: getAllMediaFromRelease",
            $stmt,
            $id, $label, $type_id, $name
        );

        $media = [];
        while ($stmt->fetch()) {
            $media[] = new \AL\Common\Model\Dump\Media(
                $id, $label,
                ($type_id != null)
                    ? new \AL\Common\Model\dump\MediaType($type_id, $name)
                    : null
            );
        }

        $stmt->close();

        return $media;
    }

     /**
     * Add a media to a release
     *
     * @param int release_id
     * @param int media_type_id
     */
    public function addMediaToRelease($release_id, $type_id, $label) {
        $stmt = \AL\Db\execute_query(
            "MediaDAO: AddMediaToRelease",
            $this->mysqli,
            "INSERT INTO media (`release_id`, `media_type_id`, `label` ) VALUES (?, ?, ?)",
            "iis", $release_id, $type_id, $label
        );

        $stmt->close();
    }

     /**
     * delete a media from a release
     *
     * @param int media_id
     */
    public function deleteMediaFromRelease($media_id) {
        $stmt = \AL\Db\execute_query(
            "MediaDAO: deleteMediaToRelease",
            $this->mysqli,
            "DELETE FROM media WHERE id = ?",
            "i", $media_id
        );

        $stmt->close();
    }

     /**
     * update a media label
     *
     * @param int media_id
     * @param varchar label
     */
    public function updateMedia($media_id, $label, $media_type_id) {
        $stmt = \AL\Db\execute_query(
            "MediaDAO: setLabelFromMedia",
            $this->mysqli,
            "UPDATE media SET label = ?, media_type_id = ? WHERE id = ?",
            "sii", $label, $media_type_id, $media_id
        );

        $stmt->close();
    }
}

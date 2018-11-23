<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Dump/MediaScan.php" ;
require_once __DIR__."/../Model/Dump/MediaScanType.php" ;

/**
 * DAO for MediaScan
 */
class MediaScanDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

     /**
     * Add a mediaScan to a media
     *
     * @param int release_id
     * @param int media_type_id
     */
    public function addMediaScanToMedia($media_id, $scan_type_id, $media_scan_save_path, $image) {

        foreach ($image['tmp_name'] as $key => $tmp_name) {
            if ($tmp_name !== 'none') {
                // Check what extention the file has and if it is allowed.
                $ext        = "";
                $type_image = $image['type'][$key];

                // set extension
                if ($type_image == 'image/png') {
                    $ext = 'png';
                } elseif ($type_image == 'image/x-png') {
                    $ext = 'png';
                } elseif ($type_image == 'image/gif') {
                    $ext = 'gif';
                } elseif ($type_image == 'image/jpeg') {
                    $ext = 'jpg';
                }

                if ($ext !== "") {
                    $stmt = \AL\Db\execute_query(
                        "MediaScanDAO: addMediaScanToMedia",
                        $this->mysqli,
                        "INSERT INTO media_scan (`media_id`, `media_scan_type_id`, `imgext`) VALUES (?, ?, ?)",
                        "iis", $media_id, $scan_type_id, $ext
                    );

                    $last_id = $stmt->insert_id;

                    // Rename the uploaded file to its autoincrement number and move it to its proper place.
                    $file_data = rename($image['tmp_name'][$key], "$media_scan_save_path$last_id.$ext");
                    chmod("$media_scan_save_path$last_id.$ext", 0777);

                    $stmt->close();
                } else {
                    exit("This file extension is not allowed");
                }
            }
        }
    }

    /**
     * Get all MediaScans from this media
     *
     * @return \AL\Common\Model\Dump\MediaScan[] An array of mediascans
     */
    public function getAllMediaScansFromMedia($media_id) {
        $stmt = \AL\Db\execute_query(
            "MediaScanDAO: getAllMediaScansFromMedia",
            $this->mysqli,
            "SELECT media_scan.id, media_scan.imgext, media_scan_type.id, media_scan_type.name FROM media_scan
            LEFT JOIN media_scan_type ON (media_scan.media_scan_type_id = media_scan_type.id)
            WHERE media_scan.media_id = ?",
            "i", $media_id
        );

        \AL\Db\bind_result(
            "MediaScanDAO: getAllMediaScansFromMedia",
            $stmt,
            $media_scan_id, $media_scan_imgext, $media_scan_type_id, $media_scan_type_name
        );

        $media_scan = [];
        while ($stmt->fetch()) {
            $media_scan[] = new \AL\Common\Model\Dump\MediaScan(
                $media_scan_id, $media_id, $media_scan_imgext,
                ($media_scan_type_name != null)
                    ? new \AL\Common\Model\dump\MediaScanType($media_scan_type_id, $media_scan_type_name)
                 : null
            );
        }

        $stmt->close();

        return $media_scan;
    }

    /*
     * delete scan from a media
     *
     * @param int media_scan_id
     */
    public function deleteScanFromMedia($media_scan_id, $media_scan_save_path, $ext) {
        $stmt = \AL\Db\execute_query(
            "MediaScanDAO: deleteScanFromMedia",
            $this->mysqli,
            "DELETE FROM media_scan WHERE id = ?",
            "i", $media_scan_id
        );

        $new_path = $media_scan_save_path;
        $new_path .= $media_scan_id;
        $new_path .= ".";
        $new_path .= $ext;

        unlink("$new_path");

        $stmt->close();
    }

    /*
     * check is scantype exist on media
     *
     * @param int media_id
     * @param int scan_type_id
     */
    public function checkForScanType($media_id, $scan_type_id) {
        $stmt = \AL\Db\execute_query(
            "MediaScanDAO: checkForScanType",
            $this->mysqli,
            "SELECT id FROM media_scan
            WHERE media_id = ? and media_scan_type_id = ?",
            "ii", $media_id, $scan_type_id
        );

        \AL\Db\bind_result(
            "MediaScanDAO: checkForScanType",
            $stmt,
            $media_scan_id
        );

        $media_scan_id = null;
        if ($stmt->fetch()) {
            $media_scan_id  = new \AL\Common\Model\Dump\MediaScan(
                $media_scan_id, null, null, null
            );
        }

        $stmt->close();

        return $media_scan_id;
    }
}

<?php
namespace AL\Common\Model\Dump;

/**
 * Maps to the `MediaScan` table
 */
class MediaScan {
    private $id;
    private $media_id;
    private $image;
    private $media_scan_type;

    public function __construct($id, $media_id, $image, $media_scan_type) {
        $this->id = $id;
        $this->media_id = $media_id;
        $this->media_scan_type = $media_scan_type;
        $this->image = $image;
    }

    public function getId() {
        return $this->id;
    }

    public function getMediaId() {
        return $this->media_id;
    }
    
    public function getMediaScanType() {
        return $this->media_scan_type;
    }
    
    public function getImage() {
        return $this->image;
    }
}

<?php
namespace AL\Common\Model\Dump;

/**
 * Maps to the `media_scan_type` table
 */
class MediaScanType {
    private $id;
    private $name;
    
    public function __construct($id, $name) {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }
}

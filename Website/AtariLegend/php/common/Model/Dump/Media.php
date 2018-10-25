<?php
namespace AL\Common\Model\Dump;

/**
 * Maps to the `Media` table
 */
class Media {
    private $id;
    private $media_type;

    public function __construct($id, $media_type) {
        $this->id = $id;
        $this->media_type = $media_type;
    }

    public function getId() {
        return $this->id;
    }
   
    public function getMediaType() {
        return $this->media_type;
    }
}

<?php
namespace AL\Common\Model\Dump;

/**
 * Maps to the `Media` table
 */
class Media {
    private $id;
    private $label;
    private $media_type;

    public function __construct($id, $label, $media_type) {
        $this->id = $id;
        $this->label = $label;
        $this->media_type = $media_type;
    }

    public function getId() {
        return $this->id;
    }
    
    public function getLabel() {
        return $this->label;
    }

    public function getMediaType() {
        return $this->media_type;
    }
}

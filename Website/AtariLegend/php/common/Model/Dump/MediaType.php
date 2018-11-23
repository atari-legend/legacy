<?php
namespace AL\Common\Model\Dump;

/**
 * Maps to the `media_type` table
 */
class MediaType {
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

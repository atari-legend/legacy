<?php
namespace AL\Common\Model\Game;

/**
 * Maps to the `Sound Hardware` table
 */
class SoundHardware {
    private $id;
    private $name;
    private $description;

    public function __construct($id, $name, $description) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }
    
    public function getDescription() {
        return $this->description;
    }
}

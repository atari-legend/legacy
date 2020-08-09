<?php
namespace AL\Common\Model\Game;

/**
 * Maps to the `system` table
 */
class System {
    private $id;
    private $name;
    private $enhancement;

    public function __construct($id, $name, $enhancement) {
        $this->id = $id;
        $this->name = $name;
        $this->enhancement = $enhancement;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }
    
    public function getEnhancement() {
        return $this->enhancement;
    }
}

<?php
namespace AL\Common\Model\Game;

/**
 * Maps to the `memory` table
 */
class Memory {
    private $id;
    private $memory;
    private $enhancement;

    public function __construct($id, $memory, $enhancement) {
        $this->id = $id;
        $this->memory = $memory;
        $this->enhancement = $enhancement;
    }

    public function getId() {
        return $this->id;
    }

    public function getMemory() {
        return $this->memory;
    }
    
    public function getEnhancement() {
        return $this->enhancement;
    }
}

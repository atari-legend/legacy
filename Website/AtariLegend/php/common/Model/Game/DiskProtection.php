<?php
namespace AL\Common\Model\Game;

/**
 * Maps to the `disk_protection` table
 */
class DiskProtection {
    private $id;
    private $name;
    private $note;

    public function __construct($id, $name, $note) {
        $this->id = $id;
        $this->name = $name;
        $this->note = $note;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }
    
    public function getNote() {
        return $this->note;
    }
}

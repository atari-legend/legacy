<?php
namespace AL\Common\Model\Game;

/**
 * Maps to the `tos version` table
 */
class Tos {
    private $id;
    private $name;
    private $language;

    public function __construct($id, $name, $language) {
        $this->id = $id;
        $this->name = $name;
        $this->language = $language;
    }
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }
    
    public function getLanguage() {
        return $this->language;
    }
}

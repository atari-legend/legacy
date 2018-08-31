<?php
namespace AL\Common\Model\Game;

/**
 * Maps to the `game` table
 */
class Game {
    private $id;
    private $name;

    public function __construct($id, $name, $programming_language_id = null) {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }
    
    public function getProgrammingLanguageId() {
        return $this->ProgrammingLanguage;
    }
}

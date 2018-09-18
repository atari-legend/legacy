<?php
namespace AL\Common\Model\Game;

/**
 * Maps to the `Game Genre` table
 */
class GameGenre {
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

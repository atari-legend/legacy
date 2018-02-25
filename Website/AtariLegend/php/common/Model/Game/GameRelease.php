<?php
namespace AL\Common\Model\Game;

/**
 * Maps to the `game_rlease` table
 */
class GameRelease {
    private $id;
    private $game_id;
    private $name;
    private $date;

    public function __construct($id, $game_id, $name, $date) {
        $this->id = $id;
        $this->game_id = $game_id;
        $this->name = $name;
        $this->date = $date;
    }

    public function getId() {
        return $this->id;
    }

    public function getDate() {
        return $this->date;
    }

    public function getName() {
        return $this->name;
    }
}

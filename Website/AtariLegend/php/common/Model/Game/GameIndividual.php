<?php
namespace AL\Common\Model\Game;

/**
 * Maps to the `Game_individual` table
 */
class GameIndividual {
    private $id;
    private $game;
    private $individual;
    private $role;

    public function __construct($id, $game, $individual, $role) {
        $this->id = $id;
        $this->game = $game;
        $this->individual = $individual;
        $this->role = $role;
    }

    public function getId() {
        return $this->id;
    }

    public function getGame() {
        return $this->game;
    }

    public function getIndividual() {
        return $this->individual;
    }

    public function getRole() {
        return $this->role;
    }
}

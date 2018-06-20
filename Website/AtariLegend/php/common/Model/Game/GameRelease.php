<?php
namespace AL\Common\Model\Game;

/**
 * Maps to the `game_release` table
 */
class GameRelease {
    private $id;
    private $game_id;
    private $name;
    private $date;
    private $license;

    public function __construct($id, $game_id, $name, $date, $license) {
        $this->id = $id;
        $this->game_id = $game_id;
        $this->name = $name;
        $this->date = $date;
        $this->license = $license;
    }

    public function getId() {
        return $this->id;
    }

    public function getGameId() {
        return $this->game_id;
    }

    public function getDate() {
        return $this->date;
    }

    public function getName() {
        return $this->name;
    }

    public function getLicense() {
        return $this->license;
    }
}

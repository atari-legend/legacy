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
    private $type;
    private $continent;
    private $publisher;

    public function __construct($id, $game_id, $name, $date, $license, $type, $continent, $publisher) {
        $this->id = $id;
        $this->game_id = $game_id;
        $this->name = $name;
        $this->date = $date;
        $this->license = $license;
        $this->type = $type;
        $this->continent = $continent;
        $this->publisher = $publisher;
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

    public function getType() {
        return $this->type;
    }

    public function getContinent() {
        return $this->continent;
    }

    public function getPublisher() {
        return $this->publisher;
    }
}

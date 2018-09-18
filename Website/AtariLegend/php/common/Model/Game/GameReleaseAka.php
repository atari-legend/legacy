<?php
namespace AL\Common\Model\Game;

/**
 * Maps to the `game_release_aka` table
 */
 
class GameReleaseAKA {
    private $id;
    private $game_release_id;
    private $name;
    private $language;

    public function __construct($id, $game_release_id, $name, $language) {
        $this->id = $id;
        $this->game_release_id = $game_release_id;
        $this->name = $name;
        $this->language = $language;
    }

    public function getId() {
        return $this->id;
    }

    public function getGameReleaseId() {
        return $this->game_release_id;
    }

    public function getName() {
        return $this->name;
    }

    public function getLanguage() {
        return $this->language;
    }
}

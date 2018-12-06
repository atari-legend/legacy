<?php
namespace AL\Common\Model\Game;

/**
 * Maps to the `game` table
 */
class Game {
    private $id;
    private $name;
    private $series_id;
    private $midi_link;
    private $players;

    public function __construct($id, $name, $series_id = null, $midi_link = null, $players = null) {
        $this->id = $id;
        $this->name = $name;
        $this->series_id = $series_id;
        $this->midi_link = $midi_link;
        $this->players = $players;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getSeriesId() {
        return $this->series;
    }
    
    public function getMidiLink() {
        return $this->midi_link;
    }
    
    public function getPlayers() {
        return $this->players;
    }
}

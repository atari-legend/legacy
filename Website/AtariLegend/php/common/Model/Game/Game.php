<?php
namespace AL\Common\Model\Game;

/**
 * Maps to the `game` table
 */
class Game {
    private $id;
    private $name;
    private $series_id;

    public function __construct($id, $name, $series_id = null) {
        $this->id = $id;
        $this->name = $name;
        $this->series_id = $series_id;
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
}

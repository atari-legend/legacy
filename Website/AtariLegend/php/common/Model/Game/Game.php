<?php
namespace AL\Common\Model\Game;

/**
 * Maps to the `game` table
 */
class Game {
    private $id;
    private $name;
    private $series_id;
    private $nr_players_on_same_machine;
    private $nr_player_multiple_machines;
    private $multiplayer_type;
    private $multiplayer_hardware;

    public function __construct(
    $id,
    $name,
    $series_id = null,
    $nr_players_on_same_machine = null,
    $nr_player_multiple_machines = null,
    $multiplayer_type = null,
    $multiplayer_hardware = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->series_id = $series_id;
        $this->nr_players_on_same_machine = $nr_players_on_same_machine;
        $this->nr_player_multiple_machines = $nr_player_multiple_machines;
        $this->multiplayer_type = $multiplayer_type;
        $this->multiplayer_hardware = $multiplayer_hardware;
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
    
    public function getPlayersSameMachine() {
        return $this->nr_players_on_same_machine;
    }
    
    public function getPlayersMultipleMachines() {
        return $this->nr_player_multiple_machines;
    }
    
    public function getMultiplayerType() {
        return $this->multiplayer_type;
    }
    
    public function getMultiplayerHardware() {
        return $this->multiplayer_hardware;
    }
}

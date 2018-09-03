<?php
namespace AL\Common\Model\Game;

/**
 * Maps to the `Game_individual` table
 */
class GameIndividual {
    private $id;
    private $game_id;
    private $individual_id;
    private $individual_role_id;

    public function __construct($id, $game_id, $individual_id, $individual_role_id) {
        $this->id = $id;
        $this->gameId = $game_id;
        $this->individualId = $individual_id;
        $this->individualRoleId = $individual_role_id;
    }

    public function getId() {
        return $this->id;
    }

    public function getGameId() {
        return $this->gameId;
    }
    
    public function getIndividualId() {
        return $this->individualId;
    }
    
    public function getIndividualRoleId() {
        return $this->individualRoleId;
    }
}

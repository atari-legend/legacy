<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Game/GameIndividual.php" ;

/**
 * DAO for game individuals
 */
class GameIndividualDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Get list of game_individual IDs for a game
     *
     * @param integer Game ID
     */
    public function getGameIndividualsForGame($game_id) {
        $stmt = \AL\Db\execute_query(
            "GameIndividualDAO: getGameIndividualsForGame",
            $this->mysqli,
            "SELECT game_individual.id, game_id, individuals.ind_id, individual_role.id FROM game_individual
            LEFT JOIN individuals ON (game_individual.individual_id = individuals.ind_id)
            LEFT JOIN individual_role ON (game_individual.individual_role_id = individual_role.id)
            WHERE game_individual.game_id = ?",
            "i", $game_id
        );

        \AL\Db\bind_result(
            "GameIndividualDAO: getGameIndividualsForGame",
            $stmt,
            $game_individual_id, $game_id, $individual_id, $individual_role_id
        );

        $game_individual = [];
        while ($stmt->fetch()) {
            $game_individual[] = new \AL\Common\Model\Game\GameIndividual(
                $game_individual_id, $game_id, $individual_id, $individual_role_id
            );
        }

        $stmt->close();

        return $game_individual;
    }
}

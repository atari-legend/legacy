<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Game/GameIndividual.php" ;
require_once __DIR__."/../Model/Game/Game.php" ;
require_once __DIR__."/../Model/Individual/Individual.php" ;
require_once __DIR__."/../Model/Individual/IndividualRole.php" ;

/**
 * DAO for game individuals
 */
class GameIndividualDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Get list of individual and their roles for a game
     *
     * @param integer Game ID
     * @return \AL\Common\Model\Game\GameIndividual[] A list of individual with roles
     */
    public function getGameIndividualsForGame($game_id) {
        $stmt = \AL\Db\execute_query(
            "GameIndividualDAO: getGameIndividualsForGame",
            $this->mysqli,
            "SELECT
                game_individual.id,
                game.game_id,
                game.game_name,
                individuals.ind_id,
                individuals.ind_name,
                individual_role.id,
                individual_role.name
            FROM game_individual
            LEFT JOIN game ON (game_individual.game_id = game.game_id)
            LEFT JOIN individuals ON (game_individual.individual_id = individuals.ind_id)
            LEFT JOIN individual_role ON (game_individual.individual_role_id = individual_role.id)
            WHERE game_individual.game_id = ?",
            "i", $game_id
        );

        \AL\Db\bind_result(
            "GameIndividualDAO: getGameIndividualsForGame",
            $stmt,
            $game_individual_id,
            $game_id,
            $game_name,
            $individual_id,
            $individual_name,
            $role_id,
            $role_name
        );

        $game_individuals = [];
        while ($stmt->fetch()) {
            $game_individuals[] = new \AL\Common\Model\Game\GameIndividual(
                $game_individual_id,
                new \AL\Common\Model\Game\Game($game_id, $game_name),
                new \AL\Common\Model\Individual\Individual($individual_id, $individual_name),
                new \AL\Common\Model\Individual\IndividualRole($role_id, $role_name)
            );
        }

        $stmt->close();

        return $game_individuals;
    }
}

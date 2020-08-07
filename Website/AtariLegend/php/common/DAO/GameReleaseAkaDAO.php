<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Game/GameReleaseAka.php" ;
require_once __DIR__."/../Model/Language/Language.php" ;

/**
 * DAO for Game Releases AKAs
 */

class GameReleaseAkaDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }


    /* Get all Game Release AKA's
     *
     * @return \AL\Common\Model\Game\GameReleaseAka[] An array of AKAs
     */
    public function getAllGameReleaseAkas($game_release_id) {
        $stmt = \AL\Db\execute_query(
            "GameReleaseAkaDAO: getAllGameReleaseAkas",
            $this->mysqli,
            "SELECT game_release_aka.id, game_release_aka.game_release_id, game_release_aka.name,
            game_release_aka.language_id, language.name FROM game_release_aka
            LEFT JOIN language ON ( game_release_aka.language_id = language.id )
			 WHERE game_release_id = ?",
            "i", $game_release_id
        );

        \AL\Db\bind_result(
            "GameReleaseAkaDAO: getAllGameReleaseAkas",
            $stmt,
            $release_aka_id, $release_id, $name, $language_id, $language_name
        );

        $game_release_aka = [];
        while ($stmt->fetch()) {
            $game_release_aka[] = new \AL\Common\Model\Game\GameReleaseAka(
                $release_aka_id, $release_id, $name,
                new \AL\Common\Model\Language\Language($language_id, $language_name)
            );
        }

        $stmt->close();

        return $game_release_aka;
    }

    /**
     * update language_id for release AKA
     *
     * @param char language id
     * @param integer Game_release
     */
    public function updateLanguageForReleaseAka($language_id, $game_release_aka_id) {
        $stmt = \AL\Db\execute_query(
            "GameReleaseAkaDAO: UpdateLanguageForReleaseAka",
            $this->mysqli,
            "UPDATE game_release_aka SET language_id = ? WHERE id = ?",
            "si", $language_id, $game_release_aka_id
        );

        $stmt->close();
    }

    /**
     * Insert new AKA for release
     *
     * @param integer Game_release_id
     * @param varchar aka_name
     * @param char language_id
     *
     */
    public function addAkaForRelease($game_release_id, $name, $language_id) {
        $stmt = \AL\Db\execute_query(
            "GameReleaseAkaDAO: AddAkaForRelease",
            $this->mysqli,
            "INSERT INTO game_release_aka (game_release_id, name, language_id) VALUES (?,?,?)",
            "iss", $game_release_id, $name, $language_id
        );

        $stmt->close();
    }

     /**
     * Delete an AKA for a release
     *
     * @param integer Game_release_aka_id
     * @param integer Game_release_id
     *
     */
    public function deleteAkaForRelease($game_release_aka_id, $game_release_id) {
        $stmt = \AL\Db\execute_query(
            "GameReleaseAkaDAO: DeleteAkaForRelease",
            $this->mysqli,
            "DELETE FROM game_release_aka WHERE id = ? AND game_release_id = ?",
            "ii", $game_release_aka_id, $game_release_id
        );

        $stmt->close();
    }
}

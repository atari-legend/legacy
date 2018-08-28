<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Game/ProgrammingLanguage.php" ;

/**
 * DAO for programming languages
 */
class ProgrammingLanguageDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Get all programming languages
     *
     * @return \AL\Common\Model\Game\ProgrammingLanguage[] An array of languages
     */
    public function getAllProgrammingLanguages() {
        $stmt = \AL\Db\execute_query(
            "ProgrammingLanguageDAO: getAllProgrammingLanguages",
            $this->mysqli,
            "SELECT id, name FROM programming_language ORDER BY id",
            null, null
        );

        \AL\Db\bind_result(
            "ProgrammingLanguageDAO: getAllProgrammingLanguages",
            $stmt,
            $id, $name
        );

        $programming_languages = [];
        while ($stmt->fetch()) {
            $programming_languages[] = new \AL\Common\Model\Game\ProgrammingLanguage(
                $id, $name
            );
        }

        $stmt->close();

        return $programming_languages;
    }

    /**
     * Get list of programming_language IDs for a game
     *
     * @param integer Release ID
     */
    public function getProgrammingLanguagesForGame($game_id) {
        $stmt = \AL\Db\execute_query(
            "ProgrammingLanguageDAO: getProgrammingLanguagesForGame",
            $this->mysqli,
            "SELECT programming_language_id FROM game_programming_language WHERE game_id = ?",
            "i", $game_id
        );

        \AL\Db\bind_result(
            "ProgrammingLanguageDAO: getProgrammingLanguagesForGame",
            $stmt,
            $programming_language_id
        );

        $programming_languages = [];
        while ($stmt->fetch()) {
            $programming_languages[] = $programming_language_id;
        }

        $stmt->close();

        return $programming_languages;
    }
}

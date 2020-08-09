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
     * @param integer Game ID
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
            $programming_languages[] = new \AL\Common\Model\Game\ProgrammingLanguage(
                $programming_language_id, null
            );
        }

        $stmt->close();

        return $programming_languages;
    }
    
    /**
     * Set the list of programming languages for this game
     *
     * @param integer Game ID
     * @param integer[] List of programming language IDs
     */
    public function setProgrammingLanguageForGame($game_id, $programming_languages) {
        $stmt = \AL\Db\execute_query(
            "ProgrammingLanguageDAO: setProgrammingLanguageForGame",
            $this->mysqli,
            "DELETE FROM game_programming_language WHERE game_id = ?",
            "i", $game_id
        );

        foreach ($programming_languages as $id) {
            $stmt = \AL\Db\execute_query(
                "ProgrammingLanguageDAO: setProgrammingLanguageForGame",
                $this->mysqli,
                "INSERT INTO game_programming_language (game_id, programming_language_id) VALUES (?, ?)",
                "ii", $game_id, $id
            );
        }

        $stmt->close();
    }
    
    /**
     * add a programming language to the database
     *
     * @param varchar name
     */
    public function addProgrammingLanguage($name) {
        $stmt = \AL\Db\execute_query(
            "ProgrammingLanguageDAO: addProgrammingLanguage",
            $this->mysqli,
            "INSERT INTO programming_language (`name`) VALUES (?)",
            "s", $name
        );

        $stmt->close();
    }
    
    /**
     * delete a programming language
     *
     * @param int id
     */
    public function deleteProgrammingLanguage($id) {
        $stmt = \AL\Db\execute_query(
            "ProgrammingLanguageDAO: deleteProgrammingLanguage",
            $this->mysqli,
            "DELETE FROM programming_language WHERE id = ?",
            "i", $id
        );

        $stmt->close();
    }
    
    /**
     * update a programming language
     *
     * @param int id
     * @param varchar name
     */
    public function updateProgrammingLanguage($id, $name) {
        $stmt = \AL\Db\execute_query(
            "ProgrammingLanguageDAO: updateProgrammingLanguage",
            $this->mysqli,
            "UPDATE programming_language SET name = ? WHERE id = ?",
            "si", $name, $id
        );
        
        $stmt->close();
    }
}

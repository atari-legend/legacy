<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Language/Language.php" ;

/**
 * DAO for ports
 */
class LanguageDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Get all languages
     *
     * @return "/../Model/Language/Language[] An array of languages
     */
    public function getAllLanguages() {
        $stmt = \AL\Db\execute_query(
            "LanguageDAO: getAllLanguages",
            $this->mysqli,
            "SELECT id, name FROM language ORDER BY name",
            null, null
        );

        \AL\Db\bind_result(
            "LanguageDAO: getAllLanguages",
            $stmt,
            $id, $name
        );

        $languages = [];
        while ($stmt->fetch()) {
            $languages[] = new \AL\Common\Model\Language\Language(
                $id, $name
            );
        }

        $stmt->close();

        return $languages;
    }

    /* Get all Game Release languages
     *
     * @return "/../Model/Language/Language[] An array of languages
     */
    public function getReleaseLanguages($game_release_id) {
        $stmt = \AL\Db\execute_query(
            "LanguageDAO: getReleaseLanguages",
            $this->mysqli,
            "SELECT language.id, language.name FROM language
            LEFT JOIN game_release_language ON ( game_release_language.language_id = language.id )
			WHERE release_id = ?",
            "i", $game_release_id
        );

        \AL\Db\bind_result(
            "LanguageDAO: getReleaseLanguages",
            $stmt,
            $id, $name
        );

        $game_release_language = [];
        while ($stmt->fetch()) {
            $game_release_language[] = new \AL\Common\Model\Language\Language(
                $id, $name
            );
        }

        $stmt->close();

        return $game_release_language;
    }

    /**
     * Insert new language for release
     *
     * @param integer Game_release_id
     * @param char language_id
     *
     */
    public function addLanguageForRelease($game_release_id, $language_id) {
        $stmt = \AL\Db\execute_query(
            "LanguageDAO: addLanguageForRelease",
            $this->mysqli,
            "INSERT INTO game_release_language (release_id, language_id) VALUES (?,?)",
            "is", $game_release_id, $language_id
        );

        $stmt->close();
    }

    /**
     * Delete language from release
     *
     * @param integer Game_release_id
     * @param char language_id
     *
     */
    public function deleteLanguageFromRelease($game_release_id, $language_id) {
        $stmt = \AL\Db\execute_query(
            "LanguageDAO: deleteLanguageFromRelease",
            $this->mysqli,
            "DELETE FROM game_release_language WHERE release_id = ? and language_id = ?",
            "is", $game_release_id, $language_id
        );

        $stmt->close();
    }

    /**
     * delete a language
     *
     * @param int language_id
     */
    public function deleteLanguage($language_id) {
        $stmt = \AL\Db\execute_query(
            "LanguageDAO: deleteLanguage",
            $this->mysqli,
            "DELETE FROM language WHERE id = ?",
            "s", $language_id
        );

        $stmt->close();
    }

        /**
     * update a language
     *
     * @param int language_id
     * @param varchar language_name
     */
    public function updateLanguage($language_id, $language_name) {
        $stmt = \AL\Db\execute_query(
            "LanguageDAO: updateLanguage",
            $this->mysqli,
            "UPDATE language SET name = ? WHERE id = ?",
            "ss", $language_name, $language_id
        );

        $stmt->close();
    }
}

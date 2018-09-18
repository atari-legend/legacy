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

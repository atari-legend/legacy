<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Game/Tos.php" ;

/**
 * DAO for Tos versions
 */
class TosDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Get all Tos versions
     *
     * @return \AL\Common\Model\Game\Emulator[] An array of Tos versions
     */
    public function getAllTos() {
        $stmt = \AL\Db\execute_query(
            "TosDAO: getAllTos",
            $this->mysqli,
            "SELECT id, name FROM tos ORDER by name",
            null, null
        );

        \AL\Db\bind_result(
            "TosDAO: getAllTos",
            $stmt,
            $id, $name
        );

        $tos_versions = [];
        while ($stmt->fetch()) {
            $tos_versions[] = new \AL\Common\Model\Game\Tos(
                $id, $name, null
            );
        }

        $stmt->close();

        return $tos_versions;
    }

    /**
     * Get all TOS IDs incompatible with a release
     *
     * @param integer Release ID
     * @return integer[] List of incompatible TOS IDs
     */
    public function getIncompatibleTosForRelease($release_id) {
        $stmt = \AL\Db\execute_query(
            "TosDAO: getIncompatibleTosForRelease",
            $this->mysqli,
            "SELECT game_release_tos_version_incompatibility.id, 
                    game_release_tos_version_incompatibility.language_id, 
                    language.name 
            FROM game_release_tos_version_incompatibility LEFT JOIN language 
            ON (Language.id = game_release_tos_version_incompatibility.language_id) 
            WHERE release_id = ?",
            "i", $release_id
        );

        \AL\Db\bind_result(
            "TosDAO: getIncompatibleTosForRelease",
            $stmt,
            $tos_id, $language_id, $language_name
        );

        $tos_versions = [];
        while ($stmt->fetch()) {
            $tos_versions[] = new \AL\Common\Model\Game\Tos(
                $tos_id, null,
                new \AL\Common\Model\Language\Language($language_id, $language_name)
            );
        }

        $stmt->close();

        return $tos_versions;
    }
    
        
     /**
     * Get all tos IDs incompatible with a release
     *
     * @param integer Release ID
     * @return integer[] List of incompatible TOS IDs
     */
    public function getIncompatibleTosWithNameForRelease($release_id) {
        $stmt = \AL\Db\execute_query(
            "TosDAO: getIncompatibleTosWithNameForRelease",
            $this->mysqli,
            "SELECT game_release_tos_version_incompatibility.tos_id,
                    tos.name, game_release_tos_version_incompatibility.language_id, language.name 
                    FROM game_release_tos_version_incompatibility 
                    LEFT JOIN tos ON (game_release_tos_version_incompatibility.tos_id = tos.id)
                    LEFT JOIN language ON (Language.id = game_release_tos_version_incompatibility.language_id) 
                    WHERE release_id = ?",
            "i", $release_id
        );

        \AL\Db\bind_result(
            "TosDAO: getIncompatibleTosWithNameForRelease",
            $stmt,
            $tos_id, $tos_name, $language_id, $language_name
        );

        $tos_versions = [];
        while ($stmt->fetch()) {
            $tos_versions[] = new \AL\Common\Model\Game\Tos(
                $tos_id, $tos_name,
                new \AL\Common\Model\Language\Language($language_id, $language_name)
            );
        }

        $stmt->close();

        return $tos_versions;
    }

    /**
     * Set the list of tos versions a release is incompatible with
     *
     * @param integer Release ID
     * @param integer[] List of TOS IDs
     */
    public function setIncompatibleTosForRelease($release_id, $tos, $language) {

        $stmt = \AL\Db\execute_query(
            "TosDAO: setIncompatibleTosForRelease",
            $this->mysqli,
            "INSERT INTO game_release_tos_version_incompatibility (release_id, tos_id, language_id) VALUES (?, ?, ?)",
            "iis", $release_id, $tos, $language
        );

        $stmt->close();
    }
    
    
    /**
     * Update language for incompatible TOS
     *
     * @param integer Game Release ID
     * @param integer TOS ID
     */
    public function updateTosLanguageForRelease($game_release_id, $tos_id, $new_language_id) {
        $stmt = \AL\Db\execute_query(
            "TosDAO: updateTosLanguageForRelease",
            $this->mysqli,
            "UPDATE game_release_tos_version_incompatibility
            SET
                `language_id` = ?
            WHERE release_id = ? AND tos_id = ?",
            "sii", $new_language_id, $game_release_id, $tos_id
        );

        $stmt->close();
    }
    
    
    /**
     * Delete incompatible TOS for release
     *
     * @param integer Game Release ID
     * @param integer tos ID
     */
    public function deleteTosForRelease($game_release_id, $tos_id) {
        $stmt = \AL\Db\execute_query(
            "TosDAO: deleteTosForRelease",
            $this->mysqli,
            "DELETE FROM game_release_tos_version_incompatibility
            WHERE release_id = ? AND tos_id = ?",
            "ii", $game_release_id, $tos_id
        );

        $stmt->close();
    }
    
    
     /**
     * add a tos to the database
     *
     * @param varchar tos
     */
    public function addTos($tos) {
        $stmt = \AL\Db\execute_query(
            "TosDAO: addTos",
            $this->mysqli,
            "INSERT INTO tos (`name`) VALUES (?)",
            "s", $tos
        );

        $stmt->close();
    }
    
    /**
     * delete a tos version
     *
     * @param int tos_id
     */
    public function deleteTos($tos_id) {
        $stmt = \AL\Db\execute_query(
            "TosDAO: deleteTos",
            $this->mysqli,
            "DELETE FROM tos WHERE id = ?",
            "i", $tos_id
        );

        $stmt->close();
    }
    
     /**
     * update a tos version
     *
     * @param int tos_id
     * @param varchar tos_name
     */
    public function updateTos($tos_id, $tos_name) {
        $stmt = \AL\Db\execute_query(
            "TosDAO: updateTos",
            $this->mysqli,
            "UPDATE tos SET name = ? WHERE id = ?",
            "si", $tos_name, $tos_id
        );
        
        $stmt->close();
    }
}

<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Game/GameRelease.php" ;
require_once __DIR__."/../Model/PubDev/PubDev.php" ;

/**
 * DAO for Game Releases
 */
class GameReleaseDAO {
    private $mysqli;

    const LICENSE_COMMERCIAL = 'Commercial';
    const LICENSE_NON_COMMERCIAL = 'Non-Commercial';

    const TYPE_BUDGET = 'Budget';
    const TYPE_RERELEASE = 'Re-release';
    const TYPE_BUDGET_RERELEASE = 'Budget re-release';
    const TYPE_PLAYABLE_DEMO = 'Playable demo';
    const TYPE_NON_PLAYABLE_DEMO = 'Non-playable demo';
    const TYPE_SLIDESHOW = 'Slideshow';

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Get all the license types
     * @return String[] A list of license types
     */
    public function getLicenseTypes() {
        return array(
            GameReleaseDAO::LICENSE_COMMERCIAL,
            GameReleaseDAO::LICENSE_NON_COMMERCIAL
        );
    }

    /**
     * Get all the game release types
     * @return String[] A list of game release types
     */
    public function getTypes() {
        return array(
            GameReleaseDAO::TYPE_BUDGET,
            GameReleaseDAO::TYPE_RERELEASE,
            GameReleaseDAO::TYPE_BUDGET_RERELEASE,
            GameReleaseDAO::TYPE_PLAYABLE_DEMO,
            GameReleaseDAO::TYPE_NON_PLAYABLE_DEMO,
            GameReleaseDAO::TYPE_SLIDESHOW
        );
    }

    /**
     * Insert a release for a game
     *
     * @param  integer $game_id Id of the game the release is for
     * @param  string $name Alternative name for the release (optional)
     * @param  date $date Date of the release (optional)
     * @param string $license New license of the release
     * @param string $type New type of release
     * @param string $publisher_id New ID of the publisher of the release
     * @return integer ID of the inserted release
     */
    public function addReleaseForGame(
        $game_id,
        $name = null,
        $date = null,
        $license = null,
        $type = null,
        $publisher_id = null
    ) {

        $stmt = \AL\Db\execute_query(
            "GameReleaseDAO: addReleaseForGame",
            $this->mysqli,
            "INSERT INTO game_release
                (game_id, `name`, `date`, license, type, pub_dev_id)
            VALUES
                (?, ?, ?, ?, ?, ?)",
            "issssi", $game_id, $name, $date, $license, $type, $publisher_id
        );

        $id = $stmt->insert_id;

        $stmt->close();

        return $id;
    }

    /**
     * Get all the releases for a game
     * @param integer $game_id ID of the game to get releases for
     * @return \AL\Common\Model\Game\GameRelease[] An array of releases
     */
    public function getReleasesForGame($game_id) {
        $stmt = \AL\Db\execute_query(
            "GameRelaseDAO: getReleasesForGame",
            $this->mysqli,
            "SELECT
                game_release.id, game_release.name, `date`, license, game_release.type,
                pub_dev.pub_dev_id, pub_dev.pub_dev_name, pub_dev_text.pub_dev_profile, pub_dev_text.pub_dev_imgext
            FROM game_release
            LEFT JOIN pub_dev ON game_release.pub_dev_id = pub_dev.pub_dev_id
            LEFT JOIN pub_dev_text ON pub_dev.pub_dev_id = pub_dev_text.pub_dev_id
            WHERE game_id = ?
            ORDER BY date ASC",
            "i", $game_id
        );

        \AL\Db\bind_result(
            "GameRelaseDAO: getReleasesForGame",
            $stmt,
            $id, $name, $date, $license, $type,
            $pub_dev_id, $pub_dev_name, $pub_dev_profile, $pub_dev_imgext
        );

        $releases = [];
        while ($stmt->fetch()) {
            $releases[] = new \AL\Common\Model\Game\GameRelease(
                $id, $game_id, $name, $date, $license, $type,
                ($pub_dev_id != null)
                    ? new \AL\Common\Model\PubDev\PubDev($pub_dev_id, $pub_dev_name, $pub_dev_profile, $pub_dev_imgext)
                    : null
            );
        }

        $stmt->close();

        return $releases;
    }

    /**
     * Get a single release from its ID
     *
     * @param integer $release_id ID of the release to get
     * @return \AL\Common\Model\Game\GameRelease a release, or null if not found
     */
    public function getRelease($release_id) {
        $stmt = \AL\Db\execute_query(
            "GameReleaseDAO: getRelease: $release_id",
            $this->mysqli,
            "SELECT
                game_release.id, game_id, game_release.name, `date`, license, game_release.type,
                pub_dev.pub_dev_id, pub_dev.pub_dev_name, pub_dev_text.pub_dev_profile, pub_dev_text.pub_dev_imgext
            FROM game_release
            LEFT JOIN pub_dev ON game_release.pub_dev_id = pub_dev.pub_dev_id
            LEFT JOIN pub_dev_text ON pub_dev.pub_dev_id = pub_dev_text.pub_dev_id
            WHERE game_release.id = ?",
            "i", $release_id
        );

        \AL\Db\bind_result(
            "GameReleaseDAO: getRelease: $release_id",
            $stmt,
            $id, $game_id, $name, $date, $license, $type,
            $pub_dev_id, $pub_dev_name, $pub_dev_profile, $pub_dev_imgext
        );

        $release = null;
        if ($stmt->fetch()) {
            $release = new \AL\Common\Model\Game\GameRelease(
                $id, $game_id, $name, $date, $license, $type,
                ($pub_dev_id != null)
                    ? new \AL\Common\Model\PubDev\PubDev($pub_dev_id, $pub_dev_name, $pub_dev_profile, $pub_dev_imgext)
                    : null
            );
        }

        $stmt->close();

        return $release;
    }

    /**
     * Delete a release
     *
     * @param integer $release_id ID of the release to delete
     */
    public function deleteRelease($release_id) {
        // Delete linked data
        $stmt = \AL\Db\execute_query(
            "GameRelaseDAO: deleteRelease",
            $this->mysqli,
            "DELETE FROM game_release_resolution WHERE game_release_id = ?",
            "i", $release_id
        );
        $stmt = \AL\Db\execute_query(
            "GameRelaseDAO: deleteRelease",
            $this->mysqli,
            "DELETE FROM game_release_system_enhanced WHERE game_release_id = ?",
            "i", $release_id
        );
        $stmt = \AL\Db\execute_query(
            "GameRelaseDAO: deleteRelease",
            $this->mysqli,
            "DELETE FROM game_release_system_incompatible WHERE game_release_id = ?",
            "i", $release_id
        );
        $stmt = \AL\Db\execute_query(
            "GameRelaseDAO: deleteRelease",
            $this->mysqli,
            "DELETE FROM game_release_location WHERE game_release_id = ?",
            "i", $release_id
        );
        $stmt = \AL\Db\execute_query(
            "GameRelaseDAO: deleteRelease",
            $this->mysqli,
            "DELETE FROM game_release WHERE id = ?",
            "i", $release_id
        );

        $stmt->close();
    }

    /**
     * Update the base attributes of a release
     *
     * @param integer $release_id ID of the release to update
     * @param string $name New name of the release
     * @param string $date New date of the release
     * @param string $license New license of the release
     * @param string $type New type of release
     * @param string $publisher_id New ID of the publisher of the release
     */
    public function updateRelease($release_id, $name, $date, $license, $type, $publisher_id) {
        $stmt = \AL\Db\execute_query(
            "GameReleaseDAO: updateRelease",
            $this->mysqli,
            "UPDATE game_release
            SET
                `name` = ?,
                `date` = ?,
                `license` = ?,
                `type` = ?,
                `pub_dev_id` = ?
            WHERE id = ?",
            "ssssii", $name, $date, $license, $type, $publisher_id, $release_id
        );

        $stmt->close();
    }

    /**
     * Get all the distinct release years we have in the DB
     *
     * @return integer[] List of years
     */
    public function getAllReleasesYears() {
        $stmt = \AL\Db\execute_query(
            "GameReleaseDAO: getAllReleasesYears",
            $this->mysqli,
            "SELECT DISTINCT YEAR(`date`) FROM game_release
            WHERE `date` IS NOT NULL
            ORDER by `date` ASC",
            null, null
        );

        \AL\Db\bind_result(
            "GameRelaseDAO: getAllReleases",
            $stmt,
            $year
        );

        $years = [];
        while ($stmt->fetch()) {
            $years[] = $year;
        }

        $stmt->close();

        return $years;
    }
}

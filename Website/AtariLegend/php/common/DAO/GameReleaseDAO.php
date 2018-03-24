<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Game/GameRelease.php" ;

/**
 * DAO for Game Releases
 */
class GameReleaseDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Insert a release for a game
     *
     * @param  integer $game_id Id of the game the release is for
     * @param  string $name Alternative name for the release (optional)
     * @param  date $date Date of the release (optional)
     * @return integer ID of the inserted release
     */
    public function addReleaseForGame($game_id, $name = null, $date = null) {
        $stmt = \AL\Db\execute_query(
            "GameReleaseDAO: addReleaseForGame",
            $this->mysqli,
            "INSERT INTO game_release (game_id, `name`, `date`) VALUES (?, ?, ?)",
            "iss", $game_id, $name, $date
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
            "SELECT id, `name`, `date` FROM game_release WHERE game_id = ?",
            "i", $game_id
        );

        \AL\Db\bind_result(
            "GameRelaseDAO: getReleasesForGame",
            $stmt,
            $id, $name, $date
        );

        $releases = [];
        while ($stmt->fetch()) {
            $releases[] = new \AL\Common\Model\Game\GameRelease(
                $id, $game_id, $name, $date
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
            "SELECT id, game_id, `name`, `date` FROM game_release WHERE id = ?",
            "i", $release_id
        );

        \AL\Db\bind_result(
            "GameReleaseDAO: getRelease: $release_id",
            $stmt,
            $id, $game_id, $name, $date
        );

        $release = null;
        if ($stmt->fetch()) {
            $release = new \AL\Common\Model\Game\GameRelease(
                $id, $game_id, $name, $date
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
        $stmt = \AL\Db\execute_query(
            "GameRelaseDAO: deleteRelease",
            $this->mysqli,
            "DELETE FROM game_release WHERE id = ?",
            "i", $release_id
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

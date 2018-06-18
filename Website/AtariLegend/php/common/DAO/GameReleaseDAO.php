<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Game/GameRelease.php" ;

/**
 * DAO for Game Releases
 */
class GameReleaseDAO {
    private $mysqli;

    const LICENSE_COMMERCIAL = 'Commercial';
    const LICENSE_NON_COMMERCIAL = 'Non-Commercial';

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
            "SELECT id, `name`, `date`, license FROM game_release WHERE game_id = ?",
            "i", $game_id
        );

        \AL\Db\bind_result(
            "GameRelaseDAO: getReleasesForGame",
            $stmt,
            $id, $name, $date, $license
        );

        $releases = [];
        while ($stmt->fetch()) {
            $releases[] = new \AL\Common\Model\Game\GameRelease(
                $id, $game_id, $name, $date, $license
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
            "SELECT id, game_id, `name`, `date`, license FROM game_release WHERE id = ?",
            "i", $release_id
        );

        \AL\Db\bind_result(
            "GameReleaseDAO: getRelease: $release_id",
            $stmt,
            $id, $game_id, $name, $date, $license
        );

        $release = null;
        if ($stmt->fetch()) {
            $release = new \AL\Common\Model\Game\GameRelease(
                $id, $game_id, $name, $date, $license
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
     */
    public function updateRelease($release_id, $name, $date, $license) {
        $stmt = \AL\Db\execute_query(
            "GameReleaseDAO: updateRelease",
            $this->mysqli,
            "UPDATE game_release
            SET `name` = ?, `date` = ?, license = ?
            WHERE id = ?",
            "sssi", $name, $date, $license, $release_id
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

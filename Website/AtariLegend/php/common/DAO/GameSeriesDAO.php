<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Game/GameSeries.php" ;
require_once __DIR__."/../Model/Game/Game.php" ;

/**
 * DAO for GamesSeries
 */
class GameSeriesDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Get all game series
     * @return \AL\Common\Model\Game\GameSeries[] All game series
     */
    public function getAllGameSeries() {
        $stmt = \AL\Db\execute_query(
            "GameSeriesDAO: getAllGameSeries",
            $this->mysqli,
            "SELECT id, name FROM game_series ORDER BY name ASC",
            null, null
        );

        \AL\Db\bind_result(
            "GameSeriesDAO: getAllGameSeries",
            $stmt,
            $id, $name
        );

        $game_series = [];
        while ($stmt->fetch()) {
            $game_series[] = new \AL\Common\Model\Game\GameSeries($id, $name);
        }

        $stmt->close();

        return $game_series;
    }

    /**
     * Get a single game series
     * @param number $game_series_id ID of the game series to retrieve
     * @return \AL\Common\Model\Game\GameSeries The game series
     */
    public function getGameSeries($game_series_id) {
        $stmt = \AL\Db\execute_query(
            "GameSeriesDAO: getGameSeries: $game_series_id",
            $this->mysqli,
            "SELECT id, name FROM game_series WHERE id = ?",
            "i", $game_series_id
        );

        \AL\Db\bind_result(
            "GameSeriesDAO: getGameSeries: $game_series_id",
            $stmt,
            $id, $name
        );

        $game_series = null;
        if ($stmt->fetch()) {
            $game_series = new \AL\Common\Model\Game\GameSeries($id, $name);
        }

        $stmt->close();

        return $game_series;
    }

    /**
     * Get all the games for a series
     * @param number $game_series_id ID of series to get games from
     * @return \AL\Common\Model\Game\Game[] List of games
     */
    public function getGamesForSeries($game_series_id) {
        $stmt = \AL\Db\execute_query(
            "GameSeriesDAO: getGamesForSeries: $game_series_id",
            $this->mysqli,
            "SELECT game_id, game_name, game_series_id
            FROM game
            WHERE game_series_id = ?
            ORDER BY game_name ASC",
            "i", $game_series_id
        );

        \AL\Db\bind_result(
            "GameSeriesDAO: getGamesForSeries: $game_series_id",
            $stmt,
            $game_id, $game_name, $game_series_id
        );

        $games = [];
        while ($stmt->fetch()) {
            $games[] = new \AL\Common\Model\Game\Game(
                $game_id, $game_name, $game_series_id
            );
        }

        $stmt->close();

        return $games;
    }

    /**
     * Update a game series
     *
     * @param integer $id ID of the series to update
     * @param string $name New name of the series
     */
    public function updateGameSeries($id, $name) {
        $stmt = \AL\Db\execute_query(
            "GameSeriesDAO: updateGameSeries: $id",
            $this->mysqli,
            "UPDATE game_series
            SET `name` = ?
            WHERE id = ?",
            "si", $name, $id
        );

        $stmt->close();
    }

    /**
     * Delete a game series
     *
     * @param integer $id ID of the series to delete
     */
    public function deleteGameSeries($id) {
        // Unlink all games from this series
        $stmt = \AL\Db\execute_query(
            "GameSeriesDAO: deleteGameSeries: $id",
            $this->mysqli,
            "UPDATE game SET game_series_id = NULL WHERE game_series_id = ?",
            "i", $id
        );

        $stmt->close();

        $stmt = \AL\Db\execute_query(
            "GameSeriesDAO: deleteGameSeries: $id",
            $this->mysqli,
            "DELETE FROM game_series WHERE id = ?",
            "i", $id
        );

        $stmt->close();
    }

    /**
     * Insert a new series
     *
     * @param \AL\Common\Model\Game\GameSeries $game_series Series to add
     * @return integer ID of the inserted game series
     */
    public function addGameSeries($game_series) {
        $stmt = \AL\Db\execute_query(
            "GameSeriesDAO: addGameSeries",
            $this->mysqli,
            "INSERT INTO game_series (name) VALUES (?)",
            "s", $game_series->getName()
        );

        $id = $stmt->insert_id;

        $stmt->close();

        return $id;
    }

    /**
     * Add a game to a series
     *
     * @param integer $series_id ID of the series
     * @param integer $game_id ID of the game
     */
    public function addGameToSeries($series_id, $game_id) {
        $stmt = \AL\Db\execute_query(
            "GameSeriesDAO: addGameToSeries",
            $this->mysqli,
            "UPDATE game SET game_series_id = ? WHERE game_id = ?",
            "ii", $series_id, $game_id
        );

        $stmt->close();
    }

    /**
     * Remove a game from a series
     *
     * @param integer $game_id IDs of the game to remove
     */
    public function removeGameFromSeries($game_id) {
        $stmt = \AL\Db\execute_query(
            "GameSeriesDAO: removeGameFromSeries",
            $this->mysqli,
            "UPDATE game
            SET game_series_id = NULL
            WHERE game_id = ?",
            "i", $game_id
        );

        $stmt->close();
    }
}

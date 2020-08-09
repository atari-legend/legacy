<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Game/GameGenre.php" ;

/**
 * DAO for game genres
 */
class GameGenreDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Get all Game Genres
     *
     * @return \AL\Common\Model\Game\GameGenres[] An array of genres
     */
    public function getAllGameGenres() {
        $stmt = \AL\Db\execute_query(
            "GameGenreDAO: getAllGameGenres",
            $this->mysqli,
            "SELECT id, name FROM game_genre ORDER BY name",
            null, null
        );

        \AL\Db\bind_result(
            "GameGenreDAO: getAllGameGenres",
            $stmt,
            $id, $name
        );

        $game_genres = [];
        while ($stmt->fetch()) {
            $game_genres[] = new \AL\Common\Model\Game\GameGenre(
                $id, $name
            );
        }

        $stmt->close();

        return $game_genres;
    }

    /**
     * Get list of game_genre IDs for a game
     *
     * @param integer Game ID
     */
    public function getGameGenresForGame($game_id) {
        $stmt = \AL\Db\execute_query(
            "GameGenreDAO: getGameGenresForGame",
            $this->mysqli,
            "SELECT game_genre_id, name
            FROM game_genre_cross LEFT JOIN game_genre ON (game_genre_cross.game_genre_id = game_genre.id)
            WHERE game_id = ?",
            "i", $game_id
        );

        \AL\Db\bind_result(
            "GameGenreDAO: getGameGenresForGame",
            $stmt,
            $game_genre_id, $name
        );

        $game_genres = [];
        while ($stmt->fetch()) {
            $game_genres[] = new \AL\Common\Model\Game\GameGenre(
                $game_genre_id, $name
            );
        }

        $stmt->close();

        return $game_genres;
    }
    
    /**
     * Set the list of game genres for this game
     *
     * @param integer Game ID
     * @param integer[] List of game genre IDs
     */
    public function setGameGenreForGame($game_id, $game_genre_id) {
        $stmt = \AL\Db\execute_query(
            "GameGenreDAO: setGameGenreForGame",
            $this->mysqli,
            "DELETE FROM game_genre_cross WHERE game_id = ?",
            "i", $game_id
        );

        foreach ($game_genre_id as $id) {
            $stmt = \AL\Db\execute_query(
                "GameGenreDAO: setGameGenreForGame",
                $this->mysqli,
                "INSERT INTO game_genre_cross (game_id, game_genre_id) VALUES (?, ?)",
                "ii", $game_id, $id
            );
        }

        $stmt->close();
    }
     
     /**
     * add a genre to the database
     *
     * @param varchar Genre
     */
    public function addGenre($genre) {
        $stmt = \AL\Db\execute_query(
            "GameGenreDAO: addGenre",
            $this->mysqli,
            "INSERT INTO game_genre (`name`) VALUES (?)",
            "s", $genre
        );

        $stmt->close();
    }
    
    /**
     * delete a genre
     *
     * @param int genre_id
     */
    public function deleteGenre($genre_id) {
        $stmt = \AL\Db\execute_query(
            "GameGenreDAO: deleteGenre",
            $this->mysqli,
            "DELETE FROM game_genre WHERE id = ?",
            "i", $genre_id
        );

        $stmt->close();
    }
    
        /**
     * update a genre
     *
     * @param int genre_id
     * @param varchar genre_name
     */
    public function updateGenre($genre_id, $genre_name) {
        $stmt = \AL\Db\execute_query(
            "GameGenreDAO: updateGenre",
            $this->mysqli,
            "UPDATE game_genre SET name = ? WHERE id = ?",
            "si", $genre_name, $genre_id
        );
        
        $stmt->close();
    }
}

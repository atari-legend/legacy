<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php";
require_once __DIR__."/../Model/Crew/Crew.php";

/**
 * DAO for Crew
 */
class CrewDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }
    
    public function getAllCrews() {
        return $this->getCrewsStartingWith(".");
    }

    /**
     * Search for crews
     * @param string $search_string can either be a single letter or "num" which represents numbers
     * @return \AL\Common\Model\Crew\Crew[] A list of crews
     */
    public function getCrewsStartingWith($search_string) {
        if (isset($search_string) and $search_string == "num") {
            $search_string = "^[0-9]";
        } else {
            $search_string = "^$search_string";
        }

        $stmt = \AL\Db\execute_query(
            "CrewDAO: getCrewsStartingWith",
            $this->mysqli,
            "SELECT crew_id, crew_name FROM crew
            WHERE LOWER(crew_name) REGEXP ? ORDER BY crew_name ASC",
            "s",
            strtolower($search_string)
        );

        \AL\Db\bind_result(
            "CrewDAO: getCrewsStartingWith",
            $stmt,
            $crew_id,
            $crew_name
        );

        $crews = [];
        while ($stmt->fetch()) {
            $crews[] = new \AL\Common\Model\Crew\Crew(
                $crew_id,
                $crew_name
            );
        }

        $stmt->close();

        return $crews;
    }

    /**
     * Get a specific crew
     * @param number $crew_id ID of the crew to retrieve
     * @return \AL\Common\Model\Crew\Crew The crew, or NULL if not found
     */
    public function getCrew($crew_id) {
        $stmt = \AL\Db\execute_query(
            "CrewDAO: getCrew: $crew_id",
            $this->mysqli,
            "SELECT crew_id, crew_name FROM crew WHERE crew_id = ?",
            "i",
            $crew_id
        );

        \AL\Db\bind_result(
            "CrewDAO: getCrew: $crew_id",
            $stmt,
            $crew_id,
            $crew_name
        );

        $crew = null;
        if ($stmt->fetch()) {
            $crew = new \AL\Common\Model\Crew\Crew(
                $crew_id,
                $crew_name
            );
        }

        $stmt->close();

        return $crew;
    }

    /**
     * Add new Crew
     * @param string $new_crew_name Name of the new crew to add
     * @return \AL\Common\Model\Crew\Crew The crew, or NULL if not found
     */
    public function addCrew($new_crew_name) {
        $stmt = \AL\Db\execute_query(
            "CrewDAO: addCrew: $new_crew_name",
            $this->mysqli,
            "INSERT INTO crew (crew_name) VALUES (?)",
            "s",
            $new_crew_name
        );

        $new_crew_id = $stmt->insert_id;

        $stmt->close();

        return $new_crew_id;
    }
    
    /**
     * Get list of crews for a game_release
     *
     * @param integer release ID
     */
    public function getCrewsForRelease($game_release_id) {
        $stmt = \AL\Db\execute_query(
            "CrewsDAO: getCrewsForRelease",
            $this->mysqli,
            "SELECT
                crew.crew_id,
                crew.crew_name
            FROM
                crew
            LEFT JOIN game_release_crew ON crew.crew_id = game_release_crew.crew_id
            WHERE game_release_crew.game_release_id = ?",
            "i", $game_release_id
        );

        \AL\Db\bind_result(
            "CrewsDAO: getCrewsForRelease",
            $stmt,
            $id, $name
        );

        $crews = [];
        while ($stmt->fetch()) {
            $crews[] = new \AL\Common\Model\Crew\Crew(
                $id, $name
            );
        }

        $stmt->close();

        return $crews;
    }
    
     /**
     * add a crew to a release
     *
     * @param integer release ID
     * @param integer crew ID
     */
    public function addCrewToRelease($release_id, $crew_id) {
        $stmt = \AL\Db\execute_query(
            "CrewDAO: addCrewToRelease",
            $this->mysqli,
            "INSERT INTO game_release_crew (game_release_id, crew_id) VALUES (?, ?)",
            "ii", $release_id, $crew_id
        );

        $stmt->close();
    }
        
    /**
     * delete a crew from a release
     *
     * @param int release_id
     * @param int crew_id
     */
    public function deleteCrewFromRelease($release_id, $crew_id) {
        $stmt = \AL\Db\execute_query(
            "CrewDAO: deleteCrewFromRelease",
            $this->mysqli,
            "DELETE FROM game_release_crew WHERE game_release_id = ? and crew_id = ?",
            "ii", $release_id, $crew_id
        );

        $stmt->close();
    }
}

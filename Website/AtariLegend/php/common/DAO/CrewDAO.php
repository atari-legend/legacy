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

    /**
     * Get all Crews
     * @return \AL\Common\Model\Crew\Crew[] A list of crews
     */
    public function getAllCrews() {
        $stmt = \AL\Db\execute_query(
            "CrewDAO: getAllCrews",
            $this->mysqli,
            "SELECT crew_id, crew_name FROM crew ORDER BY crew_name ASC",
            null,
            null
        );

        \AL\Db\bind_result(
            "CrewDAO: getAllCrews",
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
     * Search for crews
     * @return \AL\Common\Model\Crew\Crew[] A list of crews
     */
    public function getCrewsStartingWith($search_string) {
        if (isset($search_string) and $search_string == "num") {
            $crewbrowse = " WHERE crew_name REGEXP '^[0-9].*'";
        } else {
            $crewbrowse = " WHERE crew_name LIKE '$search_string%'";
        }

        $stmt = \AL\Db\execute_query(
            "CrewDAO: getCrewsStartingWith",
            $this->mysqli,
            "SELECT crew_id, crew_name FROM crew". $crewbrowse ." ORDER BY crew_name ASC",
            null,
            null
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
}

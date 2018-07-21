<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Continent/Continent.php" ;

/**
 * DAO for Continent
 */
class ContinentDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Get all the continents
     * @return \AL\Common\Model\Continent\Continent[] An array of Continents
     */
    public function getAllContinents() {
        $stmt = \AL\Db\execute_query(
            "ContinentDAO: getAllContinents",
            $this->mysqli,
            "SELECT continent_id, continent_name
            FROM continent
            ORDER BY continent_id ASC",
            null, null
        );

        \AL\Db\bind_result(
            "ContinentDAO: getAllContinents",
            $stmt,
            $id, $name
        );

        $continents = [];
        while ($stmt->fetch()) {
            $continents[] = new \AL\Common\Model\Continent\Continent(
                $id,
                $name
            );
        }

        $stmt->close();

        return $continents;
    }
}

<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Individual/Individual.php" ;

/**
 * DAO for Individual
 */
class IndividualDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Get all individuals
     * @return \AL\Common\Model\Individual\Individual[] A list of individuals
     */
    public function getAllIndividuals() {
        $stmt = \AL\Db\execute_query(
            "IndividualDAO: getAllIndividuals",
            $this->mysqli,
            "SELECT ind_id, ind_name FROM individuals ORDER BY ind_name ASC",
            null, null
        );

        \AL\Db\bind_result(
            "IndividualDAO: getAllIndividuals",
            $stmt,
            $id, $name
        );

        $individuals = [];
        while ($stmt->fetch()) {
            $individuals[] = new \AL\Common\Model\Individual\Individual(
                $id, $name
            );
        }

        $stmt->close();

        return $individuals;
    }

    /**
     * Get a specific individual
     * @param number $id ID of the individual to retrieve
     * @return \AL\Common\Model\Individual\Individual The individual, or NULL if not found
     */
    public function getIndividual($id) {
        $stmt = \AL\Db\execute_query(
            "IndividualDAO: getIndividual: $id",
            $this->mysqli,
            "SELECT ind_id, ind_name FROM individuals WHERE ind_id = ?",
            "i", $id
        );

        \AL\Db\bind_result(
            "IndividualDAO: getIndividual: $id",
            $stmt,
            $id, $name
        );

        $individual = null;
        if ($stmt->fetch()) {
            $individual = new \AL\Common\Model\Individual\Individual(
                $id, $name
            );
        }

        $stmt->close();

        return $individual;
    }
}

<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php";
require_once __DIR__."/../Model/Menus/MenuSetsList.php";
require_once __DIR__."/../Model/Crew/Crew.php";
require_once __DIR__."/../Model/Individual/Individual.php";

/**
 * DAO for Comments
 */
class MenuSetDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Get the SQL query to get the list of Menudisk sets,
     */
    public function getMenuSetListQuery($menu_sets_id = null) {
        $query = "SELECT
            menu_set.menu_sets_id,
            menu_set.menu_sets_name,
            (SELECT COUNT(*) FROM menu_disk WHERE menu_disk.menu_sets_id=menu_set.menu_sets_id) AS menu_disk_count,
            crew.crew_id,
            crew.crew_name,
            individuals.ind_id,
            individuals.ind_name,
            menu_types_main.menu_types_text
            FROM menu_set
            LEFT JOIN crew_menu_prod ON (menu_set.menu_sets_id = crew_menu_prod.menu_sets_id)
            LEFT JOIN crew ON (crew_menu_prod.crew_id = crew.crew_id)
            LEFT JOIN ind_menu_prod ON (menu_set.menu_sets_id = ind_menu_prod.menu_sets_id)
            LEFT JOIN individuals ON (ind_menu_prod.ind_id = individuals.ind_id)
            LEFT JOIN menu_type ON (menu_set.menu_sets_id = menu_type.menu_sets_id)
            LEFT JOIN menu_types_main ON (menu_type.menu_types_main_id = menu_types_main.menu_types_main_id)";

        if (isset($menu_sets_id)) {
            $query .= " WHERE menu_set.menu_sets_id = ?";
        }

        $query .= " ORDER BY menu_sets_name ASC";

        return $query;
    }

    /**
     * Get list of Menu sets
     */
    public function getMenuSets() {

        // Query Menu Sets
        $stmt = \AL\Db\execute_query(
            "MenusDAO: getMenuSets",
            $this->mysqli,
            $this->getMenuSetListQuery(),
            null,
            null
        );

        \AL\Db\bind_result(
            "MenusDAO: getMenuSets",
            $stmt,
            $menu_sets_id,
            $menu_sets_name,
            $menu_disk_count,
            $crew_id,
            $crew_name,
            $ind_id,
            $ind_name,
            $menu_types_text
        );

        $menusets = [];
        while ($stmt->fetch()) {
            $menusets[] = new \AL\Common\Model\Menus\MenuSetsList(
                $menu_sets_id,
                $menu_sets_name,
                $menu_disk_count,
                ($crew_id != null)
                    ? new \AL\Common\Model\Crew\Crew($crew_id, $crew_name)
                    : null,
                ($ind_id != null)
                    ? new \AL\Common\Model\Individual\Individual($ind_id, $ind_name)
                    : null,
                $menu_types_text
            );
        }

        $stmt->close();

        return $menusets;
    }

    /**
     * Get Information of specific menu set
     */
    public function getMenuSetInfo($menu_sets_id) {

        // Query Menu Sets
        $stmt = \AL\Db\execute_query(
            "MenusSetDAO: getMenuSetInfo",
            $this->mysqli,
            $this->getMenuSetListQuery($menu_sets_id),
            "i",
            $menu_sets_id
        );

        \AL\Db\bind_result(
            "MenusSetDAO: getMenuSetInfo",
            $stmt,
            $menu_sets_id,
            $menu_sets_name,
            $menu_disk_count,
            $crew_id,
            $crew_name,
            $ind_id,
            $ind_name,
            $menu_types_text
        );

        $menusets = null;
        if ($stmt->fetch()) {
            $menusets = new \AL\Common\Model\Menus\MenuSetsList(
                $menu_sets_id,
                $menu_sets_name,
                $menu_disk_count,
                ($crew_id != null)
                    ? new \AL\Common\Model\Crew\Crew($crew_id, $crew_name)
                    : null,
                ($ind_id != null)
                    ? new \AL\Common\Model\Individual\Individual($ind_id, $ind_name)
                    : null,
                $menu_types_text
            );
        }

        $stmt->close();

        return $menusets;
    }

    /**
     * Get crews connected to Menu Set
     * @return \AL\Common\Model\Crew\Crew[] A list of crews
     */
    public function getCrewsForMenuSet($menu_sets_id) {
        $stmt = \AL\Db\execute_query(
            "MenuSetDAO: getCrewsForMenuSet",
            $this->mysqli,
            "SELECT
                crew.crew_id,
                crew.crew_name
                FROM crew_menu_prod
                LEFT JOIN crew ON (crew_menu_prod.crew_id = crew.crew_id)
                WHERE crew_menu_prod.menu_sets_id = ? ORDER BY crew.crew_name ASC",
            "i",
            $menu_sets_id
        );

        \AL\Db\bind_result(
            "MenuSetDAO: getCrewsForMenuSet",
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
     * Get a list of individuals connected to menu set
     * @param number $menu_sets_id ID of the menu set which we want individuals from
     * @return \AL\Common\Model\Individual\Individual The individual, or NULL if not found
     */
    public function getIndividualsForMenuSet($menu_sets_id) {
        $stmt = \AL\Db\execute_query(
            "MenuSetDAO: getIndividualsForMenuSet: $menu_sets_id",
            $this->mysqli,
            "SELECT
                individuals.ind_id,
                individuals.ind_name
                FROM ind_menu_prod
                LEFT JOIN individuals ON (ind_menu_prod.ind_id = individuals.ind_id)
                WHERE ind_menu_prod.menu_sets_id = ? ORDER BY individuals.ind_name ASC",
            "i",
            $menu_sets_id
        );

        \AL\Db\bind_result(
            "MenuSetDAO: getIndividualsForMenuSet: $menu_sets_id",
            $stmt,
            $id,
            $name
        );

        $individuals = [];
        while ($stmt->fetch()) {
            $individuals[] = new \AL\Common\Model\Individual\Individual(
                $id,
                $name
            );
        }

        $stmt->close();

        return $individuals;
    }

    /**
     * Connect crew to menu set
     * @param number $crew_id_primary key of crew table
     * @param number $menu_sets_id primary key of menu sets table
     */
    public function addCrewToMenuSet($crew_id, $menu_sets_id) {
        $stmt = \AL\Db\execute_query(
            "MenuSetDAO: addCrewToMenuSet: ",
            $this->mysqli,
            "INSERT INTO crew_menu_prod (crew_id,menu_sets_id) VALUES (?,?)",
            "ii",
            $crew_id,
            $menu_sets_id
        );

        $stmt->close();
    }

    /**
     * Connect individual to menu set
     * @param number $ind_id_primary key of individual table
     * @param number $menu_sets_id primary key of menu sets table
     */
    public function addIndividualToMenuSet($ind_id, $menu_sets_id) {
        $stmt = \AL\Db\execute_query(
            "MenuSetDAO: addIndividualToMenuSet: ",
            $this->mysqli,
            "INSERT INTO ind_menu_prod (ind_id,menu_sets_id) VALUES (?,?)",
            "ii",
            $ind_id,
            $menu_sets_id
        );

        $stmt->close();
    }

    /**
     * Add new Menu Set
     * @param string $menu_sets_name Name of new menu set
     * @return new primary key
     */
    public function addNewMenuSet($menu_sets_name) {
        $stmt = \AL\Db\execute_query(
            "MenuSetDAO: addNewMenuSet: $menu_sets_name",
            $this->mysqli,
            "INSERT INTO menu_set (menu_sets_name) VALUES (?)",
            "s",
            $menu_sets_name
        );

        $new_menu_set_id = $stmt->insert_id;

        $stmt->close();

        return $new_menu_set_id;
    }

    /**
     * Update Name of menu set
     *
     * @param  integer $menu_sets_id ID of the menu set
     * @param  text $menu_sets_name the new name of the menu set
     */
    public function updateMenuSetName($menu_sets_id, $menu_sets_name) {
        if (isset($menu_sets_name)) {
            $stmt = \AL\Db\execute_query(
                "MenuSetDAO: updateMenuSetName $menu_sets_name",
                $this->mysqli,
                "UPDATE menu_set SET `menu_sets_name` = ? WHERE menu_sets_id=?",
                "si",
                $menu_sets_name,
                $menu_sets_id
            );
        }
        $stmt->close();
    }

    /**
     * Connect menu type to menu set
     * @param integer $menu_types_main_id id of menu types
     * @param integer $menu_sets_id id of menu set
     */
    public function addMenuTypeToMenuSet($menu_types_main_id, $menu_sets_id) {
        $stmt = \AL\Db\execute_query(
            "MenuSetDAO: addMenuTypeToMenuSet",
            $this->mysqli,
            "INSERT INTO menu_type (menu_types_main_id,menu_sets_id) VALUES (?,?)",
            "ii",
            $menu_types_main_id,
            $menu_sets_id
        );

        $stmt->close();
    }

    /**
     * Remove crew from menu set
     * @param integer $crew_id id of crew
     * @param integer $menu_sets_id id of menu set
     */
    public function removeCrewFromMenuSet($crew_id, $menu_sets_id) {
        $stmt = \AL\Db\execute_query(
            "MenuSetDAO: removeCrewFromMenuSet",
            $this->mysqli,
            "DELETE FROM crew_menu_prod WHERE crew_id=? AND menu_sets_id=?",
            "ii",
            $crew_id,
            $menu_sets_id
        );

        $stmt->close();
    }

    /**
     * Remove menu type from menu set
     * @param integer $menu_type_id id of menu type
     * @param integer $menu_sets_id id of menu set
     */
    public function removeMenuTypeFromMenuSet($menu_type_id, $menu_sets_id) {
        $stmt = \AL\Db\execute_query(
            "MenuSetDAO: removeMenuTypeFromMenuSet",
            $this->mysqli,
            "DELETE FROM menu_type WHERE menu_types_main_id=? AND menu_sets_id=?",
            "ii",
            $menu_type_id,
            $menu_sets_id
        );

        $stmt->close();
    }

    /**
     * Remove individual from menu set
     * @param integer $ind_id id of individual
     * @param integer $menu_sets_id id of menu set
     */
    public function removeIndividualFromMenuSet($ind_id, $menu_sets_id) {
        $stmt = \AL\Db\execute_query(
            "MenuSetDAO: removeCrewFromMenuSet",
            $this->mysqli,
            "DELETE FROM ind_menu_prod WHERE ind_id=? AND menu_sets_id=?",
            "ii",
            $ind_id,
            $menu_sets_id
        );

        $stmt->close();
    }
}

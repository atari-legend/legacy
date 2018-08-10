<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php";
require_once __DIR__."/../Model/Menus/MenuSetsList.php";

/**
 * DAO for Comments
 */
class MenusSetDAO {
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
            $query .= " WHERE menu_set.menu_sets_id = $menu_sets_id";
        }

        $query .= " ORDER BY menu_sets_name ASC";

        return $query;
    }

    /**
     * Get list of Menu sets
     */
    public function getMenuSetsBuild() {

        // Query Menu Sets
        $stmt = \AL\Db\execute_query(
            "MenusDAO: getCommentsBuild",
            $this->mysqli,
            $this->getMenuSetListQuery(),
            null,
            null
        );

        \AL\Db\bind_result(
            "MenusDAO: getCommentsBuild",
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
                $crew_id,
                $crew_name,
                $ind_id,
                $ind_name,
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
            null,
            null
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
                $crew_id,
                $crew_name,
                $ind_id,
                $ind_name,
                $menu_types_text
            );
        }

        $stmt->close();

        return $menusets;
    }
}

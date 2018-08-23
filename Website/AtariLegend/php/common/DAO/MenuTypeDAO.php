<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php";
require_once __DIR__."/../Model/Menus/MenuType.php";

/**
 * DAO for Crew
 */
class MenuTypeDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Get all menu types
     * @return \AL\Common\Model\Menus\MenuType[] A list of Menu Types
     */
    public function getAllMenuTypes() {
        $stmt = \AL\Db\execute_query(
            "MenuTypeDAO: getAllMenuTypes",
            $this->mysqli,
            "SELECT menu_types_main_id, menu_types_text FROM menu_types_main",
            null,
            null
        );

        \AL\Db\bind_result(
            "MenuTypeDAO: getAllMenuTypes",
            $stmt,
            $menu_types_main_id,
            $menu_types_text
        );

        $types = [];
        while ($stmt->fetch()) {
            $types[] = new \AL\Common\Model\Menus\MenuType(
                $menu_types_main_id,
                $menu_types_text
            );
        }

        $stmt->close();

        return $types;
    }

    /**
     * Get all menu types connected to a specific menu set
     * @return \AL\Common\Model\Menus\MenuTypes[] A list of Menu Types
     */
    public function getMenuTypesForMenuSet($menu_sets_id) {
        $stmt = \AL\Db\execute_query(
            "MenuTypeDAO: getAllMenuTypes",
            $this->mysqli,
            "SELECT
                menu_types_main.menu_types_main_id,
                menu_types_main.menu_types_text
                FROM menu_types_main
                LEFT JOIN menu_type ON ( menu_type.menu_types_main_id =  menu_types_main.menu_types_main_id)
                WHERE menu_type.menu_sets_id = ?",
            "i",
            $menu_sets_id
        );

        \AL\Db\bind_result(
            "MenuTypeDAO: getAllMenuTypes",
            $stmt,
            $menu_types_main_id,
            $menu_types_text
        );

        $types = [];
        while ($stmt->fetch()) {
            $types[] = new \AL\Common\Model\Menus\MenuType(
                $menu_types_main_id,
                $menu_types_text
            );
        }

        $stmt->close();

        return $types;
    }
}

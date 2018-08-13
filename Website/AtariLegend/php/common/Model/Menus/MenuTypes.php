<?php
namespace AL\Common\Model\Menus;

/**
 * Maps to the `menu types` table
 */
class MenuTypes {
    private $menu_types_main_id;
    private $menu_types_text;

    public function __construct($menu_types_main_id, $menu_types_text) {
        $this->menu_types_main_id = $menu_types_main_id;
        $this->menu_types_text = $menu_types_text;
    }

    public function getTypeId() {
        return $this->menu_types_main_id;
    }

    public function getTypeName() {
        return $this->menu_types_text;
    }
}

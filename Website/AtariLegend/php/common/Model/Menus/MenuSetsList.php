<?php
namespace AL\Common\Model\Menus;

require_once __DIR__."/../../../config/config.php";

/**
 * Maps to the Menu Sets tables
 */
class MenuSetsList {
    private $menu_sets_id;
    private $menu_sets_name;
    private $menu_disk_count;
    private $crew_id;
    private $crew_name;
    private $ind_id;
    private $ind_name;
    private $menu_types_text;

    public function __construct(
        $menu_sets_id,
        $menu_sets_name,
        $menu_disk_count,
        $crew_id,
        $crew_name,
        $ind_id,
        $ind_name,
        $menu_types_text
    ) {
        $this->menu_sets_id = $menu_sets_id;
        $this->menu_sets_name = $menu_sets_name;
        $this->menu_disk_count = $menu_disk_count;
        $this->crew_id = $crew_id;
        $this->crew_name = $crew_name;
        $this->ind_id = $ind_id;
        $this->ind_name = $ind_name;
        $this->menu_types_text = $menu_types_text;
    }

    public function getMenuSetsId() {
        return $this->menu_sets_id;
    }

    public function getMenuSetsName() {
        return $this->menu_sets_name;
    }

    public function getMenuDiskCount() {
        return $this->menu_disk_count;
    }

    public function getCrewId() {
        return $this->crew_id;
    }

    public function getCrewName() {
        return $this->crew_name;
    }

    public function getIndId() {
        return $this->ind_id;
    }

    public function getIndName() {
        return $this->ind_name;
    }

    public function getMenuTypesText() {
        return $this->menu_types_text;
    }
}

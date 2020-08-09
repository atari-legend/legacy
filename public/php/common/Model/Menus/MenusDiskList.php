<?php
namespace AL\Common\Model\Menus;

require_once __DIR__."/../../../config/config.php";

/**
 * Maps to the Menu Sets tables
 */
class MenusDiskList {
    private $menu_sets_id;
    private $menu_sets_name;
    private $menu_disk_name;
    private $crew;
    private $individual;
    private $state_id;
    private $menu_state;
    private $menu_disk_year_id;
    private $menu_year;
    private $parent_id;

    public function __construct(
        $menu_sets_id,
        $menu_sets_name,
        $menu_disk_name,
        $crew,
        $individual,
        $state_id,
        $menu_state,
        $menu_disk_year_id,
        $menu_year,
        $parent_id
    ) {
        $this->menu_sets_id = $menu_sets_id;
        $this->menu_sets_name = $menu_sets_name;
        $this->menu_disk_name = $menu_disk_name;
        $this->crew = $crew;
        $this->individual = $individual;
        $this->state_id = $state_id;
        $this->menu_state = $menu_state;
        $this->menu_disk_year_id = $menu_disk_year_id;
        $this->menu_year = $menu_year;
        $this->parent_id = $parent_id;
    }

    public function getMenuSetsId() {
        return $this->menu_sets_id;
    }

    public function getMenuSetsName() {
        return $this->menu_sets_name;
    }

    public function getMenuDisk() {
        return $this->menu_disk_name;
    }

    public function getCrew() {
        return $this->crew;
    }

    public function getIndividual() {
        return $this->individual;
    }

    public function getMenuStateId() {
        return $this->state_id;
    }

    public function getMenuState() {
        return $this->menu_state;
    }

    public function getMenuDiskYearId() {
        return $this->menu_disk_year_id;
    }

    public function getMenuYear() {
        return $this->menu_year;
    }

    public function getMenuParentId() {
        return $this->parent_id;
    }
}

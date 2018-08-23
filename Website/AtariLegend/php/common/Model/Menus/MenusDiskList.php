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
    private $menu_disk_id;
    private $menu_disk_number;
    private $menu_disk_letter;
    private $menu_disk_version;
    private $menu_disk_part;
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
        $menu_disk_id,
        $menu_disk_number,
        $menu_disk_letter,
        $menu_disk_version,
        $menu_disk_part,
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
        $this->menu_disk_id = $menu_disk_id;
        $this->menu_disk_number = $menu_disk_number;
        $this->menu_disk_letter = $menu_disk_letter;
        $this->menu_disk_version = $menu_disk_version;
        $this->menu_disk_part = $menu_disk_part;
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

    public function getMenuDiskName() {
        return $this->menu_disk_name;
    }

    public function getMenuDiskId() {
        return $this->menu_disk_id;
    }

    public function getMenuDiskNumber() {
        return $this->menu_disk_number;
    }

    public function getMenuDiskLetter() {
        return $this->menu_disk_letter;
    }

    public function getMenuDiskVersion() {
        return $this->menu_disk_version;
    }

    public function getMenuDiskPart() {
        return $this->menu_disk_part;
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

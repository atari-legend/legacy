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
    private $crew;
    private $individual;
    private $menu_types_text;

    public function __construct(
        $menu_sets_id,
        $menu_sets_name,
        $menu_disk_count,
        $crew,
        $individual,
        $menu_types_text
    ) {
        $this->menu_sets_id = $menu_sets_id;
        $this->menu_sets_name = $menu_sets_name;
        $this->menu_disk_count = $menu_disk_count;
        $this->crew = $crew;
        $this->individual = $individual;
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

    public function getCrew() {
        return $this->crew;
    }

    public function getIndividual() {
        return $this->individual;
    }

    public function getMenuTypesText() {
        return $this->menu_types_text;
    }
}

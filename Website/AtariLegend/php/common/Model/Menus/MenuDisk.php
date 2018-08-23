<?php
namespace AL\Common\Model\Menus;

require_once __DIR__."/../../../config/config.php";

/**
 * Maps to the Menu Disk name
 */

class MenuDisk {
    private $menu_sets_name;
    private $menu_disk_number;
    private $menu_disk_letter;
    private $menu_disk_part;
    private $menu_disk_version;
    private $menu_disk_name;

    public function __construct(
        $menu_sets_name,
        $menu_disk_number,
        $menu_disk_letter,
        $menu_disk_part,
        $menu_disk_version
    ) {
        $this->menu_sets_name = $menu_sets_name;
        $this->menu_disk_number = $menu_disk_number;
        $this->menu_disk_letter = $menu_disk_letter;
        $this->menu_disk_part = $menu_disk_part;
        $this->menu_disk_version = $menu_disk_version;

        // Create Menu disk name
        $menu_disk_name = "$menu_sets_name ";
        if (isset($menu_disk_number)) {
            $menu_disk_name .= "$menu_disk_number";
        }
        if (isset($menu_disk_letter)) {
            $menu_disk_name .= "$menu_disk_letter";
        }
        if (isset($menu_disk_part)) {
            if (is_numeric($menu_disk_part)) {
                $menu_disk_name .= " part $menu_disk_part";
            } else {
                $menu_disk_name .= "$menu_disk_part";
            }
        }
        if (isset($menu_disk_version) and $menu_disk_version !== '') {
            $menu_disk_name .= " v$menu_disk_version";
        }

        $this->menu_disk_name = $menu_disk_name;
    }

    public function getName() {
        return $this->menu_disk_name;
    }
}

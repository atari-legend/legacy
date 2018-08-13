<?php
namespace AL\Common\Model\Menus;

/**
 * Maps to the `menu disk credits` tables
 */
class MenuDiskCredits {
    private $ind_id;
    private $ind_name;
    private $menu_disk_credits_id;
    private $author_type_info;

    public function __construct($ind_id, $ind_name, $menu_disk_credits_id, $author_type_info) {
        $this->ind_id = $ind_id;
        $this->ind_name = $ind_name;
        $this->menu_disk_credits_id = $menu_disk_credits_id;
        $this->author_type_info = $author_type_info;
    }

    public function getIndId() {
        return $this->ind_id;
    }

    public function getIndName() {
        return $this->ind_name;
    }

    public function getCreditsId() {
        return $this->menu_disk_credits_id;
    }

    public function getAuthorTypeInfo() {
        return $this->author_type_info;
    }
}

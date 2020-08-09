<?php
namespace AL\Common\Model\Menus;

/**
 * Maps to the `menu disk credits` tables
 */
class MenuDiskCredits {
    private $individual;
    private $menu_disk_credits_id;
    private $author_type_info;

    public function __construct($individual, $menu_disk_credits_id, $author_type_info) {
        $this->individual = $individual;
        $this->menu_disk_credits_id = $menu_disk_credits_id;
        $this->author_type_info = $author_type_info;
    }

    public function getIndividual() {
        return $this->individual;
    }

    public function getCreditsId() {
        return $this->menu_disk_credits_id;
    }

    public function getAuthorTypeInfo() {
        return $this->author_type_info;
    }
}

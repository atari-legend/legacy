<?php
namespace AL\Common\Model\PubDev;

/**
 * Maps to the `developer_role` table
 */
class DeveloperRole {
    private $id;
    private $role;

    public function __construct($id, $role) {
        $this->id = $id;
        $this->role = $role;
    }

    public function getId() {
        return $this->id;
    }

    public function getRole() {
        return $this->role;
    }
}

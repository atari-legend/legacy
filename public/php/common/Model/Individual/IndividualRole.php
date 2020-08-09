<?php
namespace AL\Common\Model\Individual;

/**
 * Maps to the `individual_role` table
 */
class IndividualRole {
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

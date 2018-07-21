<?php
namespace AL\Common\Model\Continent;

/**
 * Maps to the `continent` table
 */
class Continent {
    private $id;
    private $name;

    public function __construct($id, $name) {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }
}

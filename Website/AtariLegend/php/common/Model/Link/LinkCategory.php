<?php
namespace AL\Common\Model\Link;

/**
 * Maps to the `website_category` table
 */
class LinkCategory {
    private $id;
    private $name;
    private $count;

    public function __construct($id, $name, $count = -1) {
        $this->id = $id;
        $this->name = $name;
        $this->count = $count;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getCount() {
        return $this->count;
    }

}

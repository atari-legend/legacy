<?php
namespace AL\Common\Model\Link;

class LinkCategory {
    private $_id;
    private $_name;
    private $_count;

    public function __construct($id, $name, $count) {
        $this->_id = $id;
        $this->_name = $name;
        $this->_count = $count;
    }

    public function getId() {
        return $this->_id;
    }

    public function getName() {
        return $this->_name;
    }

    public function getCount() {
        return $this->_count;
    }

}

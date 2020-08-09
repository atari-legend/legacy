<?php
namespace AL\Common\Model\Game;

/**
 * Maps to the `game` table (port info)
 */
class Port {
    private $id;
    private $port;

    public function __construct($id, $port) {
        $this->id = $id;
        $this->port = $port;
    }

    public function getId() {
        return $this->id;
    }

    public function getPort() {
        return $this->port;
    }
}

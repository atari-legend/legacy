<?php
namespace AL\Common\Model\Crew;

/**
 * Maps to the `Crews` table
 */
class Crew {
    private $crew_id;
    private $crew_name;

    public function __construct($crew_id, $crew_name) {
        $this->crew_id = $crew_id;
        $this->crew_name = $crew_name;
    }

    public function getCrewId() {
        return $this->crew_id;
    }

    public function getCrewName() {
        return $this->crew_name;
    }
}

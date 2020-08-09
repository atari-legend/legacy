<?php
namespace AL\Common\Model\Location;

/**
 * Maps to the `location` table
 */
class Location {
    private $id;
    private $continent_code;
    private $name;
    private $country_iso2;
    private $country_iso3;
    private $type;

    public function __construct($id, $continent_code, $name, $country_iso2, $country_iso3, $type) {
        $this->id = $id;
        $this->continent_code = $continent_code;
        $this->name = $name;
        $this->country_iso2 = $country_iso2;
        $this->country_iso3 = $country_iso3;
        $this->type = $type;
    }

    public function getId() {
        return $this->id;
    }

    public function getContinentCode() {
        return $this->continent_code;
    }

    public function getName() {
        return $this->name;
    }

    public function getCountryISO2() {
        return $this->country_iso2;
    }

    public function getType() {
        return $this->type;
    }
}

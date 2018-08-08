<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Location/Location.php" ;

/**
 * DAO for Locations
 */
class LocationDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Get all locations
     *
     * @return \AL\Common\Model\Location\Location[] A list of locations
     */
    public function getAllLocations() {
        $stmt = \AL\Db\execute_query(
            "LocationDAO: getAllLocations",
            $this->mysqli,
            "SELECT id, continent_code, name, country_iso2, country_iso3, type
            FROM location
            ORDER by continent_code, type, name",
            null, null
        );

        \AL\Db\bind_result(
            "LocationDAO: getAllLocations",
            $stmt,
            $id, $continent_code, $name, $country_iso2, $country_iso3, $type
        );

        $locations = [];
        while ($stmt->fetch()) {
            $locations[] = new \AL\Common\Model\Location\Location(
                $id, $continent_code, $name, $country_iso2, $country_iso3, $type
            );
        }

        $stmt->close();

        return $locations;
    }

    /**
     * Get all the locations for a game release
     *
     * @param integer Release ID
     * @return \AL\Common\Model\Location\Location[] A list of locations
     */
    public function getLocationsForRelease($release_id) {
        $stmt = \AL\Db\execute_query(
            "LocationDAO: getLocationsForRelease",
            $this->mysqli,
            "SELECT location_id
            FROM game_release_location
            LEFT JOIN location on location.id = game_release_location.location_id
            WHERE game_release_id = ?
            ORDER by continent_code, type, name",
            "i", $release_id
        );

        \AL\Db\bind_result(
            "LocationDAO: getLocationsForRelease",
            $stmt,
            $location_id
        );

        $locations = [];
        while ($stmt->fetch()) {
            $locations[] = $location_id;
        }

        $stmt->close();

        return $locations;
    }

    /**
     * Set the list of locations a release was released in
     *
     * @param integer Release ID
     * @param integer[] List of location IDs
     * @return \AL\Common\Model\Location\Location[] A list of locations
     */
    public function setLocationsForRelease($release_id, $locations) {
        $stmt = \AL\Db\execute_query(
            "LocationDAO: setLocationsForRelease",
            $this->mysqli,
            "DELETE FROM game_release_location WHERE game_release_id = ?",
            "i", $release_id
        );

        foreach ($locations as $id) {
            $stmt = \AL\Db\execute_query(
                "LocationDAO: setLocationsForRelease",
                $this->mysqli,
                "INSERT INTO game_release_location (game_release_id, location_id) VALUES (?, ?)",
                "ii", $release_id, $id
            );
        }

        $stmt->close();
    }

    /**
     * Get a map containing all locations, indexed by ID
     *
     * @return \AL\Common\Model\Location\Location[] A map of locations
     */
    public function getAllLocationsAsMap() {
        $locations = $this->getAllLocations();
        $locationsMap = array();
        foreach ($locations as $location) {
            $locationsMap[$location->getId()] = $location;
        }

        return $locationsMap;
    }
}

<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;

/**
 * DAO for links submitted by users that need to be validated
 */
class ValidateLinkDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Add a new link to validate
     *
     * @param  string $name        Name of the link
     * @param  string $url         URL of the link
     * @param  string $description Description of the link
     * @return integer ID of the inserted link to validate
     */
    public function addValidateLink($name, $url, $description) {
        $stmt = \AL\Db\execute_query(
            "ValidateLinkDAO: Add link",
            $this->mysqli,
            "INSERT INTO website_validate (
                website_name,
                website_url,
                website_date,
                website_description,
                user_id
            )
            VALUES (?, ?, ?, ?, ?)",
            "ssiss", $name, $url, time(), $description, $_SESSION['user_id']
        );

        $id = $stmt->insert_id;

        $stmt->close();

        return $id;
    }
}

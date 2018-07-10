<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/PubDev/PubDev.php" ;

/**
 * DAO for PubDev
 */
class PubDevDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Get all publishers and developers
     * @return \AL\Common\Model\PubDev\PubDev[] A list of PubDevs
     */
    public function getPubDevsStartingWith($regexp) {
        $stmt = \AL\Db\execute_query(
            "PubDevDAO: getAllPubDev",
            $this->mysqli,
            "SELECT
                pub_dev.pub_dev_id,
                pub_dev.pub_dev_name,
                pub_dev_text.pub_dev_profile,
                pub_dev_text.pub_dev_imgext
            FROM
                pub_dev
            LEFT JOIN pub_dev_text ON pub_dev_text.pub_dev_id = pub_dev.pub_dev_id
            WHERE LOWER(pub_dev.pub_dev_name) REGEXP ?
            ORDER BY pub_dev.pub_dev_name ASC",
            "s", strtolower($regexp)
        );

        \AL\Db\bind_result(
            "PubDevDAO: getAllPubDev",
            $stmt,
            $id, $name, $profile, $imgext
        );

        $pubdevs = [];
        while ($stmt->fetch()) {
            $pubdevs[] = new \AL\Common\Model\PubDev\PubDev(
                $id, $name, $profile, $imgext
            );
        }

        $stmt->close();

        return $pubdevs;
    }

    /**
     * Get a publisher or developer
     * @param number $id ID of the pubdev to retrieve
     * @return \AL\Common\Model\PubDev\PubDev PubDev, or NULL if not found
     */
    public function getPubDev($id) {
        $stmt = \AL\Db\execute_query(
            "PubDevDAO: getPubDev",
            $this->mysqli,
            "SELECT
                pub_dev.pub_dev_id,
                pub_dev.pub_dev_name,
                pub_dev_text.pub_dev_profile,
                pub_dev_text.pub_dev_imgext
            FROM
                pub_dev
            LEFT JOIN pub_dev_text ON pub_dev_text.pub_dev_id = pub_dev.pub_dev_id
            WHERE pub_dev.pub_dev_id = ?
            ORDER BY pub_dev.pub_dev_name ASC",
            "i", $id
        );

        \AL\Db\bind_result(
            "PubDevDAO: getPubDev",
            $stmt,
            $id, $name, $profile, $imgext
        );

        $pubdev = null;
        if ($stmt->fetch()) {
            $pubdev = new \AL\Common\Model\PubDev\PubDev(
                $id, $name, $profile, $imgext
            );
        }

        $stmt->close();

        return $pubdev;
    }
}

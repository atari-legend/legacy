<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Link/Link.php" ;

/**
 * DAO for Links
 */
class LinkDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Get the SQL query to retrieve links, either all links or links for a
     * specific category
     *
     * @param  integer $category_id Optional ID of the category to retrieve links for
     * @return string SQL query
     */
    private function getLinkQuery($category_id = null) {
        $query = "SELECT
                website.website_id,
                website_name,
                website_url,
                description,
                website_imgext,
                website.inactive,
                users.userid,
                users.user_id,
                website_date,
                website_category.website_category_id,
                website_category.website_category_name
            FROM
                website
            LEFT JOIN website_category_cross
                ON website_category_cross.website_id = website.website_id
            LEFT JOIN website_category
                ON website_category.website_category_id = website_category_cross.website_category_id
            LEFT JOIN users
                ON users.user_id = website.user_id";

        if (isset($category_id)) {
            $query .= " WHERE website_category.website_category_id = ?";
        }

        $query .= " ORDER BY website_date DESC LIMIT ?, ?";

        return $query;
    }

    /**
     * Retrieve all links
     *
     * @param  integer $offset Link offset to start with, for paging
     * @param  integer $limit  How many links to return, for paging
     * @return \AL\Common\Model\Link\Link[] An array of links
     */
    public function getAllLinks($offset = 0, $limit = 5) {
        $stmt = \AL\Db\execute_query(
            "LinkDAO: Get all links",
            $this->mysqli,
            $this->getLinkQuery(),
            "ii", $offset, $limit
        );

        \AL\Db\bind_result(
            "LinkDAO: Get all links",
            $stmt,
            $id, $name, $url, $description, $imgext, $inactive, $user, $userid, $date, $category_id, $category_name
        );

        $links = [];
        while ($stmt->fetch()) {
            $links[] = new \AL\Common\Model\Link\Link(
                $id,
                $name,
                $url,
                $description,
                $imgext,
                $inactive,
                $user,
                $date,
                $userid,
                $category_name
            );
        }

        $stmt->close();

        return $links;
    }

    /**
     * Retrieve all links for a category
     *
     * @param  integer $category_id ID of the category to retrieve links for
     * @param  integer $offset      Link offset to start with, for paging
     * @param  ingeter $limit       How many links to return, for paging
     * @return \AL\Common\Model\Link\Link[] An array of links
     */
    public function getAllLinksForCategory($category_id, $offset = 0, $limit = 5) {
        $stmt = \AL\Db\execute_query(
            "LinkDAO: Get all links",
            $this->mysqli,
            $this->getLinkQuery($category_id),
            "iii", $category_id, $offset, $limit
        );

        \AL\Db\bind_result(
            "LinkDAO: Get all links",
            $stmt,
            $id,
            $name,
            $url,
            $description,
            $imgext,
            $inactive,
            $user,
            $userid,
            $date,
            $category_id,
            $category_name
        );

        $links = [];
        while ($stmt->fetch()) {
            $links[] = new \AL\Common\Model\Link\Link(
                $id,
                $name,
                $url,
                $description,
                $imgext,
                $inactive,
                $user,
                $date,
                $userid,
                $category_name
            );
        }

        $stmt->close();

        return $links;
    }

    /**
     * Get the total count of links, for all links or for a given category
     *
     * @param  integer $category_id Optional ID of a category to count links for
     * @return integer Number of links
     */
    public function getLinkCount($category_id = null) {
        if (isset($category_id)) {
            $stmt = \AL\Db\execute_query(
                "LinkDAO: Get link count for category $category_id",
                $this->mysqli,
                "SELECT COUNT(*) FROM website_category_cross WHERE website_category_id = ?",
                "i", $category_id
            );
        } else {
            $stmt = \AL\Db\execute_query(
                "LinkDAO: Get link count",
                $this->mysqli,
                "SELECT COUNT(*) FROM website".
                null, null
            );
        }

        \AL\Db\bind_result(
            "LinkDAO: Get link count",
            $stmt,
            $count
        );

        $stmt->fetch();
        $stmt->close();

        return $count;
    }

    /**
     * Get a random link
     * I have excluded youtube links in here as the youtube logo's do not fit the look 
     * and it bothered me.
     */
    public function getRandomLink() {
        $stmt = \AL\Db\execute_query(
            "LinkDAO: Get random link",
            $this->mysqli,
            "SELECT website.website_id,
                    website.website_name,
                    website.website_url,
                    website.website_imgext,
                    website.website_date,
                    website.description,
                    website.inactive,
                    users.userid,
                    users.user_id
                    FROM website
                    LEFT JOIN website_category_cross ON (website.website_id = website_category_cross.website_id)
                    LEFT JOIN website_category ON (website_category.website_category_id = website_category_cross.website_category_id)
                    LEFT JOIN users ON ( website.user_id = users.user_id )
                    WHERE website.website_imgext <> ' ' and website.inactive = 0 and website_category.website_category_name <> 'Youtube'
                    ORDER BY RAND() LIMIT 1".
            null, null
        );

        \AL\Db\bind_result(
            "LinkDAO: Get random link",
            $stmt,
            $id,
            $name,
            $url,
            $imgext,
            $date,
            $description,
            $inactive,
            $user,
            $userid
        );

        $link = null;
        if ($stmt->fetch()) {
            $link = new \AL\Common\Model\Link\Link(
                $id,
                $name,
                $url,
                $description,
                $imgext,
                $inactive,
                $user,
                $date,
                $userid
            );
        }

        $stmt->close();

        return $link;
    }
}

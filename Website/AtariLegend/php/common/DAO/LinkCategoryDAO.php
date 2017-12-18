<?php
namespace AL\Common\DAO;

require __DIR__."/../../lib/Db.php" ;
require __DIR__."/../Model/Link/LinkCategory.php" ;

/**
 * DAO for Link Categories
 */
class LinkCategoryDAO {
    private $_mysqli;

    public function __construct($mysqli) {
        $this->_mysqli = $mysqli;
    }

    /**
     * Retrieve all categories, with the count of links for each
     *
     * @return An array of all categories
     */
    public function getAllCategories() {
        $stmt = \AL\Db\execute_query(
            "LinkCategoryDAO: Get all categories",
            $this->_mysqli,
            " SELECT
                website_category.website_category_id,
                website_category_name,
                COUNT(website_category_cross_id)
            FROM
                website_category
            LEFT JOIN website_category_cross ON website_category.website_category_id = website_category_cross.website_category_id
            GROUP BY
                website_category.website_category_id",
            null, null
        );

        \AL\Db\bind_result(
            "LinkCategoryDAO: Get all categories",
            $stmt,
            $id, $name, $count
        );

        $categories = [];
        while ($stmt->fetch()) {
            $categories[] = new \AL\Common\Model\Link\LinkCategory($id, $name, $count);
        }

        $stmt->close();

        return $categories;
    }
}

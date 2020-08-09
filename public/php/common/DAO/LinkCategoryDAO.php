<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Link/LinkCategory.php" ;

/**
 * DAO for Link Categories
 */
class LinkCategoryDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Retrieve all categories, with the count of links for each
     *
     * @return AL\Common\Model\Link\LinkCategory[] An array of all categories
     */
    public function getAllCategories() {
        $stmt = \AL\Db\execute_query(
            "LinkCategoryDAO: Get all categories",
            $this->mysqli,
            "SELECT
                website_category.website_category_id,
                website_category_name,
                COUNT(website_category_cross_id)
            FROM
                website_category
            LEFT JOIN website_category_cross
                ON website_category.website_category_id = website_category_cross.website_category_id
            GROUP BY
                website_category.website_category_id
            ORDER BY
                website_category_name ASC",
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

    /**
     * Retrieve a specific category
     *
     * @param  integer $category_id ID of the category to retrieve
     * @return AL\Common\Model\Link\LinkCategory Category
     */
    public function getCategory($category_id) {
        $stmt = \AL\Db\execute_query(
            "LinkCategoryDAO: Get single category from id: $category_id",
            $this->mysqli,
            "SELECT
                website_category_id,
                website_category_name
            FROM
                website_category
            WHERE
                website_category_id = ?",
            "s", $category_id
        );

        \AL\Db\bind_result(
            "LinkCategoryDAO: Get single category from id: $category_id",
            $stmt,
            $id, $name
        );

        $category = null;
        if ($stmt->fetch()) {
            $category = new \AL\Common\Model\Link\LinkCategory($id, $name);
        }

        $stmt->close();

        return $category;
    }
}

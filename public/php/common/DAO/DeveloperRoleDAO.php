<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/PubDev/DeveloperRole.php" ;

/**
 * DAO for Developer Roles
 */
class DeveloperRoleDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Get all Roles
     *
     * @return \AL\Common\Model\PubDev\DeveloperRole[] An array of roles
     */
    public function getAllDeveloperRoles() {
        $stmt = \AL\Db\execute_query(
            "DeveloperRoleDAO: getAllDeveloperRoles",
            $this->mysqli,
            "SELECT id, name FROM developer_role ORDER BY name",
            null, null
        );

        \AL\Db\bind_result(
            "DeveloperRoleDAO: getAllDeveloperRoles",
            $stmt,
            $id, $role
        );

        $developer_roles = [];
        while ($stmt->fetch()) {
            $developer_roles[] = new \AL\Common\Model\PubDev\DeveloperRole(
                $id, $role
            );
        }

        $stmt->close();

        return $developer_roles;
    }

    /**
     * Get role for a role id
     *
     * @param integer role ID
     */
    public function getRoleForId($id) {
        $stmt = \AL\Db\execute_query(
            "DeveloperRoleDAO: getRoleForId",
            $this->mysqli,
            "SELECT id, name
            FROM developer_role
            WHERE id = ?",
            "i", $id
        );

        \AL\Db\bind_result(
            "DeveloperRoleDAO: getRoleForId",
            $stmt,
            $id, $role
        );

        $developer_roles = null;
        while ($stmt->fetch()) {
            $developer_roles = new \AL\Common\Model\PubDev\DeveloperRole(
                $id, $role
            );
        }

        $stmt->close();

        return $developer_roles;
    }

    /**
     * add a role to the database
     *
     * @param varchar role
     */
    public function addDeveloperRole($role) {
        $stmt = \AL\Db\execute_query(
            "DeveloperRoleDAO: addDeveloperRole",
            $this->mysqli,
            "INSERT INTO developer_role (`name`) VALUES (?)",
            "s", $role
        );

        $stmt->close();
    }

    /**
     * delete a role
     *
     * @param int role_id
     */
    public function deleteDeveloperRole($role_id) {
        $stmt = \AL\Db\execute_query(
            "DeveloperRoleDAO: deleteDeveloperRole",
            $this->mysqli,
            "DELETE FROM developer_role WHERE id = ?",
            "i", $role_id
        );

        $stmt->close();
    }

        /**
     * update a role
     *
     * @param int role_id
     * @param varchar role_name
     */
    public function updateDeveloperRole($role_id, $role_name) {
        $stmt = \AL\Db\execute_query(
            "DeveloperRoleDAO: updateDeveloperRole",
            $this->mysqli,
            "UPDATE developer_role SET name = ? WHERE id = ?",
            "si", $role_name, $role_id
        );

        $stmt->close();
    }
}

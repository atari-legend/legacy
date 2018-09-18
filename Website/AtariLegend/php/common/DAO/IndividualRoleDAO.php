<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Individual/IndividualRole.php" ;

/**
 * DAO for Individual Roles
 */
class IndividualRoleDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Get all Roles
     *
     * @return \AL\Common\Model\Individual\IndividualRole[] An array of genres
     */
    public function getAllIndividualRoles() {
        $stmt = \AL\Db\execute_query(
            "IndividualRoleDAO: getAllIndividualRoles",
            $this->mysqli,
            "SELECT id, name FROM individual_role ORDER BY name",
            null, null
        );

        \AL\Db\bind_result(
            "IndividualRoleDAO: getAllIndividualRoles",
            $stmt,
            $id, $role
        );

        $individual_roles = [];
        while ($stmt->fetch()) {
            $individual_roles[] = new \AL\Common\Model\Individual\IndividualRole(
                $id, $role
            );
        }

        $stmt->close();

        return $individual_roles;
    }
    
    /**
     * Get role for a role id
     *
     * @param integer role ID
     */
    public function getRoleForId($id) {
        $stmt = \AL\Db\execute_query(
            "IndividualRoleDAO: getRoleForId",
            $this->mysqli,
            "SELECT id, name
            FROM individual_role 
            WHERE id = ?",
            "i", $id
        );

        \AL\Db\bind_result(
            "IndividualRoleDAO: getRoleForId",
            $stmt,
            $id, $role
        );

        $individual_roles = null;
        while ($stmt->fetch()) {
            $individual_roles = new \AL\Common\Model\Individual\IndividualRole(
                $id, $role
            );
        }

        $stmt->close();

        return $individual_roles;
    }
    
    /**
     * add a role to the database
     *
     * @param varchar role
     */
    public function addIndividualRole($role) {
        $stmt = \AL\Db\execute_query(
            "IndividualRoleDAO: addIndividualRole",
            $this->mysqli,
            "INSERT INTO individual_role (`name`) VALUES (?)",
            "s", $role
        );

        $stmt->close();
    }
    
    /**
     * delete a role
     *
     * @param int role_id
     */
    public function deleteIndividualRole($role_id) {
        $stmt = \AL\Db\execute_query(
            "IndividualRoleDAO: deleteIndividualRole",
            $this->mysqli,
            "DELETE FROM individual_role WHERE id = ?",
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
    public function updateIndividualRole($role_id, $role_name) {
        $stmt = \AL\Db\execute_query(
            "IndividualRoleDAO: updateIndividualRole",
            $this->mysqli,
            "UPDATE individual_role SET name = ? WHERE id = ?",
            "si", $role_name, $role_id
        );
        
        $stmt->close();
    }
}

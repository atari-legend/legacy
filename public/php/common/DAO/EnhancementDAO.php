<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Game/Enhancement.php" ;

/**
 * DAO for ports
 */
class EnhancementDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Get all Enhancements
     *
     * @return "/../Model/game/Enhancement[] An array of Enhancements
     */
    public function getAllEnhancements() {
        $stmt = \AL\Db\execute_query(
            "EnhancementDAO: getAllEnhancements",
            $this->mysqli,
            "SELECT id, name FROM enhancement ORDER BY name",
            null, null
        );

        \AL\Db\bind_result(
            "EnhancementDAO: getAllEnhancements",
            $stmt,
            $id, $name
        );

        $enhancements = [];
        while ($stmt->fetch()) {
            $enhancements[] = new \AL\Common\Model\Game\Enhancement(
                $id, $name
            );
        }

        $stmt->close();

        return $enhancements;
    }
    
    /**
     * add an enhancement to the database
     *
     * @param varchar enhancement
     */
    public function addEnhancement($enhancement) {
        $stmt = \AL\Db\execute_query(
            "EnhancementDAO: addEnhancement",
            $this->mysqli,
            "INSERT INTO enhancement (`name`) VALUES (?)",
            "s", $enhancement
        );

        $stmt->close();
    }
    
    /**
     * delete a Enhancement
     *
     * @param int Enhancement_id
     */
    public function deleteEnhancement($enhancement_id) {
        $stmt = \AL\Db\execute_query(
            "EnhancementDAO: deleteEnhancement",
            $this->mysqli,
            "DELETE FROM enhancement WHERE id = ?",
            "s", $enhancement_id
        );

        $stmt->close();
    }
    
        /**
     * update a Enhancement
     *
     * @param int Enhancement_id
     * @param varchar Enhancement_name
     */
    public function updateEnhancement($enhancement_id, $enhancement_name) {
        $stmt = \AL\Db\execute_query(
            "EnhancementDAO: updateEnhancement",
            $this->mysqli,
            "UPDATE enhancement SET name = ? WHERE id = ?",
            "ss", $enhancement_name, $enhancement_id
        );
        
        $stmt->close();
    }
}

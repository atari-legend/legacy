<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Game/Memory.php" ;

/**
 * DAO for memory
 */
class MemoryDAO {
    private $mysqli;
    
    const ENHANCEMENT_GRAPHICS = 'Graphics';
    const ENHANCEMENT_SOUND = 'Sound';
    const ENHANCEMENT_SCROLLING = 'Scrolling';

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }
    
    /**
     * Get all the enhancement types
     * @return String[] A list of enhancement types
     */
    public function getEnhancementTypes() {
        return array(
            MemoryDAO::ENHANCEMENT_GRAPHICS,
            MemoryDAO::ENHANCEMENT_SOUND,
            MemoryDAO::ENHANCEMENT_SCROLLING
        );
    }

    /**
     * Get all memory amounts
     *
     * @return \AL\Common\Model\Game\Memory[] An array of memory amounts
     */
    public function getAllMemory() {
        $stmt = \AL\Db\execute_query(
            "MemoryDAO: getAllMemory",
            $this->mysqli,
            "SELECT id, memory FROM memory ORDER BY memory",
            null, null
        );

        \AL\Db\bind_result(
            "MemoryDAO: getAllMemory",
            $stmt,
            $id, $memory
        );

        $memory_all = [];
        while ($stmt->fetch()) {
            $memory_all[] = new \AL\Common\Model\Game\Memory(
                $id, $memory, null
            );
        }

        $stmt->close();

        return $memory_all;
    }

    /**
     * Get list of memory IDs for a game release
     *
     * @param integer release ID
     */
    public function getMemoryForRelease($release_id) {
        $stmt = \AL\Db\execute_query(
            "MemoryDAO: getMemoryForRelease",
            $this->mysqli,
            "SELECT memory_id, memory, enhancement
            FROM game_release_memory_enhanced LEFT JOIN 
            memory ON (game_release_memory_enhanced.memory_id = memory.id)
            WHERE release_id = ?",
            "i", $release_id
        );

        \AL\Db\bind_result(
            "MemoryDAO: getMemoryForRelease",
            $stmt,
            $memory_id, $memory, $enhancement
        );

        $memory_linked = [];
        while ($stmt->fetch()) {
            $memory_linked[] = new \AL\Common\Model\Game\Memory(
                $memory_id, $memory, $enhancement
            );
        }

        $stmt->close();

        return $memory_linked;
    }
    
    /**
     * Set the list of memory enhancements for this release
     *
     * @param integer release ID
     * @param integer[] List of memory IDs
     */
    public function setMemoryForRelease($release_id, $memory_id, $enhancement) {
       
        $stmt = \AL\Db\execute_query(
            "MemoryDAO: setMemoryForRelease",
            $this->mysqli,
            "INSERT INTO game_release_memory_enhanced (release_id, memory_id, enhancement) VALUES (?, ?, ?)",
            "iis", $release_id, $memory_id, $enhancement
        );

        $stmt->close();
    }
    
     /**
     * Update enhancement for memory
     *
     * @param integer Game Release ID
     * @param integer memory ID
     */
    public function updateMemoryForRelease($game_release_id, $memory_id, $enhancement) {
        $stmt = \AL\Db\execute_query(
            "MemoryDAO: UpdateMemoryForRelease",
            $this->mysqli,
            "UPDATE game_release_memory_enhanced
            SET
                `enhancement` = ?
            WHERE release_id = ? AND memory_id = ?",
            "sii", $enhancement, $game_release_id, $memory_id
        );

        $stmt->close();
    }
    
    
         /**
     * Delete Memory enhancement for release
     *
     * @param integer Game Release ID
     * @param integer memory ID
     */
    public function deleteMemoryForRelease($game_release_id, $memory_id) {
        $stmt = \AL\Db\execute_query(
            "MemoryDAO: DeleteMemoryForRelease",
            $this->mysqli,
            "DELETE FROM game_release_memory_enhanced
            WHERE release_id = ? AND memory_id = ?",
            "ii", $game_release_id, $memory_id
        );

        $stmt->close();
    }
    
    
     /**
     * Update minimum memorty for release
     *
     * @param integer Game Release ID
     * @param integer memory ID
     */
    public function updateMinimumMemoryForRelease($game_release_id, $memory_id) {
        $stmt = \AL\Db\execute_query(
            "MemoryDAO: UpdateMinimumMemoryForRelease",
            $this->mysqli,
            "UPDATE game_release
            SET
                `memory_id` = ?
            WHERE id = ?",
            "ii", $memory_id, $game_release_id
        );

        $stmt->close();
    }
    
     
     /**
     * add a memory amount to the database
     *
     * @param varchar memory
     */
    public function addMemory($memory) {
        $stmt = \AL\Db\execute_query(
            "MemoryDAO: addMemory",
            $this->mysqli,
            "INSERT INTO memory (`memory`) VALUES (?)",
            "s", $memory
        );

        $stmt->close();
    }
    
    /**
     * delete a $memory amount
     *
     * @param int $memory_id
     */
    public function deleteMemory($memory_id) {
        $stmt = \AL\Db\execute_query(
            "MemoryDAO: deleteMemory",
            $this->mysqli,
            "DELETE FROM memory WHERE id = ?",
            "i", $memory_id
        );

        $stmt->close();
    }
    
        /**
     * update a memory amount
     *
     * @param int memory_id
     * @param varchar memory_memory
     */
    public function updateMemory($memory_id, $memory) {
        $stmt = \AL\Db\execute_query(
            "MemoryDAO: updateMemory",
            $this->mysqli,
            "UPDATE memory SET memory = ? WHERE id = ?",
            "si", $memory, $memory_id
        );
        
        $stmt->close();
    }
}

<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Database/Change.php" ;

/**
 * DAO for DB Change
 */
class ChangeDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }


    /**
     * Get a single change from it's update ID (NOT the automatically incremented
     *  id from the database)
     * @param number $id Update ID of the change to retrieve
     * @return \AL\Common\Model\Database\Change The change
     */
    public function getChangeByUpdateId($update_id) {
        $stmt = \AL\Db\execute_query(
            "ChangeDAO: getChange: $update_id",
            $this->mysqli,
            "SELECT
                database_change_id,
                database_update_id,
                update_description,
                execute_timestamp,
                implementation_state,
                update_filename,
                database_change_script
            FROM database_change WHERE database_update_id = ?",
            "i", $update_id
        );

        \AL\Db\bind_result(
            "ChangeDAO: getChange: $update_id",
            $stmt,
            $database_change_id,
            $database_update_id,
            $update_description,
            $execute_timestamp,
            $implementation_state,
            $update_filename,
            $database_change_script
        );

        $change = null;
        if ($stmt->fetch()) {
            $change = new \AL\Common\Model\Database\Change(
                $database_change_id,
                $database_update_id,
                $update_description,
                $execute_timestamp,
                $implementation_state,
                $update_filename,
                $database_change_script
            );
        }

        $stmt->close();

        return $change;
    }

    /**
     * Insert a new change
     *
     * @param  \AL\Common\Model\Database\Change Change to insert
     * @return integer ID of the inserted change
     */
    public function insertChange($change) {
        $stmt = \AL\Db\execute_query(
            "ChangeDAO: insertChange",
            $this->mysqli,
            "INSERT INTO database_change (
                database_update_id,
                update_description,
                execute_timestamp,
                implementation_state,
                update_filename,
                database_change_script
            ) VALUES (?, ?, ?, ?, ?, ?)",
            "isisss",
            $change->getUpdateId(),
            $change->getDescription(),
            $change->getTimestamp(),
            $change->getState(),
            $change->getFilename(),
            $change->getScript()
        );

        $id = $stmt->insert_id;

        $stmt->close();

        return $id;
    }
}

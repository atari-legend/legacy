<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Database/ChangeLog.php" ;

/**
 * DAO for DB Change Log
 */
class ChangeLogDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Insert a new change log entry
     *
     * @param  \AL\Common\Model\Database\Changelog Change log to insert
     * @return integer ID of the inserted change log
     */
    public function insertChangeLog($change_log) {
        $stmt = \AL\Db\execute_query(
            "ChangeLogDAO: insertChangeLog",
            $this->mysqli,
            "INSERT INTO change_log (
                section,
                section_id,
                section_name,
                sub_section,
                sub_section_id,
                sub_section_name,
                user_id,
                action,
                timestamp
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
            "sissisisi",
            $change_log->getSection(),
            $change_log->getSectionId(),
            $change_log->getSectionValue(),
            $change_log->getSubSection(),
            $change_log->getSubSectionId(),
            $change_log->getSubSectionValue(),
            $change_log->getUserId(),
            $change_log->getAction(),
            $change_log->getTimestamp()
        );

        $id = $stmt->insert_id;

        $stmt->close();

        return $id;
    }
}

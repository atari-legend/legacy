<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php";
require_once __DIR__."/../Model/Database/ChangeLog.php";
require_once __DIR__."/../Model/Database/ShortLog.php";

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

    /**
     * Create shortlog
     *
     * @param  \AL\Common\Model\Database\ShortLog Change log to insert
     * @return integer ID of the inserted change log
     */
    public function buildShortLog() {
        $stmt = \AL\Db\execute_query(
            "ChangeLogDAO: getShortLog",
            $this->mysqli,
            "SELECT
                change_log.change_log_id,
                change_log.section,
                change_log.section_id,
                change_log.section_name,
                change_log.sub_section,
                change_log.sub_section_id,
                change_log.sub_section_name,
                change_log.user_id,
                users.userid AS 'user_name',
                change_log.action,
                change_log.timestamp
            FROM change_log
            LEFT JOIN users ON (change_log.user_id = users.user_id)
            WHERE change_log.section = 'Games'
            HAVING change_log.sub_section IN ('AKA', 'Author', 'Box back', 'Box front', 'Creator',
                'Developer', 'Game', 'Publisher', 'Screenshot', 'Similar', 'Submission', 'Release')
            ORDER BY change_log.timestamp DESC LIMIT 10",
            null,
            null
        );

        \AL\Db\bind_result(
            "ChangeLogDAO: getShortLog",
            $stmt,
            $change_log_id,
            $section,
            $section_id,
            $section_name,
            $sub_section,
            $sub_section_id,
            $sub_section_name,
            $user_id,
            $user_name,
            $action,
            $timestamp
        );

        $shortlog = [];

        while ($stmt->fetch()) {
            $shortlog[] = new \AL\Common\Model\Database\ShortLog(
                $change_log_id,
                $section,
                $section_id,
                $section_name,
                $sub_section,
                $sub_section_id,
                $sub_section_name,
                $user_id,
                $user_name,
                $action,
                $timestamp
            );
        }

        $stmt->close();

        return $shortlog;
    }
}

<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php";
require_once __DIR__."/../Model/Database/ChangeLog.php";
require_once __DIR__."/../Model/User/User.php";

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
     * Get changelog entries for a specific section
     *
     * @param integer $limit How many entries to return
     * @return integer ID of the inserted change log
     */
    public function getChangeLogForSection($section, $limit = 10) {
        $stmt = \AL\Db\execute_query(
            "ChangeLogDAO: getChangeLogForSection",
            $this->mysqli,
            "SELECT
                change_log_id,
                section,
                section_id,
                section_name,
                sub_section,
                sub_section_id,
                sub_section_name,
                change_log.user_id,
                users.userid,
                users.email,
                users.join_date,
                users.karma,
                users.show_email,
                users.avatar_ext,
                action,
                timestamp
            FROM change_log
            LEFT JOIN users ON (change_log.user_id = users.user_id)
            WHERE change_log.section = ?
        ORDER BY timestamp DESC LIMIT ?",
            "si", $section, $limit
        );

        \AL\Db\bind_result(
            "ChangeLogDAO: getChangeLogForSection",
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
            $user_email,
            $user_join_date,
            $user_karma,
            $user_show_email,
            $user_avatar_ext,
            $action,
            $timestamp
        );

        $changelogs = [];

        while ($stmt->fetch()) {
            $changelog = new \AL\Common\Model\Database\ChangeLog(
                $change_log_id,
                $section,
                $section_id,
                $section_name,
                $sub_section,
                $sub_section_id,
                $sub_section_name,
                $user_id,
                $action,
                $timestamp
            );
            $changelog->setUser(new \AL\Common\Model\User\User(
                $user_id,
                $user_name,
                $user_email,
                $user_join_date,
                $user_karma,
                $user_show_email,
                $user_avatar_ext
            ));

            $changelogs[] = $changelog;
        }

        $stmt->close();

        return $changelogs;
    }
}

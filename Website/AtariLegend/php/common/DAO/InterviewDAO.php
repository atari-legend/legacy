<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Interview/Interview.php" ;

/**
 * DAO for Interview
 */
class InterviewDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Return the latest interviews, sorted by descending date
     *
     * @param integer $limit How many interviewsto return
     * @return \AL\Common\Model\Interview\Interview[] An array of interviews
     */
    public function getLatestInterviews($limit = 20) {
        $stmt = \AL\Db\execute_query(
            "InterviewDAO: getLatestInterviews",
            $this->mysqli,
            "SELECT
                interview_main.interview_id,
                interview_text.interview_intro,
                interview_text.interview_date,
                users.userid,
                individuals.ind_name
            FROM
                interview_main
            LEFT JOIN interview_text ON interview_text.interview_id = interview_main.interview_id
            LEFT JOIN users ON interview_main.user_id = users.user_id
            LEFT JOIN individuals ON individuals.ind_id = interview_main.ind_id
            ORDER BY
                interview_date
            DESC
            LIMIT ?",
            "i", $limit
        );

        \AL\Db\bind_result(
            "InterviewDAO: getLatestInterviews",
            $stmt,
            $id, $intro, $date, $user, $individual
        );

        $interviews = [];
        while ($stmt->fetch()) {
            $interviews[] = new \AL\Common\Model\Interview\Interview(
                $id,
                $intro,
                $date,
                $user,
                $individual
            );
        }

        $stmt->close();

        return $interviews;
    }
}

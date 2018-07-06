<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/User/User.php" ;

/**
 * DAO for User
 */
class UserDAO {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Retrieve all users
     * @return \AL\Common\Model\User\User[] A list of users
     */
    public function getAllUsers() {
        $stmt = \AL\Db\execute_query(
            "UserDAO: getAllUsers",
            $this->mysqli,
            "SELECT
                user_id,
                userid,
                email,
                join_date,
                karma,
                avatar_ext
            FROM users
            ORDER BY userid ASC",
            null, null
        );

        \AL\Db\bind_result(
            "UserDAO: getAllUsers",
            $stmt,
            $id,
            $userid,
            $email,
            $join_date,
            $karma,
            $avatar_ext
        );

        $users = [];

        while ($stmt->fetch()) {
            $users[] = new \AL\Common\Model\User\User(
                $id,
                $userid,
                $email,
                $join_date,
                $karma,
                $avatar_ext,
                0
            );
        }

        $stmt->close();

        return $users;
    }
}

<?php
namespace AL\Common\Model\User;

require_once __DIR__."/../../../config/config.php";
require_once __DIR__."/../../../lib/functions.php";

/**
 * Maps to the `user` table
 */
class User {
    private $id;
    private $name;
    private $email;
    private $join_date;
    private $karma;
    private $show_email;
    private $avatar;
    private $news_count;

    public function __construct(
        $id,
        $name,
        $email,
        $join_date,
        $karma,
        $show_email,
        $avatar_ext,
        $news_count = 0
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->join_date = $join_date;
        $this->karma = $karma;
        $this->show_email = $show_email;

        if ($avatar_ext != null && $avatar_ext != '') {
            $this->avatar = $GLOBALS['user_avatar_path'].$id.'.'.$avatar_ext;
        } else {
            $this->avatar = "/themes/styles/1/images/default_avatar_image.png";
        }

        $this->news_count = $news_count;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getJoinDate() {
        return $this->join_date;
    }

    public function getKarma() {
        return $this->karma;
    }

    public function getShowEmail() {
        return $this->show_email;
    }

    public function getAvatar() {
        return $this->avatar;
    }

    public function getNewsCount() {
        return $this->news_count;
    }
}

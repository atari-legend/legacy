<?php
namespace AL\Common\Model\GameSubmission;

require_once __DIR__."/../../../config/config.php";
require_once __DIR__."/../../../lib/functions.php";

/**
 * Maps to the `GameSubmission' table
 */
class GameSubmission {
    private $game_id;
    private $game_name;
    private $timestamp;
    private $date;
    private $comment;
    private $submission_id;
    private $done;
    private $userid;
    private $username;
    private $email;
    private $join_date;
    private $karma;
    private $avatar_ext;
    private $user_subm_count;
    private $user_comment_count;
    private $screenshots;

    public function __construct(
        $game_id,
        $game_name,
        $timestamp,
        $date,
        $comment,
        $submission_id,
        $done,
        $userid,
        $username,
        $email,
        $join_date,
        $karma,
        $avatar_ext,
        $user_subm_count,
        $user_comment_count,
        $screenshots
    ) {
        $this->game_id = $game_id;
        $this->game_name = $game_name;
        $this->timestamp = $timestamp;
        $this->post_date = date("F j, Y", $date);
        $this->comment = $comment;
        $this->submission_id = $submission_id;
        $this->done = $done;
        $this->userid = $userid;
        $this->username = $username;
        $this->email = $email;
        $this->screenshots = $screenshots;
        
        if ($join_date == "") {
            $this->join = "unknown";
        } else {
            $this->join = date("d-m-y", $join_date);
        }
       
        $this->karma = $karma;
        $this->user_subm_count = $user_subm_count;
        $this->user_comment_count = $user_comment_count;
        
        if ($avatar_ext && $avatar_ext !== "") {
            $this->avatar_image = $GLOBALS['user_avatar_path']."/${userid}.${avatar_ext}";
        } else {
            $this->avatar_image = $GLOBALS['style_folder']."/images/default_avatar_image.png";
        }
    }

    public function getGameId() {
        return $this->game_id;
    }
    
    public function getName() {
        return $this->game_name;
    }

    public function getComment() {
        return $this->comment;
    }

    public function getDate() {
        return $this->post_date;
    }
    
    public function getSubmissionId() {
        return $this->submission_id;
    }
    
    public function getDone() {
        return $this->done;
    }

    public function getUserId() {
        return $this->userid;
    }
    
    public function getUserName() {
        return $this->username;
    }
    
    public function getEmail() {
        return $this->email;
    }

    public function getJoinDate() {
        return $this->join;
    }

    public function getKarma() {
        return $this->karma;
    }
    
    public function getAvatarImage() {
        return $this->avatar_image;
    }
    
    public function getUserSubCount() {
        return $this->user_subm_count;
    }

    public function getUserCommentCount() {
        return $this->user_comment_count;
    }
    
    public function getTimestamp() {
        return $this->timestamp;
    }
    
    public function getScreenshots() {
        return $this->screenshots;
    }
}

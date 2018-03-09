<?php
namespace AL\Common\Model\Comments;

use AL\Common\DAO\CommentsDAO;

require_once __DIR__."/../../../config/config.php";

/**
 * Maps to the temporary `temp` comments table
 */
class Comments {
    private $comments_id;
    private $timestamp;
    private $user_id;
    private $user_comment_count;
    private $user_subm_count;
    private $userid;
    private $email;
    private $join_date;
    private $karma;
    private $avatar_ext;
    private $game_id;
    private $game_name;
    private $comment_type;
    private $comment;
    private $review_id;

    public function __construct(
        $comments_id,
        $timestamp,
        $user_id,
        $user_comment_count,
        $user_subm_count,
        $userid,
        $email,
        $join_date,
        $karma,
        $avatar_ext,
        $game_id,
        $game_name,
        $comment_type,
        $comment,
        $review_id
    ) {
        $this->comments_id = $comments_id;
        $this->timestamp = $timestamp;
        $this->post_date = $timestamp;
        $this->user_id = $user_id;
        $this->user_comment_count = $user_comment_count;
        $this->user_subm_count = $user_subm_count;
        $this->userid = $userid;
        $this->email = $email;
        $this->join_date = $join_date;
        $this->karma = $karma;
        $this->avatar_ext = $avatar_ext;
        $this->game_id = $game_id;
        $this->game_name = $game_name;
        $this->comment_type = $comment_type;
        $this->comment = $comment;
        $this->review_id = $review_id;

        if ($avatar_ext && $avatar_ext !== "") {
            $this->avatar_image = $GLOBALS['user_avatar_path']."/${user_id}.${avatar_ext}";
        } else {
            $this->avatar_image = $GLOBALS['style_folder']."/images/default_avatar_image.png";
        }

        $oldcomment = $comment;
        $oldcomment = nl2br($oldcomment);
        $oldcomment = InsertALCode($oldcomment);
        $oldcomment = trim($oldcomment);
        $oldcomment = RemoveSmillies($oldcomment);
        $this->comment = stripslashes($oldcomment);

        if ($join_date == "") {
            $this->join_date = "unknown";
        } else {
            $this->join_date = date("d-m-y", $join_date);
        }
        $this->post_date = date("F j, Y", $timestamp);
    }

    public function getCommentsId() {
        return $this->comments_id;
    }

    public function getTimestamp() {
        return $this->timestamp;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getUser() {
        return $this->userid;
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

    public function getPostDate() {
        return $this->post_date;
    }

    public function getAvatarImage() {
        return $this->avatar_image;
    }

    public function getGameId() {
        return $this->game_id;
    }
    
    public function getReviewId() {
        return $this->review_id;
    }

    public function getGameName() {
        return $this->game_name;
    }

    public function getCommentType() {
        return $this->comment_type;
    }

    public function getComments() {
        return $this->comment;
    }

    public function getUserCommentCount() {
        return $this->user_comment_count;
    }

    public function getUserSubCount() {
        return $this->user_subm_count;
    }
}

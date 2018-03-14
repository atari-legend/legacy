<?php
namespace AL\Common\Model\NewsSubmission;

use AL\Common\DAO\NewsSubmissionDAO;

require_once __DIR__."/../../../config/config.php";
require_once __DIR__."/../../../lib/functions.php";

/**
 * Maps to the `newssubmissions`, `news_image` and `user` tables
 */
class NewsSubmission {
    private $id;
    private $headline;
    private $text;
    private $date;
    private $image;
    private $userid;
    private $username;
    private $email;
    private $join_date;
    private $karma;
    private $avatar_ext;
    private $user_subm_count;

    public function __construct(
        $id,
        $headline,
        $text,
        $date,
        $image,
        $userid,
        $username,
        $email,
        $join_date,
        $karma,
        $avatar_ext,
        $user_subm_count
    ) {
        $this->id = $id;
        $this->headline = $headline;
        $this->text = $text;
        $this->date = $date;
        $this->userid = $userid;
        $this->username = $username;
        $this->email = $email;
        $this->join_date = $join_date;
        $this->karma = $karma;
        $this->user_subm_count = $user_subm_count;
        
        if ($avatar_ext && $avatar_ext !== "") {
            $this->avatar_image = $GLOBALS['user_avatar_path']."/${user_id}.${avatar_ext}";
        } else {
            $this->avatar_image = $GLOBALS['style_folder']."/images/default_avatar_image.png";
        }

        if ($image) {
            $this->image = $GLOBALS['news_images_path']."/${image}";
        }
    }

    public function getId() {
        return $this->id;
    }

    public function getHeadline() {
        return $this->headline;
    }

    public function getText() {
        return $this->text;
    }

    public function getDate() {
        return $this->date;
    }

    public function getImage() {
        return $this->image;
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
        return $this->join_date;
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

    /**
     * @return The HTML-ized version of the text (with the AL code
     *  rendered to HTML and smilies removed)
     */
    public function getHtmlText() {
        return InsertALCode(RemoveSmillies($this->text));
    }
}

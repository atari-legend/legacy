<?php
namespace AL\Common\Model\News;

require_once __DIR__."/../../../config/config.php";
require_once __DIR__."/../../../lib/functions.php";

/**
 * Maps to the `news` and `news_image` tables
 */
class News {
    private $id;
    private $headline;
    private $text;
    private $date;
    private $image;
    private $image_id;
    private $userid;

    public function __construct(
        $id,
        $headline,
        $text,
        $date,
        $image,
        $image_id,
        $user
    ) {
        $this->id = $id;
        $this->headline = $headline;
        $this->text = $text;
        $this->date = $date;
        $this->user = $user;
        $this->image_id = $image_id;

        if ($image != null) {
            $this->image = $GLOBALS['news_images_path'].$image;
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

    public function getImageId() {
        return $this->image_id;
    }

    public function getUser() {
        return $this->user;
    }

    /**
     * @return The HTML-ized version of the text (with the AL code
     *  rendered to HTML and smilies removed)
     */
    public function getHtmlText() {
        return InsertALCode(RemoveSmillies($this->text));
    }
}

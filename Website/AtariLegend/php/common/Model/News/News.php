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
    private $user;

    public function __construct($id, $headline, $text, $date, $image, $user) {
        $this->id = $id;
        $this->headline = $headline;
        $this->text = $text;
        $this->date = $date;
        $this->user = $user;

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

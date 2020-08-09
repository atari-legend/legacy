<?php
namespace AL\Common\Model\Article;

require_once __DIR__."/../../../lib/functions.php";

/**
 * Maps to the `article_main` and `article_text` tables
 */
class Article {
    private $id;
    private $title;
    private $intro;
    private $date;
    private $user;

    public function __construct($id, $title, $intro, $date, $user) {
        $this->id = $id;
        $this->title = $title;
        $this->intro = $intro;
        $this->date = $date;
        $this->user = $user;
    }

    public function getId() {
        return $this->id;
    }
    
    public function getTitle() {
        return $this->title;
    }

    public function getIntro() {
        return $this->intro;
    }

    public function getDate() {
        return $this->date;
    }

    public function getUser() {
        return $this->user;
    }

    /**
     * @return string The HTML text for the intro
     */
    public function getIntroHtml() {
        return InsertALCode(RemoveSmillies($this->intro));
    }
}

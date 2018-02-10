<?php
namespace AL\Common\Model\Interview;

require_once __DIR__."/../../../lib/functions.php";

/**
 * Maps to the `interview_main` and `interview_text` tables
 */
class Interview {
    private $id;
    private $intro;
    private $date;
    private $user;
    private $individual;

    public function __construct($id, $intro, $date, $user, $individual) {
        $this->id = $id;
        $this->intro = $intro;
        $this->date = $date;
        $this->user = $user;
        $this->individual = $individual;
    }

    public function getId() {
        return $this->id;
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

    public function getIndividual() {
        return $this->individual;
    }

    /**
     * @return string The HTML text for the intro
     */
    public function getIntroHtml() {
        return InsertALCode(RemoveSmillies($this->intro));
    }
}

<?php
namespace AL\Common\Model\Review;

require_once __DIR__."/../../../lib/functions.php";

/**
 * Maps to the `review_game` and `review_main` tables
 */
class GameReview {
    private $id;
    private $text;
    private $date;
    private $user;
    private $game_name;

    public function __construct($id, $text, $date, $user, $game_name) {
        $this->id = $id;
        $this->text = $text;
        $this->date = $date;
        $this->user = $user;
        $this->game_name = $game_name;
    }

    public function getId() {
        return $this->id;
    }

    public function getText() {
        return $this->text;
    }

    public function getDate() {
        return $this->date;
    }

    public function getUser() {
        return $this->user;
    }

    public function getGameName() {
        return $this->game_name;
    }

    /**
     * @return string The HTML text for the frontpage
     */
    public function getFrontPageHtml() {
        $pos_start = strpos($this->text, '[frontpage]');
        $pos_end = strpos($this->text, '[/frontpage]');
        $nr_char = $pos_end - $pos_start;
        $frontpage = substr($this->text, $pos_start, $nr_char);
        return InsertALCode(RemoveSmillies($frontpage));
    }
}

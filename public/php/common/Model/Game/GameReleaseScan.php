<?php
namespace AL\Common\Model\Game;

/**
 * Maps to the `game_release_scans` table
 */
class GameReleaseScan {
    private $id;
    private $game_release_id;
    private $type;
    private $notes;
    private $image;
    private $file;

    public function __construct($id, $game_release_id, $type, $imgext, $notes) {
        $this->id = $id;
        $this->game_release_id = $game_release_id;
        $this->type = $type;
        $this->notes = $notes;

        if ($imgext && $imgext !== "") {
            $this->image = $GLOBALS['game_release_scan_path']."{$id}.{$imgext}";
        }

        if ($imgext && $imgext !== "") {
            $this->file = $GLOBALS['game_release_scan_save_path']."{$id}.{$imgext}";
        }
    }

    public function getId() {
        return $this->id;
    }

    public function getImage() {
        return $this->image;
    }

    public function getFile() {
        return $this->file;
    }

    public function getType() {
        return $this->type;
    }

    public function getNotes() {
        return $this->notes;
    }
}

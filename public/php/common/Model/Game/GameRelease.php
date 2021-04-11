<?php
namespace AL\Common\Model\Game;

/**
 * Maps to the `game_release` table
 */
class GameRelease {
    private $id;
    private $game_id;
    private $name;
    private $date;
    private $license;
    private $type;
    private $publisher;
    private $status;
    private $hd_installable;
    private $notes;
    private $menu;

    public function __construct(
        $id,
        $game_id,
        $name,
        $date,
        $license,
        $type,
        $publisher,
        $status,
        $hd_installable,
        $notes,
        $menu
    ) {
        $this->id = $id;
        $this->game_id = $game_id;
        $this->name = $name;
        $this->date = $date;
        $this->license = $license;
        $this->type = $type;
        $this->publisher = $publisher;
        $this->status = $status;
        $this->hd_installable = $hd_installable;
        $this->notes = $notes;
        $this->menu = trim($menu);
    }

    public function getId() {
        return $this->id;
    }

    public function getGameId() {
        return $this->game_id;
    }

    public function getDate() {
        return $this->date;
    }

    public function getName() {
        return $this->name;
    }

    public function getLicense() {
        return $this->license;
    }

    public function getType() {
        return $this->type;
    }

    public function getPublisher() {
        return $this->publisher;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getHdInstallable() {
        return $this->hd_installable;
    }

    public function getNotes() {
        return $this->notes;
    }

    public function getMenu() {
        return $this->menu;
    }
}

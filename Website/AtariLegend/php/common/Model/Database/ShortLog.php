<?php
namespace AL\Common\Model\Database;

/**
 * Maps to the `change_log` table
 */
class ShortLog {
    private $id;
    private $section;
    private $section_id;
    private $section_name;
    private $sub_section;
    private $sub_section_id;
    private $sub_section_name;
    private $user_id;
    private $user_name;
    private $action;
    private $timestamp;
    private $shortlog;

    public function __construct(
        $id,
        $section,
        $section_id,
        $section_name,
        $sub_section,
        $sub_section_id,
        $sub_section_name,
        $user_id,
        $user_name,
        $action,
        $timestamp
    ) {
        $this->id = $id;
        $this->section = $section;
        $this->section_id = $section_id;
        $this->section_name = $section_name;
        $this->sub_section = $sub_section;
        $this->sub_section_id = $sub_section_id;
        $this->sub_section_name = $sub_section_name;
        $this->user_id = $user_id;
        $this->user_name = $user_name;
        $this->action = $action;
        $this->timestamp = $timestamp;

        if ($section="Games") {
            $section_games = array(
                "Box back" => array(
                    "Update" => "Updated the boxscan of $section_name",
                    "Insert" => "Added boxscan to $section_name",
                    "Delete" =>"Removed a boxscan from $section_name"),
                "Box front" => array(
                    "Update" => "Updated the boxscan of $section_name",
                    "Insert" => "Added boxscan to $section_name",
                    "Delete" => "Removed a boxscan from $section_name"),
                "Screenshot" => array(
                    "Update" => "Updated the screenshots of $section_name",
                    "Insert" => "Added a screenshot to $section_name",
                    "Delete" => "Removed a screenshot from $section_name"),
                "Developer" => array(
                    "Update" => "Updated the developer of $section_name",
                    "Insert" => "Added $sub_section_name to $section_name",
                    "Delete" => "Removed $sub_section_name from $section_name"),
                "Publisher" => array(
                    "Update" => "Updated the publisher of $section_name",
                    "Insert" => "Added $sub_section_name to $section_name",
                    "Delete" => "Removed $sub_section_name from $section_name"),
                "Release" => array(
                    "Update" => "Updated a release of $section_name",
                    "Insert" => "Added a release to $section_name",
                    "Delete" => "Removed a release from $section_name"),
                "Creator" => array(
                    "Update" => "Updated $section_name",
                    "Insert" => "Added $sub_section_name to $section_name",
                    "Delete" => "Removed $sub_section_name from $section_name"),
                "Author" => array(
                    "Update" => "Updated $section_name",
                    "Insert" => "Added $sub_section_name to $section_name",
                    "Delete" => "Removed $sub_section_name from $section_name"),
                "Similar" => array(
                    "Update" => "Updated $section_name",
                    "Insert" => "Added $sub_section_name as similar to $section_name",
                    "Delete" => "Updated $section_name"),
                "Game" => array(
                    "Update" => "Updated $section_name",
                    "Insert" => "Added a new game: $section_name",
                    "Delete" => "Removed $section_name"),
                "AKA" => array(
                    "Update" => "Updated $section_name",
                    "Insert" => "Added $sub_section_name to $section_name",
                    "Delete" => "Removed $sub_section_name from $section_name"),
            );

            $shortlog = "";

            $shortlog = $section_games[$sub_section][$action];

            $this->shortlog = $shortlog;
        }
    }

    public function getId() {
        return $this->id;
    }

    public function getSection() {
        return $this->section;
    }

    public function getSectionId() {
        return $this->section_id;
    }

    public function getSectionName() {
        return $this->section_name;
    }

    public function getSubSection() {
        return $this->sub_section;
    }

    public function getSubSectionId() {
        return $this->sub_section_id;
    }

    public function getSubSectionName() {
        return $this->sub_section_name;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getUserName() {
        return $this->user_name;
    }

    public function getAction() {
        return $this->action;
    }

    public function getTimestamp() {
        return $this->timestamp;
    }

    public function getShortlog() {
        return $this->shortlog;
    }
}

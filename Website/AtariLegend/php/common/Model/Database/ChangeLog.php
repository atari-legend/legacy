<?php
namespace AL\Common\Model\Database;

/**
 * Maps to the `change_log` table
 */
class ChangeLog {

    const ACTION_UPDATE = "Update";
    const ACTION_INSERT = "Insert";
    const ACTION_DELETE = "Delete";

    /** Permitted DB actions */
    const ACTIONS = array(self::ACTION_UPDATE, self::ACTION_INSERT, self::ACTION_DELETE);

    /** List of permitted sections and sub-sections */
    const SECTIONS = array(
        "Articles" => array("Article"),
        "Author type" => array("Author type"),
        "Bug type" => array("Bug type"),
        "Company" => array("Company", "Logo"),
        "Downloads" => array("Crew", "Details", "TOS"),
        "Format" => array("Format"),
        "Game series" => array("Game", "Series"),
        "Games" => array("AKA", "Box back", "Box front", "Comment","Creator",
            "Developer", "Fact", "File", "Mag score", "Music","Game", "Publisher",
            "Review", "Review comment", "Screenshot", "Similar", "Submission", "Year"
        ),
        "Individuals" => array("Image", "Individual", "Nickname"),
        "Interviews" => array("Comment", "Interview", "Screenshots"),
        "Lingo" => array("Lingo"),
        "Links" => array("Category", "Link", "Link submit"),
        "Links cat" => array("Category"),
        "Menu disk" => array("Game", "Menu disk"),
        "Menu set" => array("Menu disk (multiple)", "Menu set", "Menu type"),
        "Menu type" => array("Menu type"),
        "News" => array("Image", "News item", "News submit"),
        "Reviews" => array("Comment"),
        "TOS" => array("TOS"),
        "Trivia" => array("DYK", "Quote", "Spotlight"),
        "Users" => array("Avatar", "User")
    );

    private $id;
    private $section;
    private $section_id;
    private $section_value;
    private $sub_section;
    private $sub_section_id;
    private $sub_section_value;
    private $user_id;
    private $action;
    private $timestamp;

    public function __construct(
        $id,
        $section,
        $section_id,
        $section_value,
        $sub_section,
        $sub_section_id,
        $sub_section_value,
        $user_id,
        $action
    ) {

        $this->id = $id;

        // Check if the section is valid
        if (! array_key_exists($section, self::SECTIONS)) {
            die("Unknown section '$section'. Only "
                .join(", ", array_keys(self::SECTIONS))." are supported");
        }
        $this->section = $section;
        $this->section_id = $section_id;
        $this->section_value = $section_value;

        // Check is the sub-section is valid for the section
        if (! in_array($sub_section, self::SECTIONS[$section])) {
            die("Unknown sub-section '$sub_section'. Only "
                .join(", ", self::SECTIONS[$section])." are supported for $section");
        }
        $this->sub_section = $sub_section;
        $this->sub_section_id = $sub_section_id;
        $this->sub_section_value = $sub_section_value;

        $this->user_id = $user_id;

        // Check if the action is valid
        if (! in_array($action, self::ACTIONS)) {
            die("Unknown action '$action'. Only ".self::ACTIONS." are supported");
        }
        $this->action = $action;

        $this->timestamp = time();
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

    public function getSectionValue() {
        return $this->section_value;
    }

    public function getSubSection() {
        return $this->sub_section;
    }

    public function getSubSectionId() {
        return $this->sub_section_id;
    }

    public function getSubSectionValue() {
        return $this->sub_section_value;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getAction() {
        return $this->action;
    }

    public function getTimestamp() {
        return $this->timestamp;
    }
}

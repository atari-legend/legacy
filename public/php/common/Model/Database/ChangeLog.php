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
            "Review", "Review comment", "Screenshot", "Similar", "Submission", "Year",
            "Release", "Sound hardware"
        ),
        "Game Release" => array("Scan"),
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
    private $user;

    public function __construct(
        $id,
        $section,
        $section_id,
        $section_value,
        $sub_section,
        $sub_section_id,
        $sub_section_value,
        $user_id,
        $action,
        $timestamp = null
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

        if ($timestamp == null) {
            $this->timestamp = time();
        } else {
            $this->timestamp = $timestamp;
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

    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
    }

    public function getShortLogMessage() {
        $section_name = $this->section_value;
        $sub_section_name = $this->sub_section_value;
        $messages = array(
            "Games" => array(
                "AKA" => array(
                    "Update" => "Updated $section_name",
                    "Insert" => "Added $sub_section_name to $section_name",
                    "Delete" => "Removed $sub_section_name from $section_name"),
                "Box back" => array(
                    "Update" => "Updated the boxscan of $section_name",
                    "Insert" => "Added boxscan to $section_name",
                    "Delete" =>"Removed a boxscan from $section_name"),
                "Box front" => array(
                    "Update" => "Updated the boxscan of $section_name",
                    "Insert" => "Added boxscan to $section_name",
                    "Delete" => "Removed a boxscan from $section_name"),
                "Comment" => array(
                    "Update" => "Updated a comment on $section_name",
                    "Insert" => "Added a comment on $section_name",
                    "Delete" => "Removed a comment on $section_name"),
                "Creator" => array(
                    "Update" => "Updated $section_name",
                    "Insert" => "Added $sub_section_name to $section_name",
                    "Delete" => "Removed $sub_section_name from $section_name"),
                "Developer" => array(
                    "Update" => "Updated the developer of $section_name",
                    "Insert" => "Added $sub_section_name to $section_name",
                    "Delete" => "Removed $sub_section_name from $section_name"),
                "Fact" => array(
                    "Update" => "Updated $section_name",
                    "Insert" => "Added fact to $section_name",
                    "Delete" =>"Removed a fact from $section_name"),
                "File" => array(
                    "Update" => "Updated $section_name",
                    "Insert" => "Added a file to $section_name",
                    "Delete" =>"Removed a file from $section_name"),
                "Mag score" => array(
                    "Update" => "Updated $section_name",
                    "Insert" => "Added a mag score to $section_name",
                    "Delete" =>"Removed a mag score from $section_name"),
                "Music" => array(
                    "Update" => "Updated $section_name",
                    "Insert" => "Added music to $section_name",
                    "Delete" =>"Removed music from $section_name"),
                "Game" => array(
                    "Update" => "Updated $section_name",
                    "Insert" => "Added a new game: $section_name",
                    "Delete" => "Removed $section_name"),
                "Publisher" => array(
                    "Update" => "Updated the publisher of $section_name",
                    "Insert" => "Added $sub_section_name to $section_name",
                    "Delete" => "Removed $sub_section_name from $section_name"),
                "Review" => array(
                    "Update" => "Updated a review of $sub_section_name",
                    "Insert" => "Added a review to $section_name",
                    "Delete" => "Removed a review from $section_name"),
                "Release" => array(
                    "Update" => "Updated a release of $section_name",
                    "Insert" => "Added a release to $section_name",
                    "Delete" => "Removed a release from $section_name"),
                "Screenshot" => array(
                    "Update" => "Updated the screenshots of $section_name",
                    "Insert" => "Added a screenshot to $section_name",
                    "Delete" => "Removed a screenshot from $section_name"),
                "Similar" => array(
                    "Update" => "Updated $section_name",
                    "Insert" => "Added $sub_section_name as similar to $section_name",
                    "Delete" => "Updated $section_name"),
                "Sound hardware" => array(
                    "Update" => "Updated $section_name",
                    "Insert" => "Added sound hardware to $section_name",
                    "Delete" => "Updated $section_name"),
                "Submission" => array(
                    "Update" => "Updated info submission for $section_name",
                    "Insert" => "Submitted info for $section_name",
                    "Delete" => "Removed an info submission for $section_name"),
            )
        );

        if (array_key_exists($this->section, $messages)
            && array_key_exists($this->sub_section, $messages[$this->section])
            && array_key_exists($this->action, $messages[$this->section][$this->sub_section])) {
            return $messages[$this->section][$this->sub_section][$this->action];
        } else {
            return "ERROR: Message missing in ChangeLog.php for section {$this->section},
                sub-section {$this->sub_section}, action {$this->action}";
        }
    }
}

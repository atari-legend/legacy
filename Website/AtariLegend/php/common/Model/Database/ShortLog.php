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
            $shortlog = "$user_name ";

            if ($sub_section =="Box back" or $sub_section =="Box front") {
                if ($action == "Update") {
                    $shortlog .= "updated the boxscan of $section_name";
                }
                if ($action == "Insert") {
                    $shortlog .= "added boxscan to $section_name";
                }
                if ($action == "Delete") {
                    $shortlog .= "removed a boxscan from $section_name";
                }
            }
            if ($sub_section =="Screenshot") {
                if ($action == "Update") {
                    $shortlog .= "updated the screenshots of $section_name";
                }
                if ($action == "Insert") {
                    $shortlog .= "added a screenshot to $section_name";
                }
                if ($action == "Delete") {
                    $shortlog .= "removed a screenshot from $section_name";
                }
            }
            if ($sub_section =="Developer" or $sub_section =="Publisher") {
                if ($action == "Update") {
                    $shortlog .= "updated the developer of $section_name";
                }
                if ($action == "Insert") {
                    $shortlog .= "added $sub_section_name to $section_name";
                }
                if ($action == "Delete") {
                    $shortlog .= "removed $sub_section_name from $section_name";
                }
            }
            if ($sub_section =="Release") {
                if ($action == "Update") {
                    $shortlog .= "updated a release of $section_name";
                }
                if ($action == "Insert") {
                    $shortlog .= "added a release to $section_name";
                }
                if ($action == "Delete") {
                    $shortlog .= "removed a release from $section_name";
                }
            }
            if ($sub_section =="Creator") {
                if ($action == "Update") {
                    $shortlog .= "updated $section_name";
                }
                if ($action == "Insert") {
                    $shortlog .= "added $sub_section_name to $section_name";
                }
                if ($action == "Delete") {
                    $shortlog .= "removed $sub_section_name from $section_name";
                }
            }
            if ($sub_section =="Author") {
                if ($action == "Update") {
                    $shortlog .= "updated $section_name";
                }
                if ($action == "Insert") {
                    $shortlog .= "added $sub_section_name to $section_name";
                }
                if ($action == "Delete") {
                    $shortlog .= "removed $sub_section_name from $section_name";
                }
            }
            if ($sub_section =="Similar") {
                if ($action == "Update") {
                    $shortlog .= "updated $section_name";
                }
                if ($action == "Insert") {
                    $shortlog .= "added $sub_section_name as similar to $section_name";
                }
                if ($action == "Delete") {
                    $shortlog .= "updated $section_name";
                }
            }
            if ($sub_section =="Game") {
                if ($action == "Update") {
                    $shortlog .= "updated $section_name";
                }
                if ($action == "Insert") {
                    $shortlog .= "added a new game: $section_name";
                }
                if ($action == "Delete") {
                    $shortlog .= "removed $section_name";
                }
            }
            if ($sub_section =="AKA") {
                if ($action == "Update") {
                    $shortlog .= "updated $section_name";
                }
                if ($action == "Insert") {
                    $shortlog .= "added $sub_section_name to $section_name";
                }
                if ($action == "Delete") {
                    $shortlog .= "removed $sub_section_name from $section_name";
                }
            }

            $date = new \DateTime();
            $now = $date->format('U');

            if ($now-$timestamp <60) {
                $diff = $now-$timestamp;
                $shortlog .= " $diff seconds ago";
            }
            if ($now-$timestamp >60 and $now-$timestamp <3600) {
                $diff = $now-$timestamp;
                $diff = floor($diff / 60);
                $shortlog .= " $diff minutes ago";
            }
            if ($now-$timestamp >3600 and $now-$timestamp <86400) {
                $diff = $now-$timestamp;
                $diff = floor($diff / 3600);
                $shortlog .= " $diff hours ago";
            }
            if ($now-$timestamp >86400 and $now-$timestamp <172800) {
                $diff = $now-$timestamp;
                $diff = floor($diff / 3600);
                $shortlog .= " yesterday";
            }
            if ($now-$timestamp >172800) {
                $time = new \DateTime();
                $time->setTimestamp($timestamp);
                $change_date = $time->format('M d');
                $shortlog .= " on $change_date";
            }

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

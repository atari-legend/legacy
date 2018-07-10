<?php
namespace AL\Common\Model\PubDev;

/**
 * Maps to the `pub_dev` table
 */
class PubDev {
    private $id;
    private $name;
    private $profile;
    private $image;

    public function __construct($id, $name, $profile, $imageext) {
        $this->id = $id;
        $this->name = $name;

        if ($profile != '') {
            $this->profile = $profile;
        }

        if ($imageext != null) {
            $this->image = $GLOBALS['company_screenshot_path'].'/'.$id.'.'.$imageext;
        }
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getProfile() {
        return $this->profile;
    }

    public function getImage() {
        return $this->image;
    }
}

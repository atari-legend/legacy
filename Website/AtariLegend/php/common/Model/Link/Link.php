<?php
namespace AL\Common\Model\Link;

require_once __DIR__."/../../../config/config.php";

/**
 * Maps to the `website` table
 */
class Link {
    private $id;
    private $name;
    private $url;
    private $description;
    private $image;
    private $inactive;
    private $user;
    private $date;
    private $userid;
    private $category_name;

    public function __construct($id, $name, $url, $description, $imgext, $inactive, $user, $date, $userid, 
        $category_name) {
        $this->id = $id;
        $this->name = $name;
        $this->url = $url;
        $this->description = $description;
        $this->inactive = $inactive;
        $this->user = $user;
        $this->date = $date;
        $this->userid = $userid;
        $this->category_name = $category_name;

        if ($imgext && $imgext !== "") {
            $this->image = $GLOBALS['website_image_path']."/${id}.${imgext}";
        }
    }

    public function getName() {
        return $this->name;
    }

    public function getUrl() {
        return $this->url;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getImage() {
        return $this->image;
    }

    public function getInactive() {
        return $this->inactive;
    }

    public function getUser() {
        return $this->user;
    }

    public function getUserId() {
        return $this->userid;
    }

    public function getDate() {
        return $this->date;
    }
    
    public function getCategoryName() {
        return $this->category_name;
    }
}

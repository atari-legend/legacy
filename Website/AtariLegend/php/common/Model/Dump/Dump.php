<?php
namespace AL\Common\Model\Dump;

/**
 * Maps to the `Dump` table
 */
class Dump {
    private $id;
    private $media_id;
    private $format;
    private $sha512;
    private $date;
    private $size;
    private $info;
    private $user;

    public function __construct($id, $media_id, $format, $sha512, $date, $size, $info, $user) {
        $this->id = $id;
        $this->format = $format;
        $this->sha512 = $sha512;
        $this->date = $date;
        $this->size = $size;
        $this->info = $info;
        $this->info = $user;
    }

    public function getId() {
        return $this->id;
    }

    public function getMediaId() {
        return $this->media_id;
    }

    public function getFormat() {
        return $this->format;
    }

    public function getSha512() {
        return $this->sha512;
    }

    public function getDate() {
        return $this->date;
    }

    public function getSize() {
        return $this->size;
    }

    public function getInfo() {
        return $this->info;
    }
    
    public function getUser() {
        return $this->user;
    }
}

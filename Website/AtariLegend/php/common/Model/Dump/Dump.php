<?php
namespace AL\Common\Model\Dump;

/**
 * Maps to the `Dump` table
 */
class Dump {
    private $id;
    private $media_id;
    private $format;
    private $hash;
    private $date;
    private $size;
    private $info;

    public function __construct($id, $media_id, $format, $hash, $date, $size, $info) {
        $this->id = $id;
        $this->format = $format;
        $this->hash = $hash;
        $this->date = $date;
        $this->size = $size;
        $this->info = $info;
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
    
    public function getHash() {
        return $this->hash;
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
}

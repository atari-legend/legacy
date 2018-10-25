<?php
namespace AL\Common\Model\Dump;

/**
 * Maps to the `Dump` table
 */
class Dump {
    private $id;
    private $format;
    private $hash;
    private $size;
    private $info;

    public function __construct($id, $format, $hash, $size, $info) {
        $this->id = $id;
        $this->format = $format;
        $this->hash = $hash;
        $this->size = $size;
        $this->info = $info;
    }

    public function getId() {
        return $this->id;
    }
   
    public function getFormat() {
        return $this->format;
    }
    
    public function getHash() {
        return $this->hash;
    }
    
    public function getSize() {
        return $this->size;
    }
    
    public function getInfo() {
        return $this->info;
    }
}

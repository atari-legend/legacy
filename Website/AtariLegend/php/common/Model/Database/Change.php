<?php
namespace AL\Common\Model\Database;

/**
 * Maps to the `database_change` table
 */
class Change {
    private $id;
    private $update_id;
    private $description;
    private $timestamp;
    private $state;
    private $filename;
    private $script;

    public function __construct(
        $id,
        $update_id,
        $description,
        $timestamp,
        $state,
        $filename,
        $script
    ) {
        $this->id = $id;
        $this->update_id = $update_id;
        $this->description = $description;
        $this->timestamp = $timestamp;
        $this->state = $state;
        $this->filename = $filename;
        $this->script = $script;
    }

    public function getUpdateId() {
        return $this->update_id;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getTimestamp() {
        return $this->timestamp;
    }

    public function getState() {
        return $this->state;
    }

    public function getFilename() {
        return $this->filename;
    }

    public function getScript() {
        return $this->script;
    }
}

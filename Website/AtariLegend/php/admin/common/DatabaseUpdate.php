<?php
namespace AL\Admin\Common;

/** A database update script to execute */
class DatabaseUpdate {
    const EXECUTE_ON_SUCCESS = "success";
    const EXECUTE_ON_FAILURE = "failure";

    /** Permitted values for 'execute_on' */
    const EXECUTE_ON = array(DatabaseUpdate::EXECUTE_ON_SUCCESS, DatabaseUpdate::EXECUTE_ON_FAILURE);

    private $id;

    /** Path to the INI file */
    private $filename;

    private $description;

    /** SQL Condition to check */
    private $condition;

    /** Wether to execute on success or failure */
    private $execute_on;
    private $sql;
    private $autoexecute;

    /** Wether there's an additional PHP script to run */
    private $has_addition_script;

    public function __construct(
        $db_name,
        $id,
        $filename,
        $description,
        $condition,
        $execute_on,
        $sql,
        $autoexecute,
        $disable_fk,
        $has_addition_script
    ) {
        if (!is_int($id)) {
            die("id must be an integer, but was: '$id'");
        }
        $this->id = $id;
        $this->filename = $filename;
        $this->description = $description;

        if (!in_array($execute_on, DatabaseUpdate::EXECUTE_ON)) {
            die("Invalid value '$execute_on' for 'execute_on'. Only "
                .join(", ", DatabaseUpdate::EXECUTE_ON)." are supported");
        }
        $this->execute_on = $execute_on;
        $this->condition = str_replace("__DBNAME__", $db_name, $condition);
        ;
        $this->sql = $sql;

        if (!is_bool($autoexecute)) {
            die("autoexecute must be a boolean, but was: '$autoexecute'");
        }
        $this->autoexecute = $autoexecute;

        if (!is_bool($disable_fk)) {
            die("disable_fk must be a boolean, but was: '$disable_fk'");
        }
        $this->disable_fk = $disable_fk;

        if (!is_bool($has_addition_script)) {
            die("has_addition_script must be a boolean, but was: '$has_addition_script'");
        }
        $this->has_addition_script = $has_addition_script;
    }

    public function getId() {
        return $this->id;
    }

    public function getFilename() {
        return $this->filename;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getCondition() {
        return $this->condition;
    }

    public function getExecuteOn() {
        return $this->execute_on;
    }

    public function getSql() {
        return $this->sql;
    }

    public function getAutoExecute() {
        return $this->autoexecute;
    }

    public function getDisableForeignKeyChecks() {
        return $this->disable_fk;
    }

    public function hasAdditionScript() {
        return $this->has_addition_script;
    }
}

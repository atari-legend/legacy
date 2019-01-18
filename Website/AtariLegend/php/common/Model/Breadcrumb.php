<?php
namespace AL\Common\Model;

/**
 * A single breadcrumb entry
 */
class Breadcrumb {
    private $link;
    private $label;

    public function __construct(
        $link,
        $label
    ) {
        $this->link = $link;
        $this->label = $label;
    }

    public function getLink() {
        return $this->link;
    }

    public function getLabel() {
        return $this->label;
    }
}

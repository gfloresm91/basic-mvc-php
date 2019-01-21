<?php

namespace App\Models;

class BaseElement implements Printable
{
    private $_title;
    public $description;
    public $visible = true;
    public $months;

    public function __construct($title, $description)
    {
        $this->setTitle($title);
        $this->description = $description;
    }

    public function setTitle($title)
    {
        if ($title == '') {
            $this->_title = 'N/A';
        } else {
            $this->_title = $title;
        }
    }

    public function getTitle()
    {
        return $this->_title;
    }

    public function getDurationAsString()
    {
        $years = floor($this->months / 12);
        $extraMonths = $this->months % 12;

        return "$years years $extraMonths months";
    }

    public function getDescription()
    {
        return $this->description;
    }
}

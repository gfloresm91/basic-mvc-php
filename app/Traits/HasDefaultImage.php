<?php

namespace App\traits;

trait HasDefaultImage
{
    public function getImage($altText)
    {
        if (!$this->filename) {
            return "https://ui-avatars.com/api/?name=$altText&size=160";
        }
        return $this->filename;
    }
}

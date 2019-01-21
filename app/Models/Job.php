<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\traits\HasDefaultImage;

class Job extends Model
{
    use HasDefaultImage;
    protected $table = 'jobs';

    public function getDurationAsString()
    {
        $years = floor($this->months / 12);
        $extraMonths = $this->months % 12;

        return "Job duration: $years years $extraMonths months";
    }
}

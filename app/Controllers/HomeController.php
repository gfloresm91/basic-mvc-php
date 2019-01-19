<?php

namespace App\Controllers;

use App\Models\{ Job, Project };

class HomeController {
    public function homeAction() {
        $jobs = Job::all();
        $projects = Project::all();

        $name = 'Example Name';
        $limitMonths = 2000;

        include '../Views/index.php';
    }
}
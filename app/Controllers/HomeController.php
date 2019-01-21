<?php

namespace App\Controllers;

use App\Models\Job;
use App\Models\Project;

class HomeController extends BaseController
{
    public function homeAction()
    {
        $jobs = Job::all();
        $projects = Project::all();

        $name = 'Example Name';
        $limitMonths = 2000;

        return $this->renderHTML(
            'index.twig', [
            'name' => $name,
            'jobs' => $jobs,
            'projects' => $projects,
            ]
        );
    }
}

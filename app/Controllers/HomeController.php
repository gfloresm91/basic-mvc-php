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
        
        $limitMonths = 15;
        $filterFunction = function ($job) use ($limitMonths) {
            return $job['months'] >= $limitMonths;
        };

        $jobs = array_filter(
            $jobs->toArray(),
            $filterFunction
        );

        return $this->renderHTML(
            'index.twig',
            [
            'name' => $name,
            'jobs' => $jobs,
            'projects' => $projects,
            ]
        );
    }
}

<?php

namespace App\Controllers;

use App\Models\Project;

class ProjectsController {
    public function getaddProjectAction($request) {
        if($request->getMethod() == 'POST')
        {
            $data = $request->getParsedBody();
            $project = new Project();
            $project->title = $data['title'];
            $project->description = $data['description'];
            $project->save();
        }

        include '../views/addProject.php';
    }
}
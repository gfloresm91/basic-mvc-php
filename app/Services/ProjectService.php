<?php

namespace App\Services;

use App\Models\Project;


class ProjectService
{
    public function deleteProject($id)
    {
        $project = Project::find($id);
        $project->delete();
    }
}

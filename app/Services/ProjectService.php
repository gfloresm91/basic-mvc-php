<?php

namespace App\Services;

use App\Models\Project;


class ProjectService
{
    public function deleteProject($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
    }
}

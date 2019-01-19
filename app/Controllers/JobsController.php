<?php

namespace App\Controllers;

use App\Models\Job;

class JobsController {
    public function getaddJobAction($request) {
        if($request->getMethod() == 'POST')
        {
            $data = $request->getParsedBody();
            $job = new Job();
            $job->title = $data['title'];
            $job->description = $data['description'];
            $job->save();
        }

        include '../views/addJob.php';
    }
}
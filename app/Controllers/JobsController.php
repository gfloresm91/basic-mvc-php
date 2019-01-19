<?php

namespace App\Controllers;

use App\Models\Job;

class JobsController extends BaseController {
    public function getaddJobAction($request) {
        if($request->getMethod() == 'POST')
        {
            $data = $request->getParsedBody();
            $job = new Job();
            $job->title = $data['title'];
            $job->description = $data['description'];
            $job->save();
        }

        return $this->renderHTML('addJob.twig');
    }
}
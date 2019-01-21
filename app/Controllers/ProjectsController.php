<?php

namespace App\Controllers;

use App\Models\Project;
use Respect\Validation\Validator;

class ProjectsController extends BaseController
{
    public function getaddProjectAction($request)
    {
        $responseMessage = null;

        if ($request->getMethod() == 'POST') {
            // TODO: Change this implemention of validate
            $data = $request->getParsedBody();

            $projectValidator = Validator::key(
                'title', Validator::stringType()->notEmpty()
            )
            ->key(
                'description', Validator::stringType()->notEmpty()
            );
            
            try {
                $projectValidator->assert($data);
                $project = new Project();
                $project->title = $data['title'];
                $project->description = $data['description'];
                $project->save();

                $responseMessage = 'Success';
            } catch (\Exception $ex) {
                $responseMessage = $ex->getMessage();
            }
        }

        return $this->renderHTML(
            'addProject.twig', [
            'responseMessage' => $responseMessage
            ]
        );
    }
}

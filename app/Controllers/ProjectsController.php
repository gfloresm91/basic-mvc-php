<?php

namespace App\Controllers;

use App\Models\Project;
use Respect\Validation\Validator;
use App\Services\ProjectService;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Response\RedirectResponse;

class ProjectsController extends BaseController
{
    private $_projectService;

    public function __construct(ProjectService $projectService)
    {
        parent::__construct();
        $this->_projectService = $projectService;
    }

    public function indexAction()
    {
        $projects = Project::all();

        return $this->renderHTML('/projects/index.twig', compact('projects'));
    }

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
            'projects/addProject.twig', [
            'responseMessage' => $responseMessage
            ]
        );
    }

    public function deleteAction(ServerRequest $request)
    {
        $params = $request->getQueryParams();
        $this->_projectService->deleteProject($params['id']);

        return new RedirectResponse('/projects');
    }
}

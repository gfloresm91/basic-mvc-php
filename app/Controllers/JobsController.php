<?php

namespace App\Controllers;

use App\Models\Job;
use Respect\Validation\Validator;

class JobsController extends BaseController {
    public function getaddJobAction($request) {
        $responseMessage = null;

        if($request->getMethod() == 'POST')
        {
            // TODO: Change this implemention of validate
            $data = $request->getParsedBody();

            $jobValidator = Validator::key('title', Validator::stringType()->notEmpty())
                                     ->key('description', Validator::stringType()->notEmpty());
            
            try {
                $jobValidator->assert($data);
                
                $job = new Job();
                $job->title = $data['title'];
                $job->description = $data['description'];
                
                // TODO: Validate images
                $files = $request->getUploadedFiles();
                $logoempresa = $files['logoempresa'];

                if ($logoempresa->getError() == UPLOAD_ERR_OK) {
                    $filename = $logoempresa->getClientFilename();
                    $logoempresa->moveTo("uploads/$filename");
                    $job->filename = "uploads/$filename";
                }

                $job->save();

                $responseMessage = 'Success';
            } catch (\Exception $ex) {
                $responseMessage = $ex->getMessage();
            }
        }

        return $this->renderHTML('addJob.twig', [
            'responseMessage' => $responseMessage
        ]);
    }
}
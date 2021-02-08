<?php

namespace App\Controllers;

use App\Models\Job;
use Respect\Validation\Validator as v;


class JobsController extends BaseController {

  public function getAddJobAction($request){
    $responseMessage = null;

    //if(!empty($_POST)){
    if($request->getMethod() == 'POST'){

      $postData = $request->getParsedBody();

      $jobValidator = v::key('title', v::stringType()->notEmpty())
        ->key('description', v::stringType()->notEmpty());

      try{
        $jobValidator->assert($postData);
        $files = $request->getUploadedFiles();
        $logo = $files['logo'];

        if($logo->getError() == UPLOAD_ERR_OK){
          $fileName = $logo->getClientFilename();
          $logo->moveTo("uploads/$fileName");
        }

        $job = new Job();
        $job->title = $postData['title'];
        $job->description = $postData['description'];
        if(isset($fileName)){
          $job->image_name = $fileName;
        }
        $job->save();

        $responseMessage = 'Saved';
      } catch (\Exception $e){
        $responseMessage = $e->getMessage();
      }
      //var_dump($jobValidator->validate($postData)); // true
    }

    //include '../views/addJob.twig';
    return $this->renderHTML('addJob.twig',[
      'responseMessage' => $responseMessage
    ]);
  }
}
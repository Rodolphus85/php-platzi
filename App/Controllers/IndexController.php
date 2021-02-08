<?php

namespace App\Controllers;

use App\Models\{Job, Project};

class IndexController extends BaseController{

  public function indexAction(){

    $jobs = Job::all();

    $projects = Project::all();

    $lastname = 'campos';
    $name = 'Paolo ' . $lastname;
    $limitMeses = 2500;
    $path = 'public/uploads/';

    //include '../views/index.twig';
    return $this->renderHTML('index.twig', [
      'name' => $name,
      'jobs' => $jobs,
      'image_path' =>$path
    ]);
  }
}
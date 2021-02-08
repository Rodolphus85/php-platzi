<?php

use App\Models\{Job, Project};

//use App\Models\{Job, Project, Printable};

/*
$job1 = new Job('PHP developer', 'Esto está bueniiisimo!!!');
$job1->months = 36;

$job2 = new Job('SQL developer','Esto está bueniiisimo!!!');
$job2->months = 12;

$job3 = new Job('','Esto está bueniiisimo!!!');
$job3->months = 37;
*/

$jobs = Job::all();

/*
$jobs = [
  $job1,
  $job2,
  $job3
];
*/

$projects = Project::all();

/*
$project1 = new Project('Project 1','Descripción 1');

$projects = [
  $project1
];
*/

//function printElement(Printable $job){
function printElement($job){
 /*
  if($job->visible == false){
    return;
  }
 */
  echo '<li class="work-position">';
  echo '<h5>' . $job->title . '</h5>';
  echo '<p>' . $job->description . '</p>';
// echo '<h5>' . $job->getTitle() . '</h5>';
//  echo '<p>' . $job->getDescription() . '</p>';
  if(get_class($job) == 'Job'){
    echo '<p>' . $job->getDurationAsstring() . '</p>';
  }
  echo '<strong>Achievements:</strong>';
  echo '<ul>';
  echo '<li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>';
  echo '<li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>';
  echo '<li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>';
  echo '</ul>';
  echo '</li>' ;
}
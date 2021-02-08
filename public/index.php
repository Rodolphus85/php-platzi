<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';

session_start();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

use Illuminate\Database\Capsule\Manager as Capsule;
use App\Models\Job;
use Aura\Router\RouterContainer;

$capsule = new Capsule;

$capsule->addConnection([
  'driver'    => 'mysql',
  'host'      => $_ENV['DB_HOST'],
  'database'  => $_ENV['DB_NAME'],
  'username'  => $_ENV['DB_USER'],
  'password'  => $_ENV['DB_PASS'],
  'charset'   => 'utf8',
  'collation' => 'utf8_unicode_ci',
  'prefix'    => '',
]);

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();
// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

$request = Zend\Diactoros\ServerRequestFactory::fromGlobals(
  $_SERVER,
  $_GET,
  $_POST,
  $_COOKIE,
  $_FILES
);

$routerContainer = new RouterContainer();

$map = $routerContainer->getMap();

//$map->get('index', '/php-platzi/', '../index.twig');
$map->get('index', '/php-platzi/', [
  'controller' => 'App\Controllers\IndexController',
  'action' => 'indexAction'
]);

$map->get('addJobs', '/php-platzi/jobs/add', [
  'controller' => 'App\Controllers\JobsController',
  'action' => 'getAddJobAction',
  'auth' => true
]);

$map->post('saveJobs', '/php-platzi/jobs/add', [
  'controller' => 'App\Controllers\JobsController',
  'action' => 'getAddJobAction'
]);

$map->get('addUsers', '/php-platzi/users/add', [
  'controller' => 'App\Controllers\UsersController',
  'action' => 'getAddUserAction',
  'auth' => true
]);

$map->post('saveUsers', '/php-platzi/users/add', [
  'controller' => 'App\Controllers\UsersController',
  'action' => 'getAddUserAction'
]);

$map->get('loginForm', '/php-platzi/login', [
  'controller' => 'App\Controllers\AuthController',
  'action' => 'getLogin'
]);

$map->post('auth', '/php-platzi/auth', [
  'controller' => 'App\Controllers\AuthController',
  'action' => 'postLogin'
]);

$map->get('logout', '/php-platzi/logout', [
  'controller' => 'App\Controllers\AuthController',
  'action' => 'getLogout'
]);

$map->get('admin', '/php-platzi/admin', [
  'controller' => 'App\Controllers\AdminController',
  'action' => 'getIndex',
  'auth' => true
]);

$matcher = $routerContainer->getMatcher();
$route = $matcher->match($request);

if(!$route){
  echo 'No route';
}else{
  $handlerData = $route->handler;
  $controllerName = $handlerData['controller'];
  $actionName = $handlerData['action'];
  $needsAuth = $handlerData['auth'] ?? false;

  $sessionUserId = $_SESSION['userId'] ?? null;
  if($needsAuth && !$sessionUserId){
    $controllerName = 'App\Controllers\AuthController';
    $actionName = 'getLogin';
  }

  $controller = new $controllerName;
  $response = $controller->$actionName($request);

  foreach($response->getHeaders() as $name => $values){
    foreach($values as $value){
      header(sprintf('%s: %s', $name, $value), false);
    }
  }
  http_response_code($response->getStatusCode());
  echo $response->getBody();
}

//var_dump($route->handler);
//var_dump($request->getUri()->getPath());
/*
$route = $_GET['route'] ?? '/';
//$route = isset($_GET['route']) ? $_GET['route'] : '/';

if($route == '/'){
  require '../index.twig';
}elseif ($route == 'addJob'){
  require '../addJob.twig';
}
*/

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
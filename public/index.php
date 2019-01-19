<?php

// Initialice show errors in PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// PSR-4
require_once '../vendor/autoload.php';

// PSR-7 router
use Aura\Router\RouterContainer;

// DotEnv
$dotenv = Dotenv\Dotenv::create(__DIR__, '../.env');
$dotenv->load();

// Eloquent
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => getenv('DB_HOST'),
    'port'      => getenv('DB_PORT'),
    'database'  => getenv('DB_DATABASE'),
    'username'  => getenv('DB_USERNAME'),
    'password'  => getenv('DB_PASSWORD'),
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

// TODO: sacar esta función de aquí
function printElement($job)
{
  // if ($job->visible == false) {
  //   return;
  // }

  echo '<li class="work-position">';
  echo '<h5>' . $job->title . '</h5>';
  echo '<p>' . $job->description . '</p>';
  echo '<p>' . $job->getDurationAsString() . '</p>';
  echo '<strong>Achievements:</strong>';
  echo '<ul>';
  echo '<li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>';
  echo '<li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>';
  echo '<li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>';
  echo '</ul>';
  echo '</li>';
}

// PSR-7
$request = Zend\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

// PSR-7 router
$routerContainer = new RouterContainer();
$map = $routerContainer->getMap();

// Routes name url file
$map->get('index', '/', [
    'controller' => 'App\Controllers\HomeController',
    'action' => 'homeAction'
]);

$map->get('addJobs', '/jobs/add', [
    'controller' => 'App\Controllers\JobsController',
    'action' => 'getaddJobAction'
]);

$map->post('createJobs', '/jobs/add', [
    'controller' => 'App\Controllers\JobsController',
    'action' => 'getaddJobAction'
]);

$map->get('addProjects', '/projects/add', [
    'controller' => 'App\Controllers\ProjectsController',
    'action' => 'getaddProjectAction'
]);

$map->post('createProjects', '/projects/add', [
    'controller' => 'App\Controllers\ProjectsController',
    'action' => 'getaddProjectAction'
]);

$matcher = $routerContainer->getMatcher();
$route = $matcher->match($request);

if (!$route) {
    echo 'Route not found';
} else {
    $handlerData = $route->handler;
    $controllerName = $handlerData['controller'];
    $actionName = $handlerData['action'];
    
    $controller = new $controllerName;
    $response = $controller->$actionName($request);

    echo $response->getBody();
}

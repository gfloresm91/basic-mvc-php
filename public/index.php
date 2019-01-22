<?php

// Initialice show errors in PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// PSR-4
require_once '../vendor/autoload.php';

session_start();

// PSR-7 router
use Aura\Router\RouterContainer;

// DotEnv
$dotenv = Dotenv\Dotenv::create(__DIR__, '../.env');
$dotenv->load();

use Zend\Diactoros\Response;

// Middleware
use WoohooLabs\Harmony\Harmony;
use WoohooLabs\Harmony\Middleware\HttpHandlerRunnerMiddleware;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;
use WoohooLabs\Harmony\Middleware\DispatcherMiddleware;

// Eloquent
use Illuminate\Database\Capsule\Manager as Capsule;

$container = new DI\Container();

$capsule = new Capsule;

$capsule->addConnection(
    [
        'driver'    => 'mysql',
        'host'      => getenv('DB_HOST'),
        'port'      => getenv('DB_PORT'),
        'database'  => getenv('DB_DATABASE'),
        'username'  => getenv('DB_USERNAME'),
        'password'  => getenv('DB_PASSWORD'),
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ]
);

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
$map->get(
    'index',
    '/',
    [
        'App\Controllers\HomeController',
        'homeAction'
    ]
);

$map->get(
    'indexJobs',
    '/jobs',
    [
        'App\Controllers\JobsController',
        'indexAction'
        
    ]
);

$map->get(
    'addJobs',
    '/jobs/add',
    [
        'App\Controllers\JobsController',
        'getaddJobAction'
        
    ]
);

$map->post(
    'createJobs',
    '/jobs/add',
    [
        'App\Controllers\JobsController',
        'getaddJobAction'
        
    ]
);

$map->get(
    'deleteJobs',
    '/jobs/delete',
    [
        'App\Controllers\JobsController',
        'deleteAction'
        
    ]
);

$map->get(
    'addProjects',
    '/projects/add',
    [
        'App\Controllers\ProjectsController',
        'getaddProjectAction'
        
    ]
);

$map->post(
    'createProjects',
    '/projects/add',
    [
        'App\Controllers\ProjectsController',
        'getaddProjectAction'
        
    ]
);

$map->get(
    'addUsers',
    '/register',
    [
        'App\Controllers\UsersController',
        'getAddUser'
        
    ]
);

$map->post(
    'createUsers',
    '/register',
    [
        'App\Controllers\UsersController',
        'postCreateUser'
        
    ]
);

$map->get(
    'loginForm',
    '/login',
    [
        'App\Controllers\AuthController',
        'getLogin'
    ]
);

$map->post(
    'auth',
    '/auth',
    [
        'App\Controllers\AuthController',
        'postLogin'
    ]
);

$map->get(
    'admin',
    '/admin',
    [
        'App\Controllers\AdminController',
        'getIndex'
        
    ]
);

$map->get(
    'logout',
    '/logout',
    [
        'App\Controllers\AuthController',
        'getLogout'
    ]
);

$matcher = $routerContainer->getMatcher();
$route = $matcher->match($request);

if (!$route) {
    echo 'Route not found';
} else {
    // Middleware section
    $harmony = new Harmony($request, new Response());
    $harmony
        ->addMiddleware(new HttpHandlerRunnerMiddleware(new SapiEmitter()))
        ->addMiddleware(new App\Middlewares\AuthMiddleware())
        ->addMiddleware(new Middlewares\AuraRouter($routerContainer))
        ->addMiddleware(new DispatcherMiddleware($container, 'request-handler'));

    $harmony();
}

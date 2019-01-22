<?php

// Routes name url file

// Home section
$map->get(
    'index',
    '/',
    [
        'App\Controllers\HomeController',
        'homeAction'
    ]
);

// Jobs section
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

// Projects section
$map->get(
    'indexProjects',
    '/projects',
    [
        'App\Controllers\ProjectsController',
        'indexAction'
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
    'deleteProjects',
    '/projects/delete',
    [
        'App\Controllers\ProjectsController',
        'deleteAction'
    ]
);

// Users section 
$map->get(
    'indexUsers',
    '/users',
    [
        'App\Controllers\UsersController',
        'indexAction'
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
    'deleteUsers',
    '/users/delete',
    [
        'App\Controllers\UsersController',
        'deleteAction'
    ]
);

// Authentication section
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
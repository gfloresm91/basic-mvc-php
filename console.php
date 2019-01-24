#!/usr/bin/env php
<?php

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

require_once 'config/eloquent.php';

$application = new Application();

$application->add(new \App\Commands\HelloWorld());
$application->add(new \App\Commands\SendMail());
$application->add(new \App\Commands\CreateUser());

$application->run();
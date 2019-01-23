<?php

// PSR-4
require_once '../vendor/autoload.php';

session_start();

// DotEnv
require_once '../config/dotenv.php';

// Logger
require_once '../config/logger.php';

// Initialice show errors in PHP
require_once '../config/errors.php';

// Eloquent
require_once '../config/eloquent.php';

require_once '../config/psr7-router.php';

require_once '../config/middleware.php';

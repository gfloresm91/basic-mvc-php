<?php

// Initialice show errors in PHP

if (getenv('DEBUG' === 'true')) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}
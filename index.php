<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once './system/config.php';

define('_PATH_', $config['path']);
define('_CONTROLLER_DEFAULT_', 'home');
define('_ACTION_DEFAULT_', 'index');
define('_DIR_CONTROLLERS_', __DIR__ . '/app/controllers/');
define('_DIR_MODELS_', __DIR__ . '/app/models/');
define('_DIR_VIEWS_', __DIR__ . '/app/views/');
define('_DIR_HELPERS_', __DIR__ . '/app/helpers/');

require_once 'system/functions.php';
require_once 'system/Controller.php';
require_once 'system/System.php';

session_name($config['session_name']);
session_start();

$System = new System;

$System->run();

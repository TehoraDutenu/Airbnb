<?php

use Core\App;

require '../vendor/autoload.php';


const DS = DIRECTORY_SEPARATOR;
define('PATH_ROOT', dirname(__DIR__) . DS);


App::getApp()->start();

<?php
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');
define('APP_DEBUG',true);
define('APP_NAME', 'app');
define('APP_PATH', './app/');
define('STATIC_PATH','./Uploads/');
require 'ThinkPHP/ThinkPHP.php';




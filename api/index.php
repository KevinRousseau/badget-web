<?php

define("WWW_ROOT", dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR);

require_once WWW_ROOT. "dao" .DIRECTORY_SEPARATOR. 'UserDAO.php';
require_once WWW_ROOT. "dao" .DIRECTORY_SEPARATOR. 'ChallengeDAO.php';
require_once WWW_ROOT. "api" .DIRECTORY_SEPARATOR. 'Slim'. DIRECTORY_SEPARATOR .'Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

require_once WWW_ROOT. "api" .DIRECTORY_SEPARATOR. "routes" .DIRECTORY_SEPARATOR. 'users.php';
require_once WWW_ROOT. "api" .DIRECTORY_SEPARATOR. "routes" .DIRECTORY_SEPARATOR. 'challenges.php';

$app->run();


<?php

use framework\{Request, Session, Router};

require "../config/setup.php";

$session = new Session();
$request = new Request();

$router = new Router($request);

call_user_func_array($router->getCallback(), [$request, $router, $session, $router->getMatches()]);
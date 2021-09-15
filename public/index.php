<?php

use framework\Request;
use framework\Session;

require "../config/setup.php";

$session = new Session();
$request = new Request();

dump($request->getUri(), $request->getMethod(), $session->getUser());
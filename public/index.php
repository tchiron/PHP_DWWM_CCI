<?php

use framework\Request;
use framework\Session;

require "../config/setup.php";

$session = new Session(
    isset($_SESSION["user"]) ? unserialize($_SESSION["user"]) : null
);
$request = new Request(
    filter_input(INPUT_SERVER, "REQUEST_URI"),
    filter_input(INPUT_SERVER, "REQUEST_METHOD")
);

dump($request->getUri(), $request->getMethod(), $session->getUser());
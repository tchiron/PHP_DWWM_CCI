<?php

namespace controller;

use framework\{Request, Router, Session};

class SignoutController
{
    public function __construct(
        private Request $request,
        private Router  $router,
        private Session $session
    )
    {
    }

    public function index()
    {
        session_destroy();
        unset($_SESSION);
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            null,
            strtotime('yesterday'),
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
        $this->router->redirectToRoute();
    }
}
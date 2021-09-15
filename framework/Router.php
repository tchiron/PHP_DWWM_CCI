<?php

namespace framework;

use Closure;
use controller\{ArticleController,
    UserController,
    SignupController
};

class Router
{
    private Closure $callback;
    private array $matches = [];

    public function __construct(Request $request)
    {
        $this->callback = $this->matchRoute($request->getUri());
    }

    /**
     * Retrouve une action par rapport à la route
     * 
     * @param string $uri route récupéré dans la query string
     * 
     * @return Closure L'action a exécuté
     */
    private function matchRoute(string $uri): Closure
    {
        return match (1) {
            preg_match("#^/$#", $uri),
            preg_match("#^/article$#", $uri) => function (
                Request $request,
                Router $router,
                Session $session
            ) {
                if ("GET" === $request->getMethod())
                    (new ArticleController($request, $router, $session))->index();
                else $this->redirectToRoute("error404");
            },
            preg_match("#^/article/new$#", $uri) => function (
                Request $request,
                Router $router,
                Session $session
            ) {
                if ("GET" === $request->getMethod() || "POST" === $request->getMethod())
                    (new ArticleController($request, $router, $session))->new();
                else $this->redirectToRoute("error404");
            },
            preg_match("#^/article/([0-9]+)/show$#", $uri, $this->matches) => function (
                Request $request,
                Router $router,
                Session $session,
                array $matches
            ) {
                if ("GET" === $request->getMethod())
                    (new ArticleController($request, $router, $session))->show($matches[1]);
                else $this->redirectToRoute("error404");
            },
            preg_match("#^/article/([0-9]+)/edit$#", $uri, $this->matches) => function (
                Request $request,
                Router $router,
                Session $session,
                array $matches
            ) {
                if ("GET" === $request->getMethod() || "POST" === $request->getMethod())
                    (new ArticleController($request, $router, $session))->edit($matches[1]);
                else $this->redirectToRoute("error404");
            },
            preg_match("#^/article/([0-9]+)/delete$#", $uri, $this->matches) => function (
                Request $request,
                Router $router,
                Session $session,
                array $matches
            ) {
                if ("GET" === $request->getMethod())
                    (new ArticleController($request, $router, $session))->delete($matches[1]);
                else $this->redirectToRoute("error404");
            },
            preg_match("#^/user$#", $uri) => function (
                Request $request,
                Router  $router,
                Session $session
            ) {
                if ($request->getMethod() === "GET")
                    (new UserController($request, $router, $session))->index();
                else $this->redirectToRoute("error404");
            },
            preg_match("#^/user/([0-9]+)/show$#", $uri, $this->matches) => function (
                Request $request,
                Router  $router,
                Session $session,
                array   $matches
            ) {
                if ($request->getMethod() === "GET")
                    (new UserController($request, $router, $session))->show($matches[1]);
                else $this->redirectToRoute("error404");
            },
            preg_match("#^/user/([0-9]+)/edit$#", $uri, $this->matches) => function (
                Request $request,
                Router  $router,
                Session $session,
                array   $matches
            ) {
                if ($request->getMethod() === "GET" || $request->getMethod() === "POST")
                    (new UserController($request, $router, $session))->edit($matches[1]);
                else $this->redirectToRoute("error404");
            },
            preg_match("#^/user/([0-9]+)/delete$#", $uri, $this->matches) => function (
                Request $request,
                Router  $router,
                Session $session,
                array   $matches
            ) {
                if ($request->getMethod() === "GET")
                    (new UserController($request, $router, $session))->delete($matches[1]);
                else $this->redirectToRoute("error404");
            },
            preg_match("#^/signup$#", $uri) => function (
                Request $request,
                Router  $router,
                Session $session
            ) {
                if (!is_null($session->getUser()))
                    $this->redirectToRoute();
                elseif ($request->getMethod() === "GET" || $request->getMethod() === "POST")
                    (new SignupController($request, $router, $session))->index();
                else $this->redirectToRoute("error404");
            },
            default => function () {
            }
        };
    }

    /**
     * Get the value of callback
     */
    public function getCallback(): Closure
    {
        return $this->callback;
    }

    /**
     * Get the value of matches
     */
    public function getMatches()
    {
        return $this->matches;
    }

    public function redirectToRoute(mixed ...$uri): void
    {
        if (!is_array($uri)) {
            $uri = [$uri];
        }

        header(sprintf("Location: /%s", implode("/", $uri)));
        exit;
    }
}

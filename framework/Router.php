<?php

namespace framework;

use Closure;
use controller\ArticleController;

class Router
{
    private Closure $callback;
    private array $matches = [];

    public function __construct(Request $request)
    {
        $uri = $request->getUri();

        $this->callback = match (true) {
            1 === preg_match("#^/$#", $uri),
            1 === preg_match("#^/article$#", $uri) => function (
                Request $request,
                Router $router,
                Session $session
            ) {
                if ("GET" === $request->getMethod())
                    (new ArticleController($request, $router, $session))->index();
                else $this->redirectToRoute("error404");
            },
            1 === preg_match("#^/article/new$#", $uri) => function (
                Request $request,
                Router $router,
                Session $session
            ) {
                (new ArticleController($request, $router, $session))->new();
            },
            1 === preg_match("#^/article/([0-9]+)/show$#", $uri, $this->matches) => function (
                Request $request,
                Router $router,
                Session $session,
                array $matches
            ) {
                (new ArticleController($request, $router, $session))->show($matches[1]);
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

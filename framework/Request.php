<?php

namespace framework;

class Request
{
    private string $uri;
    private string $method;
    
    public function __construct()
    {
        $this->uri = filter_input(INPUT_SERVER, "REQUEST_URI");
        $this->method = filter_input(INPUT_SERVER, "REQUEST_METHOD");
    }

    /**
     * Get the value of uri
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * Get the value of method
     */
    public function getMethod(): string
    {
        return $this->method;
    }
}

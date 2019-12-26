<?php

class Router
{
    private $request;
    private $supportedHttpMethods = array(
        "GET",
        "POST",
    );

    public function __construct(IRequest $request)
    {
        $this->request = $request;
    }

    public function __call($name, $args)
    {
        list($route, $callback) = $args;

        if (!in_array(strtoupper($name), $this->supportedHttpMethods)) {
            $this->invalidMethodHandler();
        }

        $this->{strtolower($name)}[$this->formatRoute($route)] = $callback;
    }

    private function formatRoute($route)
    {
        $result = rtrim($route, '/');
        if ($result === '') {
            return '/';
        }

        return $result;
    }

    private function invalidMethodHandler()
    {
        header("{$this->request->serverProtocol} 405 METHOD NOT ALLOWED");
    }

    private function defaultRequestHandler()
    {
        header("{$this->request->serverProtocol} 404 NOT FOUND");
    }

    /**
     * Resolves a route
     */
    public function resolve()
    {
        $methodDictionary = $this->{strtolower($this->request->requestMethod)};
        $formatedRoute = $this->formatRoute($this->request->requestUri);
        $method = $methodDictionary[$formatedRoute];
        if (is_null($method)) {
            $this->defaultRequestHandler();
            return;
        }
        echo call_user_func_array($method, array($this->request));
    }
    public function __destruct()
    {
        $this->resolve();
    }
}

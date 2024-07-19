<?php

class Router
{
    private array $routes;
    public string $listenFor;
    public string $root;

    public function __construct(string $listenFor, string $root)
    {
        $this->listenFor = $listenFor;
        $this->root = $root;
        $this->routes = [];
    }

    public function call(string $request)
    {

        $pattern = "/\/api\/". substr($this->listenFor, 1) ."/";


        if(!preg_match($pattern, $request)) {
            return;
        }

        foreach($this->routes as $route) {
            $fullPath = "/api" . $route["route"];


            if($request === $fullPath && $route["method"] === $_SERVER["REQUEST_METHOD"]) {
                require_once $route["file"];
            }
        }
    }

    public function post(string $route, string $file)
    {
        $routeToPush = [
            "route" => $route === "/" ? $this->listenFor : $this->listenFor . "$route",
            "method" => "POST",
            "file" => $this->root . $file,
        ];

        array_push($this->routes, $routeToPush);
    }
    public function get(string $route, string $file)
    {
        $routeToPush = [
            "route" => $route === "/" ? $this->listenFor : $this->listenFor . "$route",
            "method" => "GET",
            "file" => $this->root . $file,
        ];

        array_push($this->routes, $routeToPush);
    }
    public function put(string $route, string $file)
    {
        $routeToPush = [
            "route" => $route === "/" ? $this->listenFor : $this->listenFor . "$route",
            "method" => "PUT",
            "file" => $this->root . $file,
        ];

        array_push($this->routes, $routeToPush);
    }
    public function delete(string $route, string $file)
    {
        $routeToPush = [
            "route" => $route === "/" ? $this->listenFor : $this->listenFor . "$route",
            "method" => "DELETE",
            "file" => $this->root . $file,
        ];

        array_push($this->routes, $routeToPush);
    }
}

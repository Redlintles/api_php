<?php


/**
 * A Router class to control and redirect requests in a easier way
 */
class Router
{
    /**
     * @var array $routes stores the routes of the Router
     */
    private array $routes;
    /**
     * @var string $listenFor The route path to listen for
     */
    public string $listenFor;
    /**
     * @var string $root the Root dir of the files which will be targeted by the router
     */
    public string $root;

    /**
     * Initializes the router
     * @param string $listenFor the route path to listen for
     * @param string $root the Root dir of the files which will be targeted by the router
     */
    public function __construct(string $listenFor, string $root)
    {
        $this->listenFor = $listenFor;
        $this->root = $root;
        $this->routes = [];
    }

    /**
     * Calls the file which matches request
     * @param string $request A request string for the router to redirect
     */
    public function call(string $request)
    {

        $pattern = "/\/api\/". substr($this->listenFor, 1) ."/";


        if (!preg_match($pattern, $request)) {
            return;
        }

        foreach ($this->routes as $route) {
            $fullPath = "/api" . $route["route"];

            if ($request === $fullPath && $route["method"] === $_SERVER["REQUEST_METHOD"]) {
                require_once $route["file"];
            }
        }
    }
    /**
     * Maps a post request to a file which will handle it
     * @param string $route The route to redirect
     * @param string $file The file which the route will be redirected to, must start with a slash
     */
    public function post(string $route, string $file)
    {
        $routeToPush = [
            "route" => $route === "/" ? $this->listenFor : $this->listenFor . "$route",
            "method" => "POST",
            "file" => $this->root . $file,
        ];

        array_push($this->routes, $routeToPush);
    }
    /**
     * Maps a get request to a file which will handle it
     * @param string $route The route to redirect
     * @param string $file The file which the route will be redirected to, must start with a slash
     */
    public function get(string $route, string $file)
    {
        $routeToPush = [
            "route" => $route === "/" ? $this->listenFor : $this->listenFor . "$route",
            "method" => "GET",
            "file" => $this->root . $file,
        ];

        array_push($this->routes, $routeToPush);
    }
    /**
     * Maps a put request to a file which will handle it
     * @param string $route The route to redirect
     * @param string $file The file which the route will be redirected to, must start with a slash
     */
    public function put(string $route, string $file)
    {
        $routeToPush = [
            "route" => $route === "/" ? $this->listenFor : $this->listenFor . "$route",
            "method" => "PUT",
            "file" => $this->root . $file,
        ];

        array_push($this->routes, $routeToPush);
    }
    /**
     * Maps a delete request to a file which will handle it
     * @param string $route The route to redirect
     * @param string $file The file which the route will be redirected to, must start with a slash
     */
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

<?php


$router = new Router("/permission", __DIR__);

$router->get("/", "/GET.php");
$router->put("/", "/UPDATE.php");

$router->call($request);

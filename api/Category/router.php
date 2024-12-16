<?php


$router = new Router("/category", __DIR__);

$router->get("/", "/GET.php");
$router->post("/", "/POST.php");
$router->delete("/", "/DELETE.php");

$router->call($request);

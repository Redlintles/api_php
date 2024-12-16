<?php



$router = new Router("/discount", __DIR__);

$router->post("/", "/POST.php");
$router->delete("/", "/DELETE.php");

$router->call($request);

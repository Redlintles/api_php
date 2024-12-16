<?php


$router = new Router("/product", __DIR__);

$router->post("/", "/POST.php");
$router->get("/", "/GET.php");
$router->put("/", "/UPDATE.php");
$router->delete("/", "/DELETE.php");
$router->put("/UpdateCategories", "/UpdateCategories.php");

$router->call($request);

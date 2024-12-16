<?php

$router = new Router("/seller", __DIR__);

$router->get("/", "/GET.php");
$router->post("/", "/POST.php");
$router->put("/", "/PUT.php");
$router->delete("/", "/DELETE.php");
$router->call($request);

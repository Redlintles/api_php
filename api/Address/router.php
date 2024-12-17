<?php

$router = new Router("/address", __DIR__);

$router->get("/", "/GET.php");
$router->post("/", "/POST.php");
$router->put("/", "/UPDATE.php");
$router->delete("/", "/DELETE.php");
$router->post("/addOwner", "/AddOwner.php");
$router->delete("/removeOwner", "/RemoveOwner.php");

$router->call($request);

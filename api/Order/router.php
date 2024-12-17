<?php

$router = new Router("/order", __DIR__);

$router->post("/", "/POST.php");
$router->get("/", "/GET.php");


$router->call($request);

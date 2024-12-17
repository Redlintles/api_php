<?php

$router = new Router("/order", __DIR__);

$router->post("/", "/POST.php");


$router->call($request);

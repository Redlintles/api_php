<?php

$router = new Router("/cart", __DIR__);

$router->get("/", "/GET.php");
$router->post("/", "/AddCartProduct.php");
$router->delete("/", "/RemoveCartProduct.php");

$router->call($request);

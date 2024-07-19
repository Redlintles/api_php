<?php


$router = new Router("/product", __DIR__);

$router->post("/", "/POST.php");
$router->get("/", "/GET.php");
$router->put("/", "/UPDATE.php");
$router->delete("/", "/DELETE.php");
$router->put("/categories", "/UpdateCategories.php");

$router->call($request);
// if($_SERVER["REQUEST_METHOD"] === "POST") {
//     require_once __DIR__ . "/POST.php";
// } elseif($_SERVER["REQUEST_METHOD"] === "GET") {
//     require_once __DIR__ . "/GET.php";
// } elseif($request === "/api/product/updateCategories" && $_SERVER["REQUEST_METHOD"] === "PUT") {
//     require_once __DIR__ . "/UpdateCategories.php";
// } elseif($_SERVER["REQUEST_METHOD"] === "PUT") {
//     require_once __DIR__ . "/UPDATE.php";
// } elseif($_SERVER["REQUEST_METHOD"] === "DELETE") {
//     require_once __DIR__ . "/DELETE.php";
// }

<?php

if($_SERVER["REQUEST_METHOD"] === "GET") {
    require_once __DIR__ . "/GET.php";
} elseif($_SERVER["REQUEST_METHOD"] === "POST") {
    require_once __DIR__ . "/POST.php";
}

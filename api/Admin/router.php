<?php

if($_SERVER["REQUEST_METHOD"] === "GET") {
    require __DIR__ . "/GET.php";
} elseif($_SERVER["REQUEST_METHOD"] === "POST") {
    require __DIR__ . "/POST.php";
}

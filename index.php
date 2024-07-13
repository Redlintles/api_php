<?php

require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/generated-conf/config.php";

require_once __DIR__ . "/functions/initDb.php";
require_once __DIR__ . "/functions/apiKeyValidation.php"; // Corrigido o caminho para apiKeyValidation.php
require_once __DIR__ . "/functions/sendResponse.php";
initRoot();

$request = parse_url($_SERVER["REQUEST_URI"])["path"];

// Verifica se a requisição é para uma rota começando com "/api"
if (strpos($request, "/api") === 0) {
    // Realiza a validação da chave API apenas se a requisição é para uma rota "/api"
    if (!apiKeyValidator()) {
        // Chave API inválida, envia resposta de erro e interrompe a execução
        sendResponse(403, true, "Invalid API key, unauthorized");
    }
}

// Roteamento baseado na requisição
switch ($request) {
    case "/":
        echo "<h1>Hello World!</h1>";
        break;
    case "/api/admin":
        require_once __DIR__ . "/api/Admin/router.php";
        break;
    case "/api/permission":
        require_once __DIR__ . "/api/Permission/router.php";
        break;
    case "/api/address":
        require_once __DIR__ . "/api/Address/router.php";
        break;
    case "/api/client":
        require_once __DIR__ . "/api/Client/router.php";
        break;
    case "/api/product":
        require_once __DIR__ . "/api/Product/router.php";
        break;
    case "/api/cart":
        require_once __DIR__ . "/api/Cart/router.php";
        // no break
    default:
        // Rota padrão para tratamento de 404
        sendResponse(404, true, "Page not found");
}

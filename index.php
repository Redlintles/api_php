<?php

require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/conf/config.php";

require __DIR__ . "/functions/initDb.php";
require __DIR__ . "/functions/ApiKeyValidation.php"; // Corrigido o caminho para apiKeyValidation.php

initRoot();

$request = parse_url($_SERVER["REQUEST_URI"])["path"];

// Verifica se a requisição é para uma rota começando com "/api"
if (strpos($request, "/api") === 0) {
    // Realiza a validação da chave API apenas se a requisição é para uma rota "/api"
    if (!apiKeyValidator()) {
        // Chave API inválida, envia resposta de erro e interrompe a execução
        $response = [
            "error" => true,
            "message" => "Invalid API Key, Unauthorized"
        ];

        http_response_code(403);
        echo json_encode($response);
        exit;
    }
}

// Roteamento baseado na requisição
switch ($request) {
    case "/":
        echo "<h1>Hello World!</h1>";
        break;
    case "/api/admin":
        require __DIR__ . "/api/admin.php";
        break;
    default:
        // Rota padrão para tratamento de 404
        http_response_code(404);
        echo "404 Not Found";
        break;
}

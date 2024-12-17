<?php

require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/generated-conf/config.php";

require_once __DIR__ . "/functions/apiKeyValidation.php";
require_once __DIR__ . "/functions/audit.php";
require_once __DIR__ . "/functions/bodyParser.php";
require_once __DIR__ . "/functions/collectionToArray.php";
require_once __DIR__ . "/functions/dataValidation.php";
require_once __DIR__ . "/functions/dynamicQuery.php";
require_once __DIR__ . "/functions/findAdmin.php";
require_once __DIR__ . "/functions/findSingle.php";
require_once __DIR__ . "/functions/groupValidation.php";
require_once __DIR__ . "/functions/initDb.php";
require_once __DIR__ . "/functions/permissionValidator.php";
require_once __DIR__ . "/functions/router.php";
require_once __DIR__ . "/functions/sendResponse.php";
require_once __DIR__ . "/functions/snakeToCamel.php";
require_once __DIR__ . "/functions/updateObject.php";
require_once __DIR__ . "/functions/verifyUnicity.php";
require_once __DIR__ . "/functions/discount.php";

initRoot();


$request = parse_url($_SERVER["REQUEST_URI"])["path"];

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Verifica se a requisição é para uma rota começando com "/api"
if (strpos($request, "/api") === 0) {
    // Realiza a validação da chave API apenas se a requisição é para uma rota "/api"
    if (!apiKeyValidator()) {
        // Chave API inválida, envia resposta de erro e interrompe a execução
        sendResponse(403, true, "Invalid API key, unauthorized");
    }
}

function startsWith($string, $startString)
{
    return strncmp($string, $startString, strlen($startString)) === 0;
}

// Roteamento baseado na requisição
switch (true) {
    case startsWith($request, "/api/admin"):
        require_once __DIR__ . "/api/Admin/router.php";
        break;
    case startsWith($request, "/api/permission"):
        require_once __DIR__ . "/api/Permission/router.php";
        break;
    case startsWith($request, "/api/address"):
        require_once __DIR__ . "/api/Address/router.php";
        break;
    case startsWith($request, "/api/client"):
        require_once __DIR__ . "/api/Client/router.php";
        break;
    case startsWith($request, "/api/product"):
        require_once __DIR__ . "/api/Product/router.php";
        break;
    case startsWith($request, "/api/cart"):
        require_once __DIR__ . "/api/Cart/router.php";
        break;
    case startsWith($request, "/api/category"):
        require_once __DIR__ . "/api/Category/router.php";
        break;
    case startsWith($request, "/api/seller"):
        require_once __DIR__ . "/api/Seller/router.php";
        break;
    case startsWith($request, "/api/discount"):
        require_once __DIR__ . "/api/Discount/router.php";
        break;
    case startsWith($request, "/api/order"):
        require_once __DIR__ . "/api/Order/router.php";
        break;
    case startsWith($request, "/"):
        echo "<h1>Hello World!</h1>";
        break;

    default:
        // Rota padrão para tratamento de 404
        sendResponse(404, true, "Page not found");
}

<?php



require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/sendResponse.php";
function findAdmin(string $apiKey)
{
    $admins = \Buildings\AdminQuery::create()->find();

    $adm = null;
    foreach($admins as $admin) {
        $encrypted = $admin->getApiKey();
        if(password_verify($apiKey, $encrypted)) {
            $adm = $admin;
            break;
        }
    }

    if(!isset($adm)) {
        sendResponse(403, true, "Admin not found");
    } {
        return $adm;
    }


}

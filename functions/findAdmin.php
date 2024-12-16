<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/sendResponse.php";

/**
 * @param string $apiKey The api key belonging to the admin
 * @return \Buildings\Admin The returned admin
 */
function findAdmin(string $apiKey): \Buildings\Admin
{
    $admins = \Buildings\AdminQuery::create()->find();

    $adm = null;
    foreach ($admins as $admin) {
        $encrypted = $admin->getApiKey();
        if (password_verify($apiKey, $encrypted)) {
            $adm = $admin;
            break;
        }
    }

    if (!isset($adm)) {
        sendResponse(403, true, "Admin not found");
    } {
        return $adm;
    }


}

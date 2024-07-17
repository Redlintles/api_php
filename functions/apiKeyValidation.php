<?php

use Buildings\AdminQuery;

function apiKeyValidator()
{
    if (isset($_SERVER["HTTP_X_API_KEY"])) {
        $apiKey = $_SERVER["HTTP_X_API_KEY"];

        $userId = -1;

        $users = AdminQuery::create()->find();

        foreach($users as $user) {
            $encrypted = $user->getApiKey();
            if(password_verify($apiKey, $encrypted)) {
                $userId = $user->getId();
            }
        }


        // Realiza a consulta no banco de dados para verificar a chave API


        if ($userId === -1) {
            return false; // Chave API não encontrada ou inválida
        } else {
            return true; // Chave API válida
        }
    } else {
        return false; // API key não foi fornecida na requisição
    }
}

<?php

use Buildings\AdminQuery;

function apiKeyValidator()
{
    if (isset($_SERVER["HTTP_X_API_KEY"])) {
        $apiKey = $_SERVER["HTTP_X_API_KEY"];

        // Realiza a consulta no banco de dados para verificar a chave API
        $result = AdminQuery::create()->findOneByApiKey($apiKey);

        if (!$result) {
            return false; // Chave API não encontrada ou inválida
        } else {
            return true; // Chave API válida
        }
    } else {
        return false; // API key não foi fornecida na requisição
    }
}

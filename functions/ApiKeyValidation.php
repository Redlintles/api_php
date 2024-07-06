<?php

use Buildings\AdminQuery;

function apiKeyValidator()
{
    if (isset($_GET["api_key"])) {
        $apiKey = $_GET["api_key"];

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

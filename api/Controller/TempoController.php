<?php
namespace Controller;

class TempoController {
    public function getData() {
        // Faz a requisição para a API
        $data = file_get_contents("https://api.hgbrasil.com/weather");

        // Decodifica o JSON recebido da API para garantir que é uma string JSON válida
        $decodedData = json_decode($data, true);

        // Verifica se a decodificação foi bem-sucedida
        if (json_last_error() === JSON_ERROR_NONE) {
            // Retorna o JSON diretamente
            return json_encode($decodedData, JSON_PRETTY_PRINT);
        } else {
            // Em caso de erro, retorna uma mensagem de erro em JSON
            return json_encode(['error' => 'Failed to decode JSON'], JSON_PRETTY_PRINT);
        }
    }
}

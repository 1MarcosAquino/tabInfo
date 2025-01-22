<?php

$method = parse_url($_SERVER['REQUEST_METHOD'], PHP_URL_PATH);

date_default_timezone_set('America/Sao_Paulo');

header('Content-Type: application/json; charset=utf-8');

function response($status, $message)
{
    $data = $message;

    if (is_string($message)) {
        $data = json_decode($message, true);
    }

    if (json_last_error() !== JSON_ERROR_NONE) {
        $data = $message;
    }

    $response = array(
        'http_status' => $status,
        'data' => date('d/m/y h:i:s'),
        'result' => $data,
    );

    http_response_code($status);

    echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

    exit;
}

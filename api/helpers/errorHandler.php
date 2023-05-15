<?php

function sendErrorResponse(int $statusCode, string $message): void
{
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'error' => $message,
    ]);
    exit;
}
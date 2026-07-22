<?php

declare(strict_types=1);

namespace App\Libraries;

use CodeIgniter\HTTP\ResponseInterface;

final class ResponseBuilder
{
    public static function success(ResponseInterface $response, mixed $data = null, string $message = 'OK', int $status = 200): ResponseInterface
    {
        return $response->setStatusCode($status)->setJSON([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'meta' => [
                'timestamp' => date(DATE_ATOM),
            ],
        ]);
    }

    public static function error(ResponseInterface $response, string $message, int $status = 400, array $errors = []): ResponseInterface
    {
        return $response->setStatusCode($status)->setJSON([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
            'meta' => [
                'timestamp' => date(DATE_ATOM),
            ],
        ]);
    }
}

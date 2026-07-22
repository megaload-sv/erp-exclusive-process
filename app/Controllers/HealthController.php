<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Controller;

final class HealthController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        $database = false;

        try {
            $connection = db_connect();
            $connection->initialize();
            $database = (bool) $connection->connID;
        } catch (\Throwable) {
            $database = false;
        }

        $healthy = $database;
        $payload = [
            'status'      => $healthy ? 'ok' : 'degraded',
            'application' => env('app.name', 'TraceOps ERP'),
            'version'     => env('app.version', '0.1.0-alpha'),
            'environment' => ENVIRONMENT,
            'checks'      => [
                'application' => true,
                'database'    => $database,
            ],
            'timestamp' => date(DATE_ATOM),
        ];

        return $this->respond($payload, $healthy ? 200 : 503);
    }
}

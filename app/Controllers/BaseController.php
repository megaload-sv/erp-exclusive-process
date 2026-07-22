<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\TraceOps;
use Psr\Log\LoggerInterface;

/**
 * Shared application controller for TraceOps ERP.
 *
 * It centralizes cross-cutting application concerns while keeping business
 * rules inside domain services and modules.
 */
abstract class BaseController extends Controller
{
    /** @var list<string> */
    protected $helpers = ['url', 'app', 'format', 'feature'];

    protected TraceOps $traceOps;

    /** @var array<string, mixed> */
    protected array $viewData = [];

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        /** @var TraceOps $traceOps */
        $traceOps = config(TraceOps::class);
        $this->traceOps = $traceOps;

        date_default_timezone_set($this->traceOps->timezone);
        $this->viewData = $this->sharedViewData();
    }

    /**
     * Shared data available to application views.
     *
     * @return array<string, mixed>
     */
    protected function sharedViewData(): array
    {
        return [
            'traceOps'       => $this->traceOps,
            'appName'        => $this->traceOps->name,
            'appVersion'     => $this->traceOps->version,
            'tagline'        => $this->traceOps->tagline,
            'company'        => $this->traceOps->company,
            'moduleRegistry' => $this->traceOps->modules,
        ];
    }
}

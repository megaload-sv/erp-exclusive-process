<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'DashboardController::index', ['as' => 'dashboard']);
$routes->get('health', 'HealthController::index', ['as' => 'health']);

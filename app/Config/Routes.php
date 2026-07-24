<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'DashboardController::index', ['as' => 'dashboard']);
$routes->get('design-system', 'DesignSystemController::index', ['as' => 'design-system']);
$routes->get('developer', 'DeveloperController::index', ['as' => 'developer']);
$routes->get('health', 'HealthController::index', ['as' => 'health']);

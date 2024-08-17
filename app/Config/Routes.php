<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'FrontendController::index');
$routes->get('/attributions', 'FrontendController::attributions');

$routes->get('/onboarding', 'OnboardingController::index');

service('auth')->routes($routes);

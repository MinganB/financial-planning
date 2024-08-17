<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

/**
 * Frontend routes
 */
$routes->get('/', 'FrontendController::index');
$routes->get('/attributions', 'FrontendController::attributions');

/**
 * Dashboard routes
 */
$routes->get('me', 'DashboardController::index');

/**
 * Onboarding routes
 */
$routes->get('me/onboarding', 'OnboardingController::index');
$routes->get('me/onboarding/update', 'OnboardingController::update');

service('auth')->routes($routes);

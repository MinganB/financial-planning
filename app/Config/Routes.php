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
 * Onboarding routes
 */
$routes->get('me/onboarding', 'OnboardingController::index');
$routes->get('me/onboarding/update', 'OnboardingController::update');

service('auth')->routes($routes);

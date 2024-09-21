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
$routes->get('/about', 'FrontendController::about');

/**
 * Dashboard routes
 */
$routes->get('me', 'DashboardController::index');

/**
 * Onboarding routes
 */
$routes->get('onboarding', 'OnboardingController::index');
$routes->get('onboarding/update', 'OnboardingController::update');
$routes->get('onboarding/complete', 'OnboardingController::complete');
$routes->post('onboarding/submit', 'OnboardingController::submit');

/**
 * Settings routes
 */
$routes->get('me/settings', 'SettingsController::index');

/**
 * Budget routes
 */
$routes->get('me/budget', 'BudgetController::index');

/**
 * Budget routes
 */
$routes->get('me/net-worth', 'NetworthController::index');

/**
 * Budget routes
 */
$routes->get('me/planning', 'PlanningController::index');

/**
 * Profile routes
 */
$routes->get('me/profile', 'ProfileController::index');


service('auth')->routes($routes);

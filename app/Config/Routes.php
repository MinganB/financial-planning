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
$routes->get('me/onboarding/complete', 'OnboardingController::complete');

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

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
$routes->post('me/settings/delete-account', 'SettingsController::deleteUserAccount');
$routes->post('me/settings/update-password', 'SettingsController::updatePassword');

/**
 * Budget routes
 */
$routes->get('me/budget', 'BudgetController::index');
$routes->post('me/budget/add-expense', 'BudgetController::addExpense');
$routes->post('me/budget/update-expense/(:num)', 'BudgetController::updateExpense/$1');
$routes->post('me/budget/delete-expense/(:num)', 'BudgetController::deleteExpense/$1');

/**
 * Net worth routes
 */
$routes->get('me/net-worth', 'NetworthController::index');
$routes->post('me/net-worth/update-asset', 'NetworthController::createOrUpdateAsset');
$routes->post('me/net-worth/delete-asset', 'NetworthController::deleteAsset');
$routes->post('me/net-worth/delete-liability', 'NetworthController::deleteLiability');
$routes->post('me/net-worth/update-liability', 'NetworthController::createOrUpdateLiability');

/**
 * Budget routes
 */
$routes->get('me/planning', 'PlanningController::index');

/**
 * Profile routes
 */
$routes->get('me/profile', 'ProfileController::index');


service('auth')->routes($routes);

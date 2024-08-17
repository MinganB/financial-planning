<?php

namespace App\Controllers;

class OnboardingController extends BaseController
{
    /**
     * Welcomes the user to the onboarding / data capture process.
     */
    public function index()
    {
        $view = view('onboarding/welcome');
        return $this->getPreparedView($view);
    }
}

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
        return $this->getPreparedView($view, false, false);
    }

    /**
     * Allows users to enter / update their data.
     */
    public function update()
    {
        $view = view('onboarding/datacapture');
        return $this->getPreparedView($view, false, false);
    }

    /**
     * User has completed the onboarding process. Shows them a confirmation screen.
     */
    public function complete()
    {
        $view = view('onboarding/complete');
        return $this->getPreparedView($view, false, false);
    }
}

<?php

namespace App\Controllers;

class SettingsController extends BaseController
{
    public function index()
    {
        $view = view('settings/main');
        return $this->getPreparedView($view);
    }
}

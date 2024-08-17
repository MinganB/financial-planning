<?php

namespace App\Controllers;

class DashboardController extends BaseController
{
    public function index()
    {
        $view = view('dashboard/main');
        return $this->getPreparedView($view);
    }
}

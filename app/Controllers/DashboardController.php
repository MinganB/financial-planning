<?php

namespace App\Controllers;

class DashboardController extends BaseController
{
    public function index()
    {
        $view = view('dashboard/main')
            . view('budget/modal-income')
            . view('budget/modal-expense');
        return $this->getPreparedView($view);
    }
}

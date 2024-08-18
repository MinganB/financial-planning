<?php

namespace App\Controllers;

class BudgetController extends BaseController
{
    public function index()
    {
        $view = view('budget/main');
        return $this->getPreparedView($view);
    }
}

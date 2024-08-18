<?php

namespace App\Controllers;

class BudgetController extends BaseController
{
    public function index()
    {
        $view = view('budget/main')
            . view('budget/modal-income')
            . view('budget/modal-expense');
        return $this->getPreparedView($view);
    }
}

<?php

namespace App\Controllers;

use App\Models\BudgetModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $data['expenseData'] = model(BudgetModel::class)->getActiveExpenses(auth()->user()->id);

        $view = view('dashboard/main', $data)
            . view('budget/modal-income')
            . view('budget/modal-actual-expense');
        return $this->getPreparedView($view);
    }
}

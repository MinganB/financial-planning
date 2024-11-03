<?php

namespace App\Controllers;
use App\Models\BudgetModel;

class BudgetController extends BaseController
{
    protected $budgetModel;

    public function __construct()
    {
        $this->budgetModel = model(BudgetModel::class);
    }

    public function index()
    {
        $data['expenseData'] = $this->budgetModel->getActiveExpenses(auth()->user()->id);

        $view = view('budget/main', $data)
            . view('budget/modal-income')
            . view('budget/modal-expense');
        return $this->getPreparedView($view);
    }

    public function addExpense()
    {
        $data = $this->request->getJSON(true);

        if ($this->budgetModel->addExpense($data)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Expense added successfully', 'csrf' => csrf_hash()]);
        } else {
            return $this->response->setJSON(['success' => 'error', 'message' => 'Failed to add expense', 'csrf' => csrf_hash()]);
        }
    }

    public function updateExpense($expenseId)
    {
        $data = $this->request->getJSON(true);
        log_message('debug', json_encode($data));

        if ($this->budgetModel->updateExpense($expenseId, $data)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Expense updated successfully', 'csrf' => csrf_hash()]);
        } else {
            return $this->response->setJSON(['success' => 'error', 'message' => 'Failed to update expense', 'csrf' => csrf_hash()]);
        }
    }

    public function deleteExpense($expenseId)
    {
        if ($this->budgetModel->deleteExpense($expenseId)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Expense deleted successfully', 'csrf' => csrf_hash()]);
        } else {
            return $this->response->setJSON(['success' => 'error', 'message' => 'Failed to delete expense', 'csrf' => csrf_hash()]);
        }
    }
}

<?php

namespace App\Controllers;
use App\Models\BudgetModel;

use function PHPUnit\Framework\isNan;

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
        $data['expenseActuals'] = $this->budgetModel->getExpensesForCurrentMonth(auth()->user()->id);

        $view = view('budget/main', $data)
            . view('budget/modal-income')
            . view('budget/modal-expense')
            . view('budget/modal-actual-expense');
        return $this->getPreparedView($view);
    }

    public function addIncome()
    {
        $postData = json_decode($this->request->getPost('payload'), true);

        $addIncome = $this->budgetModel->addIncome($postData['name'], $postData['amount'], $postData['description'], $postData['category_id'], $postData['start_date'], $postData['end_date']);

        if ($addIncome !== null) {
            return $this->response->setJSON(['success' => true, 'message' => 'Income added successfully', 'csrf' => csrf_hash()]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to add income', 'csrf' => csrf_hash()]);
        }
    }

    public function addExpense()
    {
        $data = $this->request->getJSON(true);

        if ($this->budgetModel->addExpense($data)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Expense added successfully', 'csrf' => csrf_hash()]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to add expense', 'csrf' => csrf_hash()]);
        }
    }

    public function updateExpense($expenseId)
    {
        $data = $this->request->getJSON(true);
        log_message('debug', json_encode($data));

        if ($this->budgetModel->updateExpense($expenseId, $data)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Expense updated successfully', 'csrf' => csrf_hash()]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to update expense', 'csrf' => csrf_hash()]);
        }
    }

    public function deleteExpense($expenseId)
    {
        if ($this->budgetModel->deleteExpense($expenseId)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Expense deleted successfully', 'csrf' => csrf_hash()]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to delete expense', 'csrf' => csrf_hash()]);
        }
    }

    public function addActualExpense()
    {
        $postData = json_decode($this->request->getPost('payload'), true);

        $expenseId = $postData['expense_id'];
        $description = $postData['description'];
        $amount = $postData['amount'];
        $expenseDate = $postData['expense_date'];

        $result = $this->budgetModel->addActualExpense(auth()->user()->id, $expenseId, $description, $amount, $expenseDate);

        if ($result) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Expense added successfully']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to add expense']);
        }
    }

    public function deleteActualExpense($actualExpenseId)
    {
        $result = $this->budgetModel->deleteActualExpense($actualExpenseId);

        if ($result) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Expense deleted successfully']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to delete expense']);
        }
    }
}

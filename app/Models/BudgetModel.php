<?php

namespace App\Models;

use CodeIgniter\Model;

class BudgetModel extends Model
{
    /**
     * Add an income to the user's budget.
     * 
     * @param array $data Associative array containing the following keys:
     *   - string 'name': Name/title of the income.
     *   - float 'amount': Monthly income amount as a decimal float.
     *   - string 'description': Short description of the income.
     *   - int 'category_id': Category ID of the income.
     *   - string 'start_date': Date from which income should start (YYYY-MM-DD format).
     *   - string|null 'end_date': (Optional) End date of the income (YYYY-MM-DD format), or null for indefinite income.
     * 
     * @return int|null Returns the income_id of the newly created income, or null if an error was encountered.
     */
    public function addIncome($data) {
        $data = [
            'user_id' => auth()->user()->id,
            'name' => $data['name'],
            'amount' => $data['amount'],
            'description' => $data['description'],
            'category_id' => $data['category_id'],
            'start_date' => $data['start_date'],
            'end_date' => ($data['end_date'] == '') ? null : $data['end_date'],
        ];

        $this->db->table('budget_incomes')->insert($data);

        if ($this->db->affectedRows() > 0) {
            return $this->db->insertID();
        } else {
            return null;
        }
    }

    /**
     * Updates a given income in the user's budget.
     * 
     * @param int $incomeId Identifier (id) of the income to update.
     * @param array $updatedData Associative array containing any fields to be updated. Example: $updatedData = ['amount' => 500.00, 'description' => 'Updated income description'];
     * 
     * @return bool True if changes were made, false if no changes were made.
     */
    public function updateIncome($incomeId, array $updatedData) {
        if (empty($updatedData)) {
            return false; // No data to update
        }

        $this->db->table('budget_incomes')
            ->where('income_id', $incomeId)
            ->where('user_id', auth()->user()->id)
            ->update($updatedData);

        return ($this->db->affectedRows() > 0);
    }

    /**
     * Deletes a given income. Completely deletes the income including past occurances.
     * 
     * @param int $incomeId ID of the income to delete.
     * 
     * @return bool True if successful, false otherwise.
     */
    public function deleteIncome($incomeId) {
        $this->db->table('budget_incomes')
            ->where('income_id', $incomeId)
            ->where('user_id', auth()->user()->id)
            ->delete();

        return ($this->db->affectedRows() > 0);
    }

    /**
     * Create a new expense in the user's budget.
     * 
     * @param array $data Associative array containing the following keys:
     *   - string 'title': Title of the expense (e.g., "Momentum Health").
     *   - string 'description': Short description of the expense (e.g., "Expense").
     *   - float 'amount': Expense amount as a decimal float (e.g., 2500.00).
     *   - string 'category_id': Category of the expense (e.g., "Medical aid").
     *   - string 'start_date': Start date of the expense (YYYY-MM-DD format).
     *   - string|null 'end_date': (Optional) End date of the expense (YYYY-MM-DD format), or null for indefinite expenses.
     * 
     * @return bool Returns true if the expense was successfully inserted, or false otherwise.
     */
    public function addExpense($data) {
        $data['user_id'] = auth()->user()->id;

        return $this->db->table('budget_expenses')
            ->insert($data);
    }

    /**
     * Update existing expense in the user's budget.
     * 
     * @param int $expenseId The Id of the expense to be updated.
     * @param array $data Associative array containing updated expense details:
     *   - string 'title': (Optional) Title of the expense (e.g., "Momentum Health").
     *   - string 'description': (Optional) Short description of the expense (e.g., "Expense").
     *   - float 'amount': (Optional) Updated amount of the expense as a decimal float (e.g., 2500.00).
     *   - int 'category_id': (Optional) Updated category ID of the expense (e.g., 17).
     *   - string 'start_date': (Optional) Updated start date of the expense (YYYY-MM-DD format).
     *   - string|null 'end_date': (Optional) Updated end date of the expense (YYYY-MM-DD format), or null for indefinite expenses.
     * 
     * @return bool Returns true if the expense was updated, false otherwise.
     */
    public function updateExpense($expenseId, $data) {
        return $this->db->table('budget_expenses')
            ->where('expense_id', $expenseId)
            ->update($data);
    }

    /**
     * Deletes the expense from the user's budget.
     * 
     * @param int $expenseId The Id of the expense to be updated.
     * 
     * @return bool True if expense was deleted, false otherwise.
     */
    public function deleteExpense($expenseId) {
        $userId = auth()->user()->id;

        return $this->db->table('budget_expenses')
            ->where('expense_id', $expenseId)
            ->where('user_id', $userId)
            ->delete();
    }

    /**
     * Get all budgetted expenses for a given user (applicable to the current month).
     * 
     * Returns expenses that either have no end date or an end date later than today, and 
     * have a start date on or before the last day of the current month.
     * 
     * @param int $userId The user for whom to retrieve expenses.
     * 
     * @return array Array of arrays each with keys:
     *   - 'expense_id': int
     *   - 'title': string
     *   - 'description': string
     *   - 'amount': float
     *   - 'category_id': int
     *   - 'start_date': string (YYYY-MM-DD format)
     *   - 'end_date': string|null (YYYY-MM-DD format or null if indefinite)
     */
    public function getActiveExpenses($userId) {
        $today = date('Y-m-d');
        $endOfMonth = date('Y-m-t'); // Last day of the current month

        $query = $this->db->table('budget_expenses')
            ->where('user_id', $userId)
            ->groupStart() 
                ->where('end_date IS NULL')
                ->orWhere('end_date >', $today)
            ->groupEnd()
            ->where('start_date <=', $endOfMonth)
            ->get();

        return $query->getResultArray();
    }

    /**
     * Log an actual expense for a given date, associated with a budgeted expense.
     * 
     * @param int $userId User logging the expense.
     * @param int $expenseId Budgeted expense.
     * @param string $description A short description of the actual expense.
     * @param float $amount The amount of the actual expense as a decimal float (e.g., 250.00).
     * @param string $expenseDate The date of the expense (YYYY-MM-DD format).
     * 
     * @return bool Returns true if expense was logged, false otherwise.
     */
    public function addActualExpense($userId, $expenseId, $description, $amount, $expenseDate) {
        $data = [
            'user_id' => $userId,
            'expense_id' => $expenseId,
            'description' => $description,
            'amount' => $amount,
            'expense_date' => $expenseDate,
        ];

        return $this->db->table('budget_expenses_actual')->insert($data);
    }

    /**
     * Delete an an actual expense logged within a budgeted expense by its Id.
     * 
     * @param int $actualExpenseId Actual expense to delete.
     * 
     * @return bool True if deleted, false otherwise.
     */
    public function deleteActualExpense($actualExpenseId) {
        return $this->db->table('budget_expenses_actual')
                        ->where('actual_expense_id', $actualExpenseId)
                        ->delete();
    }

    /**
     * Get all actual expenses for a given user (applicable to the current month).
     * 
     * @param int $userId User to retrieve expenses for.
     * 
     * @return array Expense record records with keys:
        *   - 'actual_expense_id': int (Primary key of the actual expense record)
        *   - 'user_id': int
        *   - 'expense_id': int (Associated budgeted expense ID)
        *   - 'description': string
        *   - 'amount': float
        *   - 'expense_date': date (YYYY-MM-DD format)
        *   - 'created_at': date (YYYY-MM-DD format)
        */
    public function getExpensesForCurrentMonth($userId) {
        $builder = $this->db->table('budget_expenses_actual');

        $startOfMonth = date('Y-m-01');
        $endOfMonth = date('Y-m-t');

        return $builder->where('user_id', $userId)
                    ->where('expense_date >=', $startOfMonth)
                    ->where('expense_date <=', $endOfMonth)
                    ->get()
                    ->getResultArray();
    }
}
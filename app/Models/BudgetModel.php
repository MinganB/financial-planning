<?php

namespace App\Models;

use CodeIgniter\Model;

class BudgetModel extends Model
{
    /**
     * Add an income to the user's budget.
     * 
     * @param float $amount Monthly income amount as a decimal float.
     * @param string $description Short description of the income.
     * @param int $categoryId Category of the income.
     * @param date $startDate Date from which income should start.
     * @param date $endDate (Optional) Defaults to null representing an indefinite income. Otherwise, end date of income.
     * 
     * @return int Returns the income_id of the newly created income, or null if an error was encountered.
     */
    public function addIncome($amount, $description, $categoryId, $startDate, $endDate = null) {
        $data = [
            'user_id' => auth()->user()->id,
            'amount' => $amount,
            'description' => $description,
            'category_id' => $categoryId,
            'start_date' => $startDate,
            'end_date' => $endDate
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
     * @param int $incomeId Identifier of the income to update.
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

    public function addExpense($data)
    {
        $data['user_id'] = auth()->user()->id;

        return $this->db->table('budget_expenses')
            ->insert($data);
    }

    public function updateExpense($expenseId, $data)
    {
        return $this->db->table('budget_expenses')
            ->where('expense_id', $expenseId)
            ->update($data);
    }

    public function deleteExpense($expenseId)
    {
        $userId = auth()->user()->id;

        return $this->db->table('budget_expenses')
            ->where('expense_id', $expenseId)
            ->where('user_id', $userId)
            ->delete();
    }

    public function getActiveExpenses($userId)
    {
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

    public function addActualExpense($userId, $expenseId, $description, $amount, $expenseDate)
    {
        $data = [
            'user_id' => $userId,
            'expense_id' => $expenseId,
            'description' => $description,
            'amount' => $amount,
            'expense_date' => $expenseDate,
        ];

        return $this->db->table('budget_expenses_actual')->insert($data);
    }

    public function deleteActualExpense($actualExpenseId)
    {
        return $this->db->table('budget_expenses_actual')
                        ->where('actual_expense_id', $actualExpenseId)
                        ->delete();
    }

    public function getExpensesForCurrentMonth($userId)
    {
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
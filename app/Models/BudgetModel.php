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
}
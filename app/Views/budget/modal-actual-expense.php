<script>
    var expenseActuals = <?= isset($expenseActuals) ? json_encode($expenseActuals) : 'null' ?>;
</script>

<div class="modal fade" id="actualExpenseModal" tabindex="-1" aria-labelledby="actualExpenseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-3 shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title" id="actualExpenseModalLabel">Add Actual Expense</h5>
                <button type="button" id="closeActualExpensesModal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="actualExpenseForm">
                    <div class="mb-3">
                        <label for="expenseBudgetAllocation" class="form-label">Expense Category</label>
                        <select class="form-select" id="expenseBudgetAllocation" required>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="actualExpenseDescription" class="form-label">Description</label>
                        <input type="text" class="form-control" id="actualExpenseDescription" required>
                    </div>
                    <div class="mb-3">
                        <label for="actualExpenseAmount" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="actualExpenseAmount" required>
                    </div>
                    <div class="mb-3">
                        <label for="actualExpenseDate" class="form-label">Date</label>
                        <input type="date" class="form-control" id="actualExpenseDate" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveActualExpenseButton">Save Expense</button>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('js/budget/actual-expense-logic.js?v=0.0.1') ?>"></script>

<script>
    if(expenseActuals !== null) {
        expenseActuals.forEach(actual => {
            addActualExpenseToDOM(actual);
        });
    }
</script>
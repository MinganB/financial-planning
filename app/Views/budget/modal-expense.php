<div class="modal fade" id="expenseModal" tabindex="-1" aria-labelledby="expenseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-3 shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title" id="expenseModalLabel">Add/Edit Expense</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="expenseForm">
                    <div class="mb-3">
                        <label for="expenseName" class="form-label">Expense name</label>
                        <input type="text" class="form-control" id="expenseName" required>
                    </div>
                    <div class="mb-3">
                        <label for="expenseAmount" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="expenseAmount" required>
                    </div>
                    <div class="mb-3">
                        <label for="expenseType" class="form-label">Type</label>
                        <select class="form-select" id="expenseType" required>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="startDate" class="form-label">Start date</label>
                        <input type="date" class="form-control" id="startDate" required>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="expiresToggle">
                        <label class="form-check-label" for="expiresToggle">Expires?</label>
                    </div>
                    <div class="mb-3" id="endDateField" style="display: none;">
                        <label for="endDate" class="form-label">End date</label>
                        <input type="date" class="form-control" id="endDate">
                    </div>
                    <div class="mb-3">
                        <label for="expenseNotes" class="form-label">Notes</label>
                        <textarea class="form-control" id="expenseNotes" rows="3"></textarea>
                    </div>
                    <div class="text-end">
                        <a href="#" id="deleteExpenditure" class="text-danger">Delete expenditure</a>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveExpenseButton">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script>
    /**
     * Logic to control in-modal behaviour.
     */
    document.getElementById('expiresToggle').addEventListener('change', function() {
        const endDateField = document.getElementById('endDateField');
        if (this.checked) {
            endDateField.style.display = 'block';
        } else {
            endDateField.style.display = 'none';
        }
    });
</script>
<div class="modal fade" id="incomeModal" tabindex="-1" aria-labelledby="incomeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-3 shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title" id="incomeModalLabel">Add/Edit Income</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="incomeForm">
                    <div class="mb-3">
                        <label for="incomeName" class="form-label">Income name</label>
                        <input type="text" class="form-control" id="incomeName" required>
                    </div>
                    <div class="mb-3">
                        <label for="incomeAmount" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="incomeAmount" required>
                    </div>
                    <div class="mb-3">
                        <label for="incomeType" class="form-label">Type</label>
                        <select class="form-select" id="incomeType" required>
                            <option value="Salary">Salary</option>
                            <option value="Other Income">Other Income</option>
                            <option value="Adhoc Deposit">Adhoc Deposit</option>
                        </select>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="recurringToggle">
                        <label class="form-check-label" for="recurringToggle">Recurring?</label>
                    </div>
                    <div class="mb-3">
                        <label for="incomeStartDate" class="form-label">Start date</label>
                        <input type="date" class="form-control" id="incomeStartDate" required>
                    </div>
                    <div class="mb-3" id="incomeEndDateField" style="display: none;">
                        <label for="incomeEndDate" class="form-label">End date</label>
                        <input type="date" class="form-control" id="incomeEndDate">
                    </div>
                    <div class="mb-3">
                        <label for="incomeNotes" class="form-label">Notes</label>
                        <textarea class="form-control" id="incomeNotes" rows="3"></textarea>
                    </div>
                    <div class="text-end">
                        <a href="#" id="deleteIncome" class="text-danger">Delete income</a>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveIncomeButton">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script>
    /**
     * Logic to control in-modal behaviour.
     */
    document.getElementById('recurringToggle').addEventListener('change', function() {
        const endDateField = document.getElementById('incomeEndDateField');
        if (this.checked) {
            endDateField.style.display = 'block';
        } else {
            endDateField.style.display = 'none';
        }
    });
</script>
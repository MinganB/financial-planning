// In-model UI logic
document.getElementById('recurringToggle').addEventListener('change', function() {
    const endDateField = document.getElementById('incomeEndDateField');
    if (this.checked) {
        endDateField.style.display = 'block';
    } else {
        endDateField.style.display = 'none';
    }
});

// Save new income
document.getElementById('saveIncomeButton').addEventListener('click', function() {
    const incomeName = document.getElementById('incomeName').value;
    const incomeAmount = document.getElementById('incomeAmount').value;
    const incomeType = document.getElementById('incomeType').value;
    const incomeStartDate = document.getElementById('incomeStartDate').value;
    const incomeEndDate = document.getElementById('incomeEndDate').value;
    const incomeNotes = document.getElementById('incomeNotes').value;

    saveIncome(incomeName, incomeAmount, incomeType, incomeNotes, incomeStartDate, incomeEndDate);
});

function saveIncome(incomeName, incomeAmount, incomeType, incomeNotes, incomeStartDate, incomeEndDate = null) {
    let newIncome = { 
        name: incomeName, 
        amount: incomeAmount, 
        category_id: incomeType, 
        description: incomeNotes,
        start_date: incomeStartDate,
        end_date: incomeEndDate,
    };

    requestAddIncome(newIncome);
}

function requestAddIncome(newIncome) {
    makeAjaxCall('me/budget/add-income', newIncome, (response) => {
        console.log(response.message);
    });

    document.getElementById('closeIncomeModal').click();
}
const expenseBudgetAllocationSelect = document.getElementById('expenseBudgetAllocation');
expenses.forEach(expense => {
    const option = document.createElement('option');
    option.value = (expense.id !== undefined) ? expense.id : expense.expense_id;
    option.textContent = expense.title;
    expenseBudgetAllocationSelect.appendChild(option);
});

document.getElementById('saveActualExpenseButton').addEventListener('click', function() {
    const category = expenseBudgetAllocationSelect.value;
    const description = document.getElementById('actualExpenseDescription').value;
    const amount = document.getElementById('actualExpenseAmount').value;
    const date = document.getElementById('actualExpenseDate').value;

    saveActualExpense(category, description, amount, date);
});

function saveActualExpense(category, description, amount, date) {
    let newExpense = { 
        expense_id: category, 
        description: description, 
        amount: amount, 
        expense_date: date,
    };

    requestAddActualExpense(newExpense);
    if(expenseActuals !== null) {
        addActualExpenseToDOM(newExpense); 
    } else {
        alert('Expense has been saved!');
        document.getElementById('closeActualExpensesModal').click();
    }
}

function requestAddActualExpense(expenseArgs) {
    makeAjaxCall('me/budget/add-actual-expense', expenseArgs, (response) => {
        console.log(response.message);
    });
}

function requestDeleteActualExpense(id) {
    makeAjaxCall('me/budget/delete-actual-expense/' + id, null, (response) => {
        console.log(response.message);
    });
}

function addActualExpenseToDOM(expense) {
    const expensesTableBody = document.getElementById('expensesTable').querySelector('tbody');

    const row = document.createElement('tr');
    
    const categoryCell = document.createElement('td');
    categoryCell.textContent = expenses.find(e => e.id === expense.expense_id).title;

    const descriptionCell = document.createElement('td');
    descriptionCell.textContent = expense.description;

    const amountCell = document.createElement('td');
    amountCell.textContent = `R${parseFloat(expense.amount).toLocaleString()}`;

    const dateCell = document.createElement('td');
    dateCell.textContent = formatDate(new Date(expense.expense_date));

    const actionsCell = document.createElement('td');

    const deleteButton = document.createElement('button');
    deleteButton.classList.add('btn', 'btn-sm', 'btn-danger');
    deleteButton.textContent = 'Delete';
    deleteButton.onclick = function () {
        row.remove();
        requestDeleteActualExpense(expense.actual_expense_id); // TODO
    };

    actionsCell.appendChild(deleteButton);

    row.appendChild(categoryCell);
    row.appendChild(descriptionCell);
    row.appendChild(amountCell);
    row.appendChild(dateCell);
    row.appendChild(actionsCell);

    expensesTableBody.appendChild(row);

    document.getElementById('closeActualExpensesModal').click();
}

// Prepare the page
if(expenseActuals !== null) {
    expenseActuals.forEach(actual => {
        addActualExpenseToDOM(actual);
    });
}
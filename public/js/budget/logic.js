let selectedExpense = null; // Track expense being edited

/**
 * Calculate progressbar percentage
 */
function calculateProgress(amountSpent, amountAllocated) {
  return (amountSpent / amountAllocated) * 100;
}

/**
 * Add or update an expense card on the page
 */
function addOrUpdateExpenseCard(expense) {
  const expenseCardsContainer = document.getElementById("expense-cards");

  // Check if card already exists
  let existingCard = document.querySelector(`[data-id='${expense.id}']`);
  let card;

  if (existingCard) {
    card = existingCard;
    card.innerHTML = ""; // Clear existing content
  } else {
    card = document.createElement("div");
    card.className = "col-12 col-md-4 mb-3";
    card.setAttribute("data-id", expense.id);
  }

  const progress = calculateProgress(
    expense.amountSpent,
    expense.amountAllocated
  );

  const cardContent = `
          <div class="card p-3">
              <div class="d-flex justify-content-between align-items-center">
                  <div class="d-flex align-items-center">
                      <div class="expense-icon me-3">
                          <img src="${
                            images[expense.image_id]
                          }" class="mobile-hidden" alt="${
    expense.title
  }" class="img-fluid" width="40">
                      </div>
                      <div>
                          <h5 class="card-title mb-0">${expense.title}</h5>
                          <p class="card-category text-muted">${
                            expense.category
                          }</p>
                      </div>
                  </div>
                  <div class="text-end">
                      <h6 class="card-amount mb-1">R${expense.amountSpent.toLocaleString()}</h6>
                      <p class="card-allocation text-muted">out of R${expense.amountAllocated.toLocaleString()}</p>
                  </div>
              </div>
              <div class="progress mt-2">
                  <div class="progress-bar" role="progressbar" style="width: ${progress}%;" aria-valuenow="${progress}" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
          </div>
      `;

  card.innerHTML = cardContent;

  card.addEventListener("click", function () {
    openEditModal(expense);
  });

  if (!existingCard && !isNaN(expense.amountAllocated)) {
    expenseCardsContainer.appendChild(card);
  }
}

function openEditModal(expense) {
  selectedExpense = expense;

  document.getElementById("expenseModalLabel").textContent = expense
    ? "Edit Expense"
    : "Add Expense";
  document.getElementById("expenseName").value = expense ? expense.title : "";
  document.getElementById("expenseAmount").value = expense
    ? expense.amountSpent
    : "";
  document.getElementById("expenseType").value = expense
    ? expense.category
    : "";
  document.getElementById("startDate").value = expense ? expense.startDate : "";
  document.getElementById("expiresToggle").checked = !!expense.endDate;
  document.getElementById("endDateField").style.display =
    expense && expense.endDate ? "block" : "none";
  document.getElementById("endDate").value =
    expense && expense.endDate ? expense.endDate : "";
  document.getElementById("expenseNotes").value = expense ? expense.notes : "";

  document.getElementById("deleteExpenditure").style.display = expense
    ? "inline"
    : "none";

  const modal = new bootstrap.Modal(document.getElementById("expenseModal"));
  modal.show();
}

/**
 * Deletes and expense from the DOM and local array
 * TODO: AJAX for serverside updates
 * @param {object} expense Expense object from the array to be dropped
 */
function deleteExpense(expense) {
  if (expense) {
    // Remove the expense from array
    expenses = expenses.filter((exp) => exp.id !== expense.id);

    // Remove the expense card from DOM
    const cardToDelete = document.querySelector(`[data-id='${expense.id}']`);
    if (cardToDelete) {
      cardToDelete.remove();
    }

    const modal = bootstrap.Modal.getInstance(
      document.getElementById("expenseModal")
    );
    modal.hide();

    // Clear selected expense
    selectedExpense = null;
  }
}

/**
 * Resets the expense edit modal fields
 */
function resetModalFields() {
  document.getElementById("expenseForm").reset();
  document.getElementById("endDateField").style.display = "none";
  document.getElementById("deleteExpenditure").style.display = "none";
}

function saveExpenseFromModal() {
  const expenseName = document.getElementById("expenseName").value;
  const expenseAmount = parseFloat(
    document.getElementById("expenseAmount").value
  );
  const expenseType = document.getElementById("expenseType").value;
  const startDate = document.getElementById("startDate").value;
  const expires = document.getElementById("expiresToggle").checked;
  const endDate = expires ? document.getElementById("endDate").value : null;
  const notes = document.getElementById("expenseNotes").value;

  if (selectedExpense) {
    // Update existing expense
    selectedExpense.title = expenseName;
    selectedExpense.amountSpent = expenseAmount;
    selectedExpense.category = expenseType;
    selectedExpense.startDate = startDate;
    selectedExpense.endDate = endDate;
    selectedExpense.notes = notes;
    selectedExpense.progress = calculateProgress(
      expenseAmount,
      selectedExpense.amountAllocated
    );

    // Update the existing card on the DOM
    addOrUpdateExpenseCard(selectedExpense);
  } else {
    // Create expense
    const newExpense = {
      id: expenses.length + 1,
      title: expenseName,
      category: expenseType,
      amountSpent: 0,
      amountAllocated: expenseAmount,
      image_id: 0, // Default to first image, can be changed as needed
      startDate: startDate,
      endDate: endDate,
      notes: notes,
      progress: calculateProgress(expenseAmount, expenseAmount),
    };
    expenses.push(newExpense);
    addOrUpdateExpenseCard(newExpense);
  }

  // Hide modal
  const modal = bootstrap.Modal.getInstance(
    document.getElementById("expenseModal")
  );
  modal.hide();

  // Reset expense
  selectedExpense = null;

  resetModalFields();
}

/**
 * Creates all the necessary event listeners
 */
function addDOMEventListeners() {
  document
    .getElementById("deleteExpenditure")
    .addEventListener("click", function (e) {
      e.preventDefault();

      if (confirm("Are you sure you want to delete this expenditure?")) {
        deleteExpense(selectedExpense);
      }
    });

  document
    .getElementById("expenseModal")
    .addEventListener("hidden.bs.modal", resetModalFields);

  document
    .getElementById("saveExpenseButton")
    .addEventListener("click", function () {
      saveExpenseFromModal();
    });
}

/**
 * Initialize the page
 */
document.addEventListener("DOMContentLoaded", function () {
  expenses.forEach((expense) => addOrUpdateExpenseCard(expense));

  addDOMEventListeners();
});

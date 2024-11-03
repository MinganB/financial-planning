const categories = [
  "Bond", // 0
  "Business expense", // 1
  "Charity and donations", // 2
  "Childcare", // 3
  "Clothing and accessories", // 4
  "Debt repayments", // 5
  "Education", // 6
  "Emergency fund", // 7
  "Entertainment", // 8
  "Fitness / Gym", // 9
  "Groceries and food", // 10
  "Health and wellness", // 11
  "Home and garden", // 12
  "Household supplies", // 13
  "Insurance premiums", // 14
  "Investments", // 15
  "Living expenses", // 16
  "Medical aid", // 17
  "Medical expenses", // 18
  "Miscellaneous", // 19
  "Personal care", // 20
  "Pets", // 21
  "Phone and internet", // 22
  "Property taxes", // 23
  "Rent", // 24
  "Retirement savings", // 25
  "Savings", // 26
  "Subscriptions", // 27
  "Transportation", // 28
  "Travel", // 29
  "Utilities", // 30
  "Vehicle expenses", // 31
  "Work expenses", // 32
];

const images = [
  base_url + "/img/bond.png", // 0 Bond
  base_url + "/img/business_expense.png", // 1 Business expense
  base_url + "/img/charity_donations.png", // 2 Charity and donations
  base_url + "/img/childcare.png", // 3 Childcare
  base_url + "/img/clothing_accessories.png", // 4 Clothing and accessories
  base_url + "/img/debt_repayments.png", // 5 Debt repayments
  base_url + "/img/education.png", // 6 Education
  base_url + "/img/emergency_fund.png", // 7 Emergency fund
  base_url + "/img/entertainment.png", // 8 Entertainment
  base_url + "/img/fitness_gym.png", // 9 Fitness / Gym
  base_url + "/img/groceries_food.png", // 10 Groceries and food
  base_url + "/img/health_wellness.png", // 11 Health and wellness
  base_url + "/img/home_garden.png", // 12 Home and garden
  base_url + "/img/household_supplies.png", // 13 Household supplies
  base_url + "/img/insurance_premiums.png", // 14 Insurance premiums
  base_url + "/img/investments.png", // 15 Investments
  base_url + "/img/living_expenses.png", // 16 Living expenses
  base_url + "/img/medical_aid.png", // 17 Medical aid
  base_url + "/img/medical_expenses.png", // 18 Medical expenses
  base_url + "/img/living_expenses.png", // 19 Miscellaneous
  base_url + "/img/personal_care.png", // 20 Personal care
  base_url + "/img/pets.png", // 21 Pets
  base_url + "/img/phone_internet.png", // 22 Phone and internet
  base_url + "/img/property_taxes.png", // 23 Property taxes
  base_url + "/img/rent.png", // 24 Rent
  base_url + "/img/retirement_savings.png", // 25 Retirement savings
  base_url + "/img/savings.png", // 26 Savings
  base_url + "/img/subscriptions.png", // 27 Subscriptions
  base_url + "/img/transportation.png", // 28 Transportation
  base_url + "/img/travel.png", // 29 Travel
  base_url + "/img/utilities.png", // 30 Utilities
  base_url + "/img/vehicle_expenses.png", // 31 Vehicle expenses
  base_url + "/img/work_expenses.png", // 32 Work expenses
];

var expenses = [];
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

  console.log("creating card");
  const cardContent = `
          <div class="card p-3">
              <div class="d-flex justify-content-between align-items-center">
                  <div class="d-flex align-items-center">
                      <div class="expense-icon me-3">
                          <img src="${images[expense.image_id]}" onerror="this.src='${base_url + '/img/living_expenses.png'}'"  class="mobile-hidden" alt="${expense.title}" class="img-fluid" width="40">
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

  console.log(expense);
  //expense.amountSpent

  document.getElementById("expenseModalLabel").textContent = expense
    ? "Edit Expense"
    : "Add Expense";
  document.getElementById("expenseName").value = expense ? expense.title : "";
  document.getElementById("expenseAmount").value = expense
    ? expense.amountAllocated
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
    selectedExpense.amountAllocated = expenseAmount;
    selectedExpense.amountSpent = 0;
    selectedExpense.category = expenseType;
    selectedExpense.image_id = categories.indexOf(expenseType);
    selectedExpense.startDate = startDate;
    selectedExpense.endDate = endDate;
    selectedExpense.notes = notes;

    /* TODO: Calculate using utilisation so far...
    selectedExpense.progress = calculateProgress(
      expenseAmount,
      selectedExpense.amountAllocated
    );
    */

    // Update the existing card on the DOM and request serverside update
    addOrUpdateExpenseCard(selectedExpense);

    let categoryId = categories.indexOf(expenseType);
    requestUpdateExpense(selectedExpense.id, expenseName, notes, expenseAmount, categoryId, startDate, endDate);
  } else {
    // Create expense
    const newExpense = {
      id: expenses.length + 1,
      title: expenseName,
      category: expenseType,
      amountSpent: 0,
      amountAllocated: expenseAmount,
      image_id: categories.indexOf(expenseType),
      startDate: startDate,
      endDate: endDate,
      notes: notes,
      progress: calculateProgress(expenseAmount, expenseAmount),
    };
    expenses.push(newExpense);

    // Create card on the DOM and request serverside update
    addOrUpdateExpenseCard(newExpense);
    requestAddExpense(expenseName, notes, expenseAmount, expenseType, startDate, endDate);
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
        requestDeleteExpense(selectedExpense.id); // Server
        deleteExpense(selectedExpense); // DOM
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

/**
 * Request for an expense to be added to the database.
 * @param {string} description Expense description
 * @param {float} amount Amount in decimal format
 * @param {int} category_id Expense category
 * @param {date} start_date Start date in format yyyy-mm-dd
 * @param {date} end_date (Optional) Defaults to null. End date of expense.
 * 
 * @return {bool} True for success, false otherwise.
 */
function requestAddExpense(title, description, amount, category_id, start_date, end_date = null) {
  $.ajax({
    url: endpoint_budget + '/add-expense',
    type: 'POST',
    contentType: 'application/json',
    data: JSON.stringify({
        title: title,
        description: description,
        amount: amount,
        category_id: category_id,
        start_date: start_date,
        end_date: end_date,
    }),
    success: function(response) {
        console.log(response.message);
        csrfHash = response.csrf;
        return true;
    },
    error: function() {
        console.log("Error adding expense.");
        return false;
    }
  });
}

function requestDeleteExpense(expense_id) {
  $.ajax({
    url: endpoint_budget + '/delete-expense/' + expense_id,
    type: 'POST',
    success: function(response) {
        console.log(response.message);
        csrfHash = response.csrf;
    },
    error: function() {
        console.log("Error deleting expense.");
    }
  });
}

function requestUpdateExpense(expense_id, title, description, amount, category_id, start_date, end_date = null) {
  $.ajax({
    url: endpoint_budget + '/update-expense/' + expense_id,
    type: 'POST',
    contentType: 'application/json',
    data: JSON.stringify({
        title: title,
        description: description,
        amount: amount,
        category_id: category_id,
        start_date: start_date,
        end_date: end_date,
    }),
    success: function(response) {
        console.log(response.message);
    },
    error: function() {
        console.log("Error updating expense.");
    }
  });
}

function initialiseBudgetView() {
  // Create expenses array
  expensesData.forEach(item => {
    let expense = {
        id: item.expense_id,
        title: item.title,
        category: categories[item.category_id],
        amountSpent: 0,
        amountAllocated: item.amount,
        image_id: item.category_id,
        startDate: item.start_date,
        endDate: item.end_date,
        notes: item.description,
        progress: 80
    };

    expenses.push(expense);
  });

  // Populate categories selector
  document.addEventListener("DOMContentLoaded", function() {
    const expenseTypeSelect = document.getElementById("expenseType");
    categories.forEach(category => {
      const option = document.createElement("option");
      option.value = category;
      option.textContent = category;
      expenseTypeSelect.appendChild(option);
    });
  });
}

function buildBudgetDashboard() {

  const projectedExpenses = expensesData.reduce((sum, expense) => sum + parseFloat(expense.amount), 0);
  addCard({
      title: "Projected Expenses",
      amount: "R " + projectedExpenses.toLocaleString(),
      subtitle: "Total expected expenses",
      href: "javascript:void(0)"
  });

  const wealthBuildingCategories = [0, 5, 7, 15, 26];
  const wealthBuildingdAmount = expensesData
      .filter(expense => wealthBuildingCategories.includes(parseInt(expense.category_id)))
      .reduce((sum, expense) => sum + parseFloat(expense.amount), 0);

  addCard({
      title: "Wealth building spend",
      amount: "R " + wealthBuildingdAmount.toLocaleString(),
      subtitle: "Projected net worth growth",
      href: "javascript:void(0)"
  });

  addCard({
      title: "Total expenses",
      amount: "R " + 0,
      subtitle: "Actual amount spent",
      href: "javascript:void(0)"
  });

  addCard({
      title: "Budget remaining",
      amount: "R " + 0,
      subtitle: "Unspent funds allocated",
      href: "javascript:void(0)"
  });
}

initialiseBudgetView();
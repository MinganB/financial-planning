<script>
    window.onload = function() {
        buildBudgetDashboard();
    };

    const expensesData = <?= json_encode($expenseData) ?>;
    const endpoint_budget = '<?= base_url('me/budget') ?>';
</script>

<div class="container mt-4">
    <h3 class="mb-4">My budget</h3>

    <!-- Cards -->
    <div id="dashboardCards" class="row mb-5 g-2">
    </div>

    <!-- Tabs -->
    <ul class="nav nav-tabs" id="expenseTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="categories-tab" data-bs-toggle="tab" data-bs-target="#categories" type="button" role="tab" aria-controls="categories" aria-selected="true">
                Categories
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="monthly-expenses-tab" data-bs-toggle="tab" data-bs-target="#monthly-expenses" type="button" role="tab" aria-controls="monthly-expenses" aria-selected="false">
                Expenses
            </button>
        </li>
    </ul>

    <div class="tab-content mt-3" id="expenseTabsContent">
        <!-- Categories -->
        <div class="tab-pane fade show active" id="categories" role="tabpanel" aria-labelledby="categories-tab">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="my-4">Expense Categories</h4>
                <a href="#" id="add-new-link" class="d-none d-md-inline-block btn btn-link text-decoration-none" data-bs-toggle="modal" data-bs-target="#expenseModal">+ Add new</a>
            </div>
            
            <div class="row" id="expense-cards"></div>
        </div>

        <!-- Month's Expenses -->
        <div class="tab-pane fade" id="monthly-expenses" role="tabpanel" aria-labelledby="monthly-expenses-tab">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="my-4">This Month's Expenses</h4>
                <a href="#" id="add-monthly-expense-link" class="d-none d-md-inline-block btn btn-link text-decoration-none" data-bs-toggle="modal" data-bs-target="#monthlyExpenseModal">+ Add new</a>
            </div>
            
        </div>
    </div>

</div>

<!-- Floating Action Button (mobile only) -->
<button id="fab-add-new" class="btn btn-primary rounded-circle d-md-none" data-bs-toggle="modal" data-bs-target="#expenseModal">
    +
</button>

<script src="<?= base_url('js/cards.js?v=0.0.1') ?>"></script>
<script src="<?= base_url('js/budget/logic.js?v=0.0.1') ?>"></script>
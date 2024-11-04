<link href="<?= base_url('css/dashboard.css?v=0.0.2') ?>" rel="stylesheet">

<script>
    const expenses = <?= json_encode($expenseData) ?>;
    const endpoint_budget = '<?= base_url('me/budget') ?>';
</script>

<div class="container mt-4">
    <h3 class="mb-4">Welcome back, <?= auth()->user()->username ?></h3>

    <!-- Cards -->
    <div id="dashboardCards" class="row mb-5 g-2">
    </div>

    <!-- Actions grid -->
    <h4 class="my-4">What would you like to do?</h4>
    <div class="row g-3 mt-3">
        <a class="col-4 col-lg-2 text-center action-icon-div" data-bs-toggle="modal" data-bs-target="#incomeModal">
            <img src="<?= base_url('img/icons8-income-94.png') ?>" alt="Add Income" class="img-fluid action-icon">
            <p class="mt-2 fw-light">Log Income</p>
        </a>
        <a class="col-4 col-lg-2 text-center action-icon-div" data-bs-toggle="modal" data-bs-target="#actualExpenseModal">
            <img src="<?= base_url('img/icons8-card-wallet-94.png') ?>" alt="Add Expense" class="img-fluid action-icon">
            <p class="mt-2 fw-light">Log Expense</p>
        </a>
        <a href="<?= base_url('me/budget') ?>" class="col-4 col-lg-2 text-center action-icon-div">
            <img src="<?= base_url('img/icons8-budget-94.png') ?>" alt="Budget" class="img-fluid action-icon">
            <p class="mt-2 fw-light">View Budget</p>
        </a>
        <a href="<?= base_url('me/net-worth') ?>" class="col-4 col-lg-2 text-center action-icon-div">
            <img src="<?= base_url('img/icons8-fund-accounting-94.png') ?>" alt="Net Worth" class="img-fluid action-icon">
            <p class="mt-2 fw-light">Net Worth</p>
        </a>
        <a href="<?= base_url('me/planning') ?>" class="col-4 col-lg-2 text-center action-icon-div">
            <img src="<?= base_url('img/icons8-journal-94.png') ?>" alt="Reports" class="img-fluid action-icon">
            <p class="mt-2 fw-light">Financial Plan</p>
        </a>
        <a href="<?= base_url('me/settings') ?>" class="col-4 col-lg-2 text-center action-icon-div">
            <img src="<?= base_url('img/icons8-settings-94.png') ?>" alt="Settings" class="img-fluid action-icon">
            <p class="mt-2 fw-light">App Settings</p>
        </a>
    </div>
</div>

<script src="<?= base_url('js/cards.js?v=0.0.1') ?>"></script>

<script>
    function buildMainDashboard() {
        const totalSpentAmount = 0;
        addCard({
            title: "Net worth",
            amount: "R " + totalSpentAmount.toLocaleString(),
            subtitle: "Total net assets",
            href: base_url + '/me/budget',
        });

        const projectedExpenses = expenses.reduce((sum, expense) => sum + parseFloat(expense.amount), 0);
        addCard({
            title: "Projected Expenses",
            amount: "R " + projectedExpenses.toLocaleString(),
            subtitle: "This month's expenses",
            href: base_url + '/me/budget',
        });

        const wealthBuildingCategories = [0, 5, 7, 15, 26];
        const wealthBuildingdAmount = expenses
            .filter(expense => wealthBuildingCategories.includes(parseInt(expense.category_id)))
            .reduce((sum, expense) => sum + parseFloat(expense.amount), 0);

        addCard({
            title: "Net worth growth",
            amount: "R " + wealthBuildingdAmount.toLocaleString(),
            subtitle: "Increase this month",
            href: base_url + '/me/net-worth',
        });

        const income = 20000;
        addCard({
            title: "Income",
            amount: "R " + income.toLocaleString(),
            subtitle: "This month's income",
            href: base_url + '/me/net-worth',
        });
    }

    buildMainDashboard();
</script>
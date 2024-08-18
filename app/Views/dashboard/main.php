<link href="<?= base_url('css/dashboard.css?v=0.0.2') ?>" rel="stylesheet">

<script>
    const cardData = [{
            title: "Net Worth",
            amount: "R1,200,000",
            subtitle: "Assets minus liabilities",
            href: "<?= base_url('me/net-worth') ?>",
        },
        {
            title: "Total Income",
            amount: "R20,000",
            subtitle: "This month's income",
            href: "<?= base_url('me/budget') ?>",
        },
        {
            title: "Total Expenses",
            amount: "R15,000",
            subtitle: "This month's expenses",
            href: "<?= base_url('me/budget') ?>",
        },
        {
            title: "Savings",
            amount: "R5,000",
            subtitle: "Amount saved this month",
            href: "<?= base_url('me/net-worth') ?>",
        },
    ];
</script>

<div class="container mt-4">
    <h3 class="mb-4">Welcome back, John</h3>

    <!-- Dashboard Cards -->
    <div id="dashboardCards" class="row mb-5 g-2">
    </div>

    <!-- Actions heading -->
    <h4 class="my-4">What would you like to do?</h4>

    <!-- Actions grid -->
    <div class="row g-3 mt-3">
        <div class="col-4 col-lg-2 text-center action-icon-div">
            <img src="<?= base_url('img/icons8-income-94.png') ?>" alt="Add Income" class="img-fluid action-icon">
            <p class="mt-2 fw-light">Log Income</p>
        </div>
        <div class="col-4 col-lg-2 text-center action-icon-div">
            <img src="<?= base_url('img/icons8-card-wallet-94.png') ?>" alt="Add Expense" class="img-fluid action-icon">
            <p class="mt-2 fw-light">Log Expense</p>
        </div>
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
        <a href="<?= base_url('me/profile') ?>" class="col-4 col-lg-2 text-center action-icon-div">
            <img src="<?= base_url('img/icons8-user-94.png') ?>" alt="Settings" class="img-fluid action-icon">
            <p class="mt-2 fw-light">My details</p>
        </a>
    </div>
</div>

<script src="<?= base_url('js/cards.js?v=0.0.1') ?>"></script>
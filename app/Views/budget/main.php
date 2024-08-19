<script>
    const cardData = [{
            title: "Savings",
            amount: "R13,200",
            subtitle: "Total liquid savings",
            href: "",
        },
        {
            title: "Total investments",
            amount: "R20,000",
            subtitle: "Total investments",
            href: "",
        },
        {
            title: "Expenses",
            amount: "R8,000",
            subtitle: "Total monthly expenses",
            href: "",
        },
        {
            title: "Income",
            amount: "R45,000",
            subtitle: "Total monthly income",
            href: "",
        },
    ];

    var expenses = [{
            id: 1,
            title: "Housing",
            category: "Living Expenses",
            amountSpent: 5000,
            amountAllocated: 7000,
            image_id: 0,
            startDate: "2024-01-01",
            endDate: null,
            notes: "",
            progress: 71,
        },
        {
            id: 2,
            title: "Transportation",
            category: "Travel",
            amountSpent: 500,
            amountAllocated: 3000,
            image_id: 1,
            startDate: "2024-01-01",
            endDate: null,
            notes: "",
            progress: 44,
        },
        {
            id: 3,
            title: "Food",
            category: "Groceries",
            amountSpent: 1700,
            amountAllocated: 2500,
            image_id: 2,
            startDate: "2024-01-01",
            endDate: null,
            notes: "",
            progress: 12,
        },
        {
            id: 4,
            title: "Entertainment",
            category: "Leisure",
            amountSpent: 1000,
            amountAllocated: 1500,
            image_id: 3,
            startDate: "2024-01-01",
            endDate: null,
            notes: "",
            progress: 94,
        },
    ];

    const images = [
        base_url + "/img/icons8-home-94.png", // housing
        base_url + "/img/icons8-road-94.png", // transport
        base_url + "/img/icons8-noodles-94.png", // food
        base_url + "/img/icons8-carousel-94.png", // entertainment
        base_url + "/img/icons8-electricity-94.png", // utilities
        base_url + "/img/icons8-receipt-94.png", // misc
    ];
</script>

<div class="container mt-4">
    <h3 class="mb-4">My budget</h3>

    <!-- Cards -->
    <div id="dashboardCards" class="row mb-5 g-2">
    </div>

    <!-- Expenses -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="my-4">All expenses</h4>
        <a href="#" id="add-new-link" class="d-none d-md-inline-block btn btn-link text-decoration-none" data-bs-toggle="modal" data-bs-target="#expenseModal">+ Add new</a>
    </div>

    <!-- Expense Cards Grid -->
    <div class="row" id="expense-cards"></div>

</div>

<!-- Floating Action Button (mobile only) -->
<button id="fab-add-new" class="btn btn-primary rounded-circle d-md-none" data-bs-toggle="modal" data-bs-target="#expenseModal">
    +
</button>

<script src="<?= base_url('js/cards.js?v=0.0.1') ?>"></script>
<script src="<?= base_url('js/budget/logic.js?v=0.0.1') ?>"></script>
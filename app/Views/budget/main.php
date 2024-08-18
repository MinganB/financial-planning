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
</script>

<div class="container mt-4">
    <h3 class="mb-4">My budget</h3>

    <!-- Cards -->
    <div id="dashboardCards" class="row mb-5 g-2">
    </div>

</div>

<script src="<?= base_url('js/cards.js?v=0.0.1') ?>"></script>
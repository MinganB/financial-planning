<link href="<?= base_url('css/fab.css?v=0.0.2') ?>" rel="stylesheet">

<script>
    let netWorth = JSON.parse(`<?= $netWorthJson ?>`);
    console.log(JSON.stringify(netWorth));

    const images = [
        base_url + "/img/icons8-home-94.png", // Property
        base_url + "/img/icons8-car-94.png", // Vehicles
        base_url + "/img/icons8-money-box-94.png", // Savings
        base_url + "/img/icons8-money-94.png", // Investments
        base_url + "/img/icons8-bank-94.png", // Loans
        base_url + "/img/icons8-credit-card-cv-94.png", // Credit cards
        base_url + "/img/icons8-bonds-94.png", // Pensions
        base_url + "/img/icons8-company-94.png", // Business interest
        base_url + "/img/icons8-cash-94.png", // Cash
        base_url + "/img/icons8-tv-94.png", // Household content
        base_url + "/img/icons8-physical-gallery-94.png", // Art
        base_url + "/img/icons8-jewelery-94.png", // Jewellery
        base_url + "/img/icons8-guarantee-94.png", // Insurance
        base_url + "/img/icons8-closet-94.png", // Personal
        base_url + "/img/icons8-cloakroom-94.png", // Clothing
        base_url + "/img/icons8-store-94.png", // Store accounts
        base_url + "/img/icons8-slice-94.png", // Employee benefits
        base_url + "/img/icons8-receipt-94.png", // Other
    ];

    const categories = [
        "Property",           // 0
        "Vehicles",           // 1
        "Savings",            // 2
        "Investments",        // 3
        "Loans",              // 4
        "Credit Cards",       // 5
        "Pensions & Retirement", // 6
        "Business Interests", // 7
        "Cash",               // 8
        "Household Contents", // 9
        "Art & Collectibles", // 10
        "Jewellery",          // 11
        "Insurance Policies", // 12
        "Personal Assets",    // 13
        "Clothing",           // 14
        "Store Accounts",     // 15
        "Employee Benefits",  // 16
        "Other",              // 17
    ];

    window.onload = function() {
        buildDashboard();
    };

    // Add aggregation cards
    function buildDashboard() {
        // Clear the dashboard
        let dashboardCardsContainer = document.getElementById("dashboardCards");
        if(dashboardCardsContainer) {
            while (dashboardCardsContainer.firstChild) {
                dashboardCardsContainer.removeChild(dashboardCardsContainer.firstChild);
            }
        }

        const totalAssets = netWorth.assets.reduce((sum, asset) => sum + parseFloat(asset.value), 0);
        const totalLiabilities = netWorth.liabilities.reduce((sum, liability) => sum + parseFloat(liability.value), 0);
        const totalNetWorth = (totalAssets - totalLiabilities);

        const liquidAssetCategories = [2, 3, 8];
        const totalLiquidAssets = netWorth.assets
            .filter(asset => liquidAssetCategories.includes(parseInt(asset.category_id)))
            .reduce((sum, asset) => sum + parseFloat(asset.value), 0);

        addCard({
            title: "Net Worth",
            amount: "R " + totalNetWorth.toLocaleString(),
            subtitle: "Assets minus debts",
            href: "javascript:void(0)"
        });

        addCard({
            title: "Total Assets",
            amount: "R " + totalAssets.toLocaleString(),
            subtitle: "Everything you own",
            href: "javascript:void(0)"
        });

        addCard({
            title: "Total Liabilities",
            amount: "R " + totalLiabilities.toLocaleString(),
            subtitle: "All your debt",
            href: "javascript:void(0)"
        });

        addCard({
            title: "Liquidity",
            amount: "R " + totalLiquidAssets.toLocaleString(),
            subtitle: "How much cash you have",
            href: "javascript:void(0)"
        });
    }
</script>

<div class="container mt-4">
    <h3 class="my-4">Net Worth</h3>

    <!-- Cards -->
    <div id="dashboardCards" class="row mb-5 g-2">
    </div>

    <ul class="nav nav-tabs mb-4" id="netWorthTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="assets-tab" data-bs-toggle="tab" data-bs-target="#assets" type="button" role="tab" aria-controls="assets" aria-selected="true">What I have</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="liabilities-tab" data-bs-toggle="tab" data-bs-target="#liabilities" type="button" role="tab" aria-controls="liabilities" aria-selected="false">What I owe</button>
        </li>
    </ul>

    <div class="tab-content" id="netWorthTabsContent">
        <div class="tab-pane fade show active" id="assets" role="tabpanel" aria-labelledby="assets-tab">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="my-4">Assets</h4>
                <a href="#" id="add-new-asset-link" class="d-none d-md-inline-block btn btn-link text-decoration-none" data-bs-toggle="modal" data-bs-target="#assetModal">+ Add new</a>
            </div>
            <div id="assets-content" class="row"></div>
        </div>
        
        <div class="tab-pane fade" id="liabilities" role="tabpanel" aria-labelledby="liabilities-tab">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="my-4">Liabilities</h4>
                <a href="#" id="add-new-liability-link" class="d-none d-md-inline-block btn btn-link text-decoration-none" data-bs-toggle="modal" data-bs-target="#liabilityModal">+ Add new</a>
            </div>
            <div id="liabilities-content" class="row"></div>
        </div>
    </div>
</div>

<!-- FAB -->
<div class="fab-container">
    <button id="fab-add-new" class="btn btn-primary rounded-circle">
        +
    </button>
    <div id="fab-menu" class="fab-menu d-none">
        <button id="fab-add-asset" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#assetModal">Add Asset</button>
        <button id="fab-add-liability" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#liabilityModal">Add Liability</button>
    </div>
</div>

<!-- Asset Modal -->
<div class="modal fade" id="assetModal" tabindex="-1" aria-labelledby="assetModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-3 shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title" id="assetModalLabel">Add/Edit Asset</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="assetForm">
                    <div class="mb-3">
                        <label for="assetName" class="form-label">Asset name</label>
                        <input type="text" class="form-control" id="assetName" required>
                    </div>
                    <div class="mb-3">
                        <label for="assetValue" class="form-label">Value</label>
                        <input type="number" class="form-control" id="assetValue" required>
                    </div>
                    <div class="mb-3">
                        <label for="assetCategory" class="form-label">Category</label>
                        <select class="form-select" id="assetCategory" required>
                            <!-- Added dynamically -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="assetNotes" class="form-label">Notes</label>
                        <textarea class="form-control" id="assetNotes" rows="3"></textarea>
                    </div>
                    <div class="text-end">
                        <a href="#" id="deleteAsset" class="text-danger">Delete asset</a>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveAssetButton">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Liability Modal -->
<div class="modal fade" id="liabilityModal" tabindex="-1" aria-labelledby="liabilityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-3 shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title" id="liabilityModalLabel">Add/Edit Liability</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="liabilityForm">
                    <div class="mb-3">
                        <label for="liabilityName" class="form-label">Liability name</label>
                        <input type="text" class="form-control" id="liabilityName" required>
                    </div>
                    <div class="mb-3">
                        <label for="liabilityAmount" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="liabilityAmount" required>
                    </div>
                    <div class="mb-3">
                        <label for="liabilityCategory" class="form-label">Category</label>
                        <select class="form-select" id="liabilityCategory" required>
                            <!-- Added dynamically -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="liabilityNotes" class="form-label">Notes</label>
                        <textarea class="form-control" id="liabilityNotes" rows="3"></textarea>
                    </div>
                    <div class="text-end">
                        <a href="#" id="deleteLiability" class="text-danger">Delete liability</a>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveLiabilityButton">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('js/networth/logic.js?v=0.0.4') ?>"></script>
<script src="<?= base_url('js/cards.js?v=0.0.2') ?>"></script>
<link href="<?= base_url('css/fab.css?v=0.0.2') ?>" rel="stylesheet">

<script>
    let netWorth = {
        assets: [
            {
            id: 1,
            name: "Primary Residence",
            value: 500000,
            category: "Property",
            image_id: 1,
            notes: ""
            },
            {
            id: 2,
            name: "Car",
            value: 20000,
            category: "Motor Vehicles",
            image_id: 3,
            notes: ""
            }
        ],
        liabilities: [
            {
            id: 1,
            name: "Mortgage",
            value: 250000,
            category: "Mortgage",
            image_id: 2,
            notes: ""
            },
            {
            id: 2,
            name: "Auto Loan",
            value: 15000,
            category: "Auto Loan",
            image_id: 4,
            notes: ""
            }
        ]
    };

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
    <h3 class="my-4">Net Worth</h3>

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
                            <option value="Property">Property</option>
                            <option value="Motor Vehicles">Motor Vehicles</option>
                            <option value="Investments">Investments</option>
                            <!-- Add more categories as needed -->
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
                            <option value="Mortgage">Mortgage</option>
                            <option value="Auto Loan">Auto Loan</option>
                            <option value="Credit Card">Credit Card</option>
                            <!-- TODO: Add more categories -->
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

<script src="<?= base_url('js/networth/logic.js') ?>"></script>
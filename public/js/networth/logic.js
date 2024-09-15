let selectedAsset = null; // Track the asset being edited
let selectedLiability = null; // Track the liability being edited

// Function to add or update an asset card
function addOrUpdateAssetCard(asset) {
  const assetsContainer = document.getElementById("assets-content");

  // Check if card already exists
  let existingCard = document.querySelector(`[data-id='asset-${asset.id}']`);
  let card;

  if (existingCard) {
    card = existingCard;
    card.innerHTML = ""; // Clear existing content
  } else {
    card = document.createElement("div");
    card.className = "col-12 col-md-4 mb-3";
    card.setAttribute("data-id", `asset-${asset.id}`);
  }

  const cardContent = createCardContentHTML(images[asset.image_id], asset.name, asset.category, asset.value.toLocaleString());

  card.innerHTML = cardContent;

  // Open modal for editing
  card.addEventListener("click", function() {
    openEditAssetModal(asset);
  });

  if (!existingCard) {
    assetsContainer.appendChild(card);
  }
}

// Add or update liability
function addOrUpdateLiabilityCard(liability) {
  const liabilitiesContainer = document.getElementById("liabilities-content");

  // Check if the card already exists
  let existingCard = document.querySelector(
    `[data-id='liability-${liability.id}']`
  );
  let card;

  if (existingCard) {
    card = existingCard;
    card.innerHTML = ""; // Clear existing content
  } else {
    card = document.createElement("div");
    card.className = "col-12 col-md-4 mb-3";
    card.setAttribute("data-id", `liability-${liability.id}`);
  }

  const cardContent = createCardContentHTML(images[liability.image_id], liability.name, liability.category, liability.value.toLocaleString());

  card.innerHTML = cardContent;

  card.addEventListener("click", function() {
    openEditLiabilityModal(liability);
  });

  if (!existingCard) {
    liabilitiesContainer.appendChild(card);
  }
}

// Initialize the assets and liabilities on load
netWorth.assets.forEach(asset => addOrUpdateAssetCard(asset));
netWorth.liabilities.forEach(liability => addOrUpdateLiabilityCard(liability));

function createCardContentHTML(image_id, title, subtitle, amount) {
        return `
          <div class="card p-3">
              <div class="d-flex justify-content-between align-items-center">
                  <div class="d-flex align-items-center">
                      <div class="expense-icon me-3">
                        <img src="${image_id}" class="mobile-hidden" alt="${title}" class="img-fluid" width="40">
                      </div>
                      <div>
                          <h5 class="card-title mb-0">${title}</h5>
                          <p class="card-category text-muted">${subtitle}</p>
                      </div>
                  </div>
                  <div class="text-end">
                      <h6 class="card-amount mb-1">R${amount}</h6>
                  </div>
              </div>
          </div>
      `;
}

// Edit asset modal
function openEditAssetModal(asset) {
  selectedAsset = asset;

  document.getElementById("assetModalLabel").textContent = asset
    ? "Edit Asset"
    : "Add Asset";
  document.getElementById("assetName").value = asset ? asset.name : "";
  document.getElementById("assetValue").value = asset ? asset.value : "";
  document.getElementById("assetCategory").value = asset ? asset.category : "";
  document.getElementById("assetNotes").value = asset ? asset.notes : "";

  document.getElementById("deleteAsset").style.display = asset
    ? "inline"
    : "none";

  const modal = new bootstrap.Modal(document.getElementById("assetModal"));
  modal.show();
}

// Edit liability
function openEditLiabilityModal(liability) {
  selectedLiability = liability;

  document.getElementById("liabilityModalLabel").textContent = liability
    ? "Edit Liability"
    : "Add Liability";
  document.getElementById("liabilityName").value = liability
    ? liability.name
    : "";
  document.getElementById("liabilityAmount").value = liability
    ? liability.amount
    : "";
  document.getElementById("liabilityCategory").value = liability
    ? liability.category
    : "";
  document.getElementById("liabilityNotes").value = liability
    ? liability.notes
    : "";

  document.getElementById("deleteLiability").style.display = liability
    ? "inline"
    : "none";

  const modal = new bootstrap.Modal(document.getElementById("liabilityModal"));
  modal.show();
}

// Save asset
document
  .getElementById("saveAssetButton")
  .addEventListener("click", function() {
    const assetName = document.getElementById("assetName").value.trim();
    const assetValue = parseFloat(document.getElementById("assetValue").value);
    const assetCategory = document.getElementById("assetCategory").value.trim();
    const assetNotes = document.getElementById("assetNotes").value.trim();

    if (!assetName || isNaN(assetValue) || !assetCategory) {
      alert("Please fill in all required fields.");
      return;
    }

    if (selectedAsset) {
      // Update existing asset
      selectedAsset.name = assetName;
      selectedAsset.value = assetValue;
      selectedAsset.category = assetCategory;
      selectedAsset.notes = assetNotes;

      // Update card in DOM
      addOrUpdateAssetCard(selectedAsset);
    } else {
      const newAsset = {
        id: netWorth.assets.length + 1,
        name: assetName,
        value: assetValue,
        category: assetCategory,
        image_id: 1,
        notes: assetNotes
      };
      netWorth.assets.push(newAsset);
      addOrUpdateAssetCard(newAsset);
    }

    const modal = bootstrap.Modal.getInstance(
      document.getElementById("assetModal")
    );
    modal.hide();

    selectedAsset = null;

    resetAssetModalFields();
  });

// Save in liability modal
document
  .getElementById("saveLiabilityButton")
  .addEventListener("click", function() {
    const liabilityName = document.getElementById("liabilityName").value.trim();
    const liabilityAmount = parseFloat(
      document.getElementById("liabilityAmount").value
    );
    const liabilityCategory = document
      .getElementById("liabilityCategory")
      .value.trim();
    const liabilityNotes = document
      .getElementById("liabilityNotes")
      .value.trim();

    if (!liabilityName || isNaN(liabilityAmount) || !liabilityCategory) {
      alert("Please fill in all required fields.");
      return;
    }

    if (selectedLiability) {
      // Update existing liability
      selectedLiability.name = liabilityName;
      selectedLiability.amount = liabilityAmount;
      selectedLiability.category = liabilityCategory;
      selectedLiability.notes = liabilityNotes;

      // DOM update
      addOrUpdateLiabilityCard(selectedLiability);
    } else {
      // Create new liability
      const newLiability = {
        id: netWorth.liabilities.length + 1,
        name: liabilityName,
        value: liabilityAmount,
        category: liabilityCategory,
        image_id: 1,
        notes: liabilityNotes
      };
      netWorth.liabilities.push(newLiability);
      addOrUpdateLiabilityCard(newLiability);
    }

    const modal = bootstrap.Modal.getInstance(
      document.getElementById("liabilityModal")
    );
    modal.hide();

    // Reset selected liability and form fields
    selectedLiability = null;
    resetLiabilityModalFields();
  });

// Reset asset and liability modal fields when closing
function resetAssetModalFields() {
  document.getElementById("assetForm").reset();
  document.getElementById("deleteAsset").style.display = "none";
}

function resetLiabilityModalFields() {
  document.getElementById("liabilityForm").reset();
  document.getElementById("deleteLiability").style.display = "none";
}

// Delete selected asset
function deleteAsset(asset) {
  if (asset) {
    netWorth.assets = netWorth.assets.filter(a => a.id !== asset.id);

    const cardToDelete = document.querySelector(
      `[data-id='asset-${asset.id}']`
    );
    if (cardToDelete) {
      cardToDelete.remove();
    }

    const modal = bootstrap.Modal.getInstance(
      document.getElementById("assetModal")
    );
    modal.hide();

    selectedAsset = null;
  }
}

// Delete the selected liability
function deleteLiability(liability) {
  if (liability) {
    netWorth.liabilities = netWorth.liabilities.filter(
      l => l.id !== liability.id
    );

    const cardToDelete = document.querySelector(
      `[data-id='liability-${liability.id}']`
    );
    if (cardToDelete) {
      cardToDelete.remove();
    }

    const modal = bootstrap.Modal.getInstance(
      document.getElementById("liabilityModal")
    );
    modal.hide();

    selectedLiability = null;
  }
}

// Delete link in asset modal
document.getElementById("deleteAsset").addEventListener("click", function(e) {
  e.preventDefault();

  if (confirm("Are you sure you want to delete this asset?")) {
    deleteAsset(selectedAsset);
  }
});

// Delete link in liability modal
document
  .getElementById("deleteLiability")
  .addEventListener("click", function(e) {
    e.preventDefault();

    if (confirm("Are you sure you want to delete this liability?")) {
      deleteLiability(selectedLiability);
    }
  });

// Reset modal fields (asset)
document
  .getElementById("assetModal")
  .addEventListener("hidden.bs.modal", resetAssetModalFields);

// Reset modal fields (liability)
document
  .getElementById("liabilityModal")
  .addEventListener("hidden.bs.modal", resetLiabilityModalFields);

// Toggle FAB menu
document.getElementById("fab-add-new").addEventListener("click", function() {
  const fabMenu = document.getElementById("fab-menu");
  if (fabMenu.classList.contains("d-none")) {
    fabMenu.classList.remove("d-none");
  } else {
    fabMenu.classList.add("d-none");
  }
});

// Hide FAB when selecting option
document.getElementById("fab-add-asset").addEventListener("click", function() {
  document.getElementById("fab-menu").classList.add("d-none");
});

document
  .getElementById("fab-add-liability")
  .addEventListener("click", function() {
    document.getElementById("fab-menu").classList.add("d-none");
  });

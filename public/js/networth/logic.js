let selectedAsset = null; // Track the asset being edited
let selectedLiability = null; // Track the liability being edited

// Function to add or update an asset card
function addOrUpdateAssetCard(asset) {
  const assetsContainer = document.getElementById("assets-content");

  // Check if card already exists
  let existingCard = document.querySelector(`[data-id='asset-${asset.asset_id}']`);
  let card;

  if (existingCard) {
    console.log("Updating asset card: "+JSON.stringify(asset));
    card = existingCard;
    card.innerHTML = ""; // Clear existing content
  } else {
    console.log("Creating asset card: "+JSON.stringify(asset));
    card = document.createElement("div");
    card.className = "col-12 col-md-4 mb-3";
    card.setAttribute("data-id", `asset-${asset.asset_id}`);
  }

  const cardContent = createCardContentHTML(images[asset.category_id], asset.name, categories[asset.category_id], asset.value.toLocaleString());

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
    `[data-id='liability-${liability.liability_id}']`
  );
  let card;

  if (existingCard) {
    card = existingCard;
    card.innerHTML = ""; // Clear existing content
  } else {
    card = document.createElement("div");
    card.className = "col-12 col-md-4 mb-3";
    card.setAttribute("data-id", `liability-${liability.liability_id}`);
  }

  const cardContent = createCardContentHTML(images[liability.category_id], liability.name, categories[liability.category_id], liability.value.toLocaleString());

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

function createCardContentHTML(img_url, title, subtitle, amount) {
        amount = stringToNumber(amount);

        console.log(`Assets added ${title} (${img_url}) of value ${amount}, notes: ${subtitle}`);

        return `
          <div class="card p-3">
              <div class="d-flex justify-content-between align-items-center">
                  <div class="d-flex align-items-center">
                      <div class="expense-icon me-3">
                        <img src="${img_url}" class="mobile-hidden" alt="${title}" class="img-fluid" width="40">
                      </div>
                      <div>
                          <h5 class="card-title mb-0">${title}</h5>
                          <p class="card-category text-muted">${subtitle}</p>
                      </div>
                  </div>
                  <div class="text-end">
                      <h6 class="card-amount mb-1">R ${Number(amount).toLocaleString('en-ZA')}</h6>
                  </div>
              </div>
          </div>
      `;
}

// Clean a numeric string and convert to a number
function stringToNumber(str) {
  let cleanedStr = str.replace(/[^0-9.]/g, '');
  return Math.round(parseFloat(cleanedStr));
}

// Edit asset modal
var assetModal;
function openEditAssetModal(asset) {
  selectedAsset = asset;

  document.getElementById("assetModalLabel").textContent = asset
    ? "Edit Asset"
    : "Add Asset";
  document.getElementById("assetName").value = asset ? asset.name : "";
  document.getElementById("assetValue").value = asset ? asset.value : "";
  document.getElementById("assetCategory").value = asset ? asset.category_id : "";
  document.getElementById("assetNotes").value = asset ? asset.notes : "";

  document.getElementById("deleteAsset").style.display = asset
    ? "inline"
    : "none";

  if (!assetModal) {
    assetModal = new bootstrap.Modal(document.getElementById("assetModal"));
  }
  assetModal.show();
}

// Edit liability
var liabilityModal;
function openEditLiabilityModal(liability) {
  selectedLiability = liability;

  document.getElementById("liabilityModalLabel").textContent = liability
    ? "Edit Liability"
    : "Add Liability";
  document.getElementById("liabilityName").value = liability
    ? liability.name
    : "";
  document.getElementById("liabilityAmount").value = liability
    ? liability.value
    : "";
  document.getElementById("liabilityCategory").value = liability
    ? liability.category_id
    : "";
  document.getElementById("liabilityNotes").value = liability
    ? liability.notes
    : "";

  document.getElementById("deleteLiability").style.display = liability
    ? "inline"
    : "none";

    if(!liabilityModal) {
      liabilityModal = new bootstrap.Modal(document.getElementById("liabilityModal"));
    }
    liabilityModal.show();
}

// Save asset
document
  .getElementById("saveAssetButton")
  .addEventListener("click", function() {
    var assetName = document.getElementById("assetName").value.trim();
    var assetValue = parseFloat(document.getElementById("assetValue").value);
    var assetCategory = document.getElementById("assetCategory").value.trim();
    var assetNotes = document.getElementById("assetNotes").value.trim();

    if (!assetName || isNaN(assetValue) || !assetCategory) {
      alert("Please fill in all required fields.");
      return;
    }

    if (selectedAsset) {
      console.log(selectedAsset);

      // Update existing asset
      selectedAsset.name = assetName;
      selectedAsset.value = assetValue;
      selectedAsset.category_id = assetCategory;
      selectedAsset.notes = assetNotes;

      const updatedAsset = selectedAsset;

      makeAjaxCall('/me/net-worth/update-asset', selectedAsset, (result) => {
        if(result.success) {
          console.log(updatedAsset);
          addOrUpdateAssetCard(updatedAsset);
          buildDashboard();
        } else if(result.message) {
          alert("An error has occured: "+result.message);
        } else {
          alert("An unknown error has occured. Please refresh the page and try again.");
        }
      });
      
    } else {
      // Create a new card
      var newAsset = {
        name: assetName,
        value: assetValue,
        category_id: assetCategory,
        notes: assetNotes,
        create: true, // flags asset as new
      };

      makeAjaxCall('/me/net-worth/update-asset', newAsset, (result) => {
        if(result.success) {
          console.log("Asset created: "+result.assetId);
          newAsset.id = result.assetId;

          netWorth.assets.push(newAsset);
          addOrUpdateAssetCard(newAsset);
          buildDashboard();
        } else if(result.message) {
          alert("An error has occured: "+result.message);
        } else {
          alert("An unknown error has occured. Please refresh the page and try again.");
        }
      });

    }

    if(!assetModal) {
      assetModal = bootstrap.Modal.getInstance(
        document.getElementById("assetModal")
      );

    }
    assetModal.hide();

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
      var updatedLiability = {};

      selectedLiability.name = liabilityName;
      selectedLiability.value = liabilityAmount;
      selectedLiability.category_id = liabilityCategory;
      selectedLiability.notes = liabilityNotes;
      console.log(selectedLiability);

      updatedLiability.liability_id = selectedLiability.liability_id;
      updatedLiability.name = liabilityName;
      updatedLiability.value = liabilityAmount;
      updatedLiability.category_id = liabilityCategory;
      updatedLiability.notes = liabilityNotes;

      console.log(updatedLiability);

      makeAjaxCall('/me/net-worth/update-liability', updatedLiability, (result) => {
        if(result.success) {
          console.log(updatedLiability);
          addOrUpdateLiabilityCard(updatedLiability);
          buildDashboard();
        } else if(result.message) {
          alert("An error has occured: "+result.message);
        } else {
          alert("An unknown error has occured. Please refresh the page and try again.");
        }
      });
    } else {
      // Create new liability
      var newLiability = {
        name: liabilityName,
        value: liabilityAmount,
        category_id: liabilityCategory,
        notes: liabilityNotes,
        create: true,
      };

      makeAjaxCall('/me/net-worth/update-liability', newLiability, (result) => {
        if(result.success) {
          console.log("Liability created: "+result.liabilityId);
          newLiability.id = result.liabilityId;

          netWorth.liabilities.push(newLiability);
          addOrUpdateLiabilityCard(newLiability);
          buildDashboard();
        } else if(result.message) {
          alert("An error has occured: "+result.message);
        } else {
          alert("An unknown error has occured. Please refresh the page and try again.");
        }
      });

    }

    if(!liabilityModal) {
      liabilityModal = bootstrap.Modal.getInstance(
        document.getElementById("liabilityModal")
      );
    }
    liabilityModal.hide();

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
var deleteAssetModal;
function deleteAsset(assetId) {
    var cardToDelete = document.querySelector(
      `[data-id='asset-${assetId}']`
    ); 

    if (cardToDelete) {
      cardToDelete.remove();
    } else {
      console.log("No card found to delete");
    }

    netWorth.assets = netWorth.assets.filter(a => a.asset_id !== assetId);

    if(!deleteAssetModal) {
      deleteAssetModal = bootstrap.Modal.getInstance(
        document.getElementById("assetModal")
      );
    }
    deleteAssetModal.hide();

    selectedAsset = null;
}

// Delete the selected liability
var deleteLiabilityModal;
function deleteLiability(liabilityId) {

    netWorth.liabilities = netWorth.liabilities.filter(
      l => l.liability_id !== liabilityId
    );

    const cardToDelete = document.querySelector(
      `[data-id='liability-${liabilityId}']`
    );
    if (cardToDelete) {
      cardToDelete.remove();
    }

    if(!deleteLiabilityModal) {
      deleteLiabilityModal = bootstrap.Modal.getInstance(
        document.getElementById("liabilityModal")
      );
    }
    deleteLiabilityModal.hide();

    selectedLiability = null;
}

// Delete link in asset modal
document.getElementById("deleteAsset").addEventListener("click", function(e) {
  e.preventDefault();

  if (confirm("Are you sure you want to delete this asset?")) {
    const args = { assetId: selectedAsset.asset_id };

    makeAjaxCall('/me/net-worth/delete-asset', args, (result) => {
      if(result.success) {
        deleteAsset(args.assetId);
        buildDashboard();
      } else if(result.message) {
        alert("An error has occured: "+result.message);
      } else {
        alert("An unknown error has occured. Please refresh the page and try again.");
      }
    });
  }
});

// Delete link in liability modal
document
  .getElementById("deleteLiability")
  .addEventListener("click", function(e) {
    e.preventDefault();

    if (confirm("Are you sure you want to delete this liability?")) {
      const args = { liabilityId: selectedLiability.liability_id };

      makeAjaxCall('/me/net-worth/delete-liability', args, (result) => {
        if(result.success) {
          deleteLiability(args.liabilityId);
          buildDashboard();
        } else if(result.message) {
          alert("An error has occured: "+result.message);
        } else {
          alert("An unknown error has occured. Please refresh the page and try again.");
        }
      });
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

// Setup the select fields with categories
const assetsSelector = document.getElementById('assetCategory');
const liabilitiesSelector = document.getElementById('liabilityCategory');

  categories.forEach((category, index) => {
    if(assetsSelector) addSelectorOption(assetsSelector, index, category);
    if(liabilitiesSelector) addSelectorOption(liabilitiesSelector, index, category);
});

function addSelectorOption(selector, index, content) {
  const option = document.createElement('option');
  option.value = index; 
  option.textContent = content; 
  selector.appendChild(option);
}
    
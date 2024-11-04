function populateSharedAccessList() {
  const sharedAccessList = document.getElementById("sharedAccessList");

  sharedAccessData.forEach((user) => {
    const listItem = document.createElement("li");
    listItem.className = "list-group-item";
    listItem.innerHTML = `
              <span>${user.name} - ${user.role}</span>
              <span class="remove-button" data-user-id="${user.user_id}">Remove</span>
          `;

    sharedAccessList.appendChild(listItem);
  });
}

/**
 * Event listener - removed shared user
 */
document
  .getElementById("sharedAccessList")
  .addEventListener("click", function (e) {
    if (e.target.classList.contains("remove-button")) {
      const userId = e.target.getAttribute("data-user-id");
      removeSharedUser(userId);
    }
  });

/**
 * Removed shared user from list
 */
function removeSharedUser(userId) {
  const index = sharedAccessData.findIndex((user) => user.user_id == userId);
  if (index > -1) {
    sharedAccessData.splice(index, 1);
    document.getElementById("sharedAccessList").innerHTML = "";
    populateSharedAccessList();
  }
}

/**
 * Event listener - update password
 */
document
  .getElementById("updatePasswordButton")
  .addEventListener("click", function () {
    const newPassword = document.getElementById("newPassword").value;
    const confirmPassword = document.getElementById("confirmPassword").value;

    if (newPassword && newPassword === confirmPassword) {
      fetch(base_url + 'me/settings/update-password', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({
          newPassword: newPassword
        })
      })
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          alert("Password updated successfully.");
          document.getElementById("newPassword").value = "";
          document.getElementById("confirmPassword").value = "";
        } else {
          alert(data.message || "Failed to update password.");
        }
      })
      .catch(error => {
        console.error("Error:", error);
        alert("An error occurred while updating the password.");
      });
    } else {
      alert("Passwords do not match.");
    }
  });

/**
 * Event listener - update privacy settings
 */
document
  .getElementById("updatePrivacyButton")
  .addEventListener("click", function () {
    const sharingSettings = document.getElementById("sharingSettings").value;
    const budgetVisibility = document.getElementById("budgetVisibility").value;
    const netWorthVisibility = document.getElementById("netWorthVisibility").value;

    makeAjaxCall('me/settings/update-privacy-settings', {
      sharing: sharingSettings,
      budget_visibility: budgetVisibility,
      net_worth_visibility: netWorthVisibility,
    }, (result) => {
      alert(result.message);
    });
  });

/**
 * Event listener - account deletion
 */
document
  .getElementById("deleteAccountLink")
  .addEventListener("click", function (e) {
    e.preventDefault();
    if (
      confirm(
        "Are you sure you want to delete your account? This action cannot be undone."
      )
    ) {
      requestDeleteUserAccount();
    }
  });

// Initialise the page
populateSharedAccessList();

function requestDeleteUserAccount() {
  fetch(base_url + 'me/settings/delete-account', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
      }
  })
  .then(response => response.json())
  .then(data => {
      if (data.status === 'success') {
          alert(data.message);
          window.location.href = base_url + 'logout';
      } else {
          alert(data.message || "An error occurred while deleting the account.");
      }
  })
  .catch(error => {
      console.error("Error:", error);
      alert("An error occurred while deleting the account.");
  });
}

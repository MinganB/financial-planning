<script>
    const sharedAccessData = [{
            user_id: 1,
            name: "John Doe",
            role: "Editor"
        },
        {
            user_id: 2,
            name: "Jane Smith",
            role: "Viewer"
        },
        {
            user_id: 3,
            name: "Bob Johnson",
            role: "Admin"
        },
    ];
</script>

<link href="<?= base_url('css/settings.css?v=0.0.1') ?>" rel="stylesheet">

<div class="container settings-container mt-4 mb-5">
    <h3 class="mb-4">App Settings</h3>

    <!-- Account Security -->
    <section>
        <h4>Account Security</h4>
        <div class="mb-3">
            <label for="newPassword" class="form-label">Update Password</label>
            <input type="password" class="form-control" id="newPassword">
        </div>
        <div class="mb-3">
            <label for="confirmPassword" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="confirmPassword">
        </div>
        <button id="updatePasswordButton" class="btn btn-primary">Update Password</button>
    </section>

    <hr class="my-4">

    <!-- Privacy and Sharing -->
    <section>
        <h4>Privacy and Sharing</h4>
        <div class="mb-3">
            <label for="sharingSettings" class="form-label">Sharing</label>
            <select id="sharingSettings" class="form-select">
                <option value="view">Allow view access</option>
                <option value="edit">Allow edit access</option>
                <option value="none">Don't allow access</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="budgetVisibility" class="form-label">Budget visibility</label>
            <select id="budgetVisibility" class="form-select">
                <option value="everyone">Everyone </option>
                <option value="adviser">Me and my adviser</option>
                <option value="private">Just me</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="netWorthVisibility" class="form-label">Net worth visibility</label>
            <select id="netWorthVisibility" class="form-select">
                <option value="everyone">Everyone </option>
                <option value="adviser">Me and my adviser</option>
                <option value="private">Just me</option>
            </select>
        </div>
        <button id="updatePrivacyButton" class="btn btn-primary">Update Settings</button>
    </section>

    <hr class="my-4">

    <!-- Shared Access -->
    <section>
        <h4>Shared Access</h4>
        <ul id="sharedAccessList" class="list-group mb-3">
            <!-- List of shared users -->
        </ul>
        <button id="inviteSomeoneButton" class="btn btn-secondary btn-sm">+ Invite someone</button>
    </section>

    <hr class="my-4">

    <!-- Delete Account -->
    <section>
        <h4>Delete Account</h4>
        <p>Deleting your account will permanently erase all your personal data and this action cannot be undone.</p>
        <a href="#" id="deleteAccountLink" class="text-danger">Delete my account</a>
    </section>
</div>

<script src="<?= base_url('js/settings/logic.js?v=0.0.1') ?>"></script>
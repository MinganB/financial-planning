<?php

namespace App\Controllers;
use App\Models\SettingsModel;

class SettingsController extends BaseController
{
    protected $settingsModel;

    public function __construct()
    {
        $this->settingsModel = model(SettingsModel::class);
    }
    
    /**
     * Display settings page.
     */
    public function index()
    {
        $data['privacy'] = $this->settingsModel->getPrivacySettings(auth()->user()->id);

        $view = view('settings/main', $data);
        return $this->getPreparedView($view);
    }

    /**
     * Update user password.
     */
    public function updatePassword()
    {
        $request = $this->request->getJSON();
        $newPassword = $request->newPassword;

        if (empty($newPassword) || strlen($newPassword) < 8) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Password must be at least 8 characters long.'
            ]);
        }

        $users = auth()->getProvider();
        $user = auth()->user();
        $user->fill(['password' => $newPassword]);

        log_message('debug', 'Updated user password for user: '.$user->id);

        if ($users->save($user)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Password updated successfully.'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to update password.'
            ]);
        }
    }

    /**
     * Update user's privacy controls.
     */
    public function updatePrivacySettings() {
        $postData = json_decode($this->request->getPost('payload'), true);

        $data = [
            'sharing' => $postData['sharing'],
            'budget_visibility' => $postData['budget_visibility'],
            'net_worth_visibility' => $postData['net_worth_visibility'],
        ];

        $result = $this->settingsModel->updatePrivacySettings(auth()->user()->id, $data);
        if ($result) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Settings updated successfully!']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to update settings.']);
        }
    }

    /**
     * Delete user's account (soft delete).
     */
    public function deleteUserAccount()
    {
        $users = auth()->getProvider();
        
        if ($users->delete(auth()->user()->id, false)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Account deleted successfully.'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to delete account.'
            ]);
        }
    }
}

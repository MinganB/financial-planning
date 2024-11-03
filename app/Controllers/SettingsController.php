<?php

namespace App\Controllers;

class SettingsController extends BaseController
{
    public function index()
    {
        $view = view('settings/main');
        return $this->getPreparedView($view);
    }

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

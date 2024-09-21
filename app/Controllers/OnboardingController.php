<?php

namespace App\Controllers;

use App\Models\OnboardingModel;
use CodeIgniter\Shield\Models\UserModel;

class OnboardingController extends BaseController
{
    /**
     * Welcomes the user to the onboarding / data capture process.
     */
    public function index()
    {
        $view = view('onboarding/welcome');
        return $this->getPreparedView($view, false, false);
    }

    /**
     * Allows users to enter / update their data.
     */
    public function update()
    {
        $view = view('onboarding/datacapture');
        return $this->getPreparedView($view, false, false);
    }

    public function submit() {
        $user_id = auth()->user()->id;

        $postData = $this->request->getPost();
        $payload = json_decode($postData['payload']);

        $result = model(OnboardingModel::class)->update_data($user_id, $payload);

        $data = [
            'success' => $result,
        ];
        $this->response->setStatusCode(200);
        return $this->response->setJSON($data);
    }

    /**
     * User has completed the onboarding process. Shows them a confirmation screen.
     */
    public function complete()
    {
        $user = auth()->user();

        if ($user) {
            $userModel = new UserModel();
            $userModel->update($user->id, ['onboarding_completed' => true]);

            // Update user object in the session
            auth()->user()->onboarding_completed = true;
        }

        $view = view('onboarding/complete');
        return $this->getPreparedView($view, false, false);
    }
}

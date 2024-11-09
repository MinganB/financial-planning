<?php

namespace App\Controllers;

use App\Models\OnboardingModel;

class OnboardingController extends BaseController
{
    protected $onboardingModel;

    public function __construct()
    {
        $this->onboardingModel = model(OnboardingModel::class);
    }

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

        $result = $this->onboardingModel->updateData($user_id, $payload);

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

        if(!$user) {
            log_message('error', 'Onboarding completion error: User id not found');
            return redirect()->to('onboarding/update'); // TODO: Take th user to an error page instead
        }

        $db = \Config\Database::connect();
        $builder = $db->table('onboarding');
        
        $onboardingData = $builder->where('user_id', $user->id)->get()->getRow();

        if ($onboardingData) {
            // Update the timestamp
            $builder->where('user_id', $user->id)->update([
                'completed_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            // Mark the user as onboarded
            $builder->insert([
                'user_id' => $user->id,
                'completed_at' => date('Y-m-d H:i:s')
            ]);
        }

        $view = view('onboarding/complete');
        return $this->getPreparedView($view, false, false);
    }
}

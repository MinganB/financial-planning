<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class OnboardingFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $user = auth()->user();
        $session = session();

        if ($user) {
            if (!$session->has('onboarding_completed')) {
                // Check user onboarded status
                $db = \Config\Database::connect();
                $builder = $db->table('onboarding');
                $onboarding = $builder->where('user_id', $user->id)->get()->getRow();

                if (!$onboarding) {
                    return redirect()->to('/onboarding');
                }

                $session->set('onboarding_completed', true);
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}

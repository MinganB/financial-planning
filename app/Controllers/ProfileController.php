<?php

namespace App\Controllers;

class ProfileController extends BaseController
{
    public function index()
    {
        $view = view('profile/main');
        return $this->getPreparedView($view);
    }
}

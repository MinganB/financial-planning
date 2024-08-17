<?php

namespace App\Controllers;

class FrontendController extends BaseController
{
    public function index()
    {
        $view = view('frontend/home');
        return $this->getPreparedView($view);
    }
}

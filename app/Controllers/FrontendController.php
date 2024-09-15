<?php

namespace App\Controllers;

class FrontendController extends BaseController
{
    public function index()
    {
        $view = view('frontend/home');
        return $this->getPreparedFrontendView($view);
    }

    public function attributions()
    {
        $view = view('legal/attributions');
        return $this->getPreparedFrontendView($view);
    }

    public function about() {
        $view = view('about/main');
        return $this->getPreparedFrontendView($view);
    }
}

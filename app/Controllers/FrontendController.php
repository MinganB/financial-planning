<?php

namespace App\Controllers;

class FrontendController extends BaseController
{
    /**
     * Home page.
     */
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

    public function privacyPolicy() {
        $view = view('privacy-policy/main');
        return $this->getPreparedFrontendView($view);
    }

    public function tos() {
        $view = view('tos/main');
        return $this->getPreparedFrontendView($view);
    }

    public function popia() {
        $view = view('popia/main');
        return $this->getPreparedFrontendView($view);
    }

    public function contact() {
        $view = view('contact/main');
        return $this->getPreparedFrontendView($view);
    }
}

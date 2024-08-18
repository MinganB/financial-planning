<?php

namespace App\Controllers;

class NetworthController extends BaseController
{
    public function index()
    {
        $view = view('networth/main');
        return $this->getPreparedView($view);
    }
}

<?php

namespace App\Controllers;

class Frontend extends BaseController
{
    public function index(): string
    {
        return view('templates/header')
            . view('frontend/home')
            . view('templates/footer');
    }
}

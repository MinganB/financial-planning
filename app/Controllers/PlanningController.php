<?php

namespace App\Controllers;

class PlanningController extends BaseController
{
    public function index()
    {
        $view = view('planning/main');
        return $this->getPreparedView($view);
    }
}

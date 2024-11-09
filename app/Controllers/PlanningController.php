<?php

namespace App\Controllers;
use App\Models\PlanningModel;

class PlanningController extends BaseController
{
    protected $planningModel;

    public function __construct()
    {
        $this->planningModel = model(PlanningModel::class);
    }

    /**
     * Displays the financial planning view.
     */
    public function index()
    {
        $view = view('planning/main');
        return $this->getPreparedView($view);
    }
}

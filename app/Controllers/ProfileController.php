<?php

namespace App\Controllers;
use App\Models\ProfileModel;

class ProfileController extends BaseController
{
    protected $profileModel;

    public function __construct()
    {
        $this->profileModel = model(ProfileModel::class);
    }

    public function index()
    {
        $view = view('profile/main');
        return $this->getPreparedView($view);
    }
}

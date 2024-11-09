<?php

namespace App\Controllers;
use App\Models\APIModel;

class APIController extends BaseController
{
    protected $apiModel;

    public function __construct()
    {
        $this->apiModel = model(APIModel::class);
    }
}

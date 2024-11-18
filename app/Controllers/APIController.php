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

    /**
     * This controller can be used for future API routes / development.
     * Token-based authentication can be implemented here.
     */
}

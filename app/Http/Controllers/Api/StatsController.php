<?php

namespace App\Http\Controllers\Api;

use App\Child;
use App\Household;
use App\User;
use App\Sponsorship;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;

class StatsController extends BaseController
{
    //
    public function index(){

        $data = [
            'users' => User::count(),
            'children' => Child::count(),
            'sponsorship' => Sponsorship::count(),
            'households' => Household::count(),
        ];

        return $this->sendResponse($data, 'Data fetched successfully');
    }
}

<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{

    public function index()
    {
        return view('tenant.dashboard',['mode' => 'tenant']);
    }


}

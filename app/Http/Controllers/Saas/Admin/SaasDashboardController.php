<?php

namespace App\Http\Controllers\Saas\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\UniversalCrud;
use App\Models\User;
class SaasDashboardController extends Controller
{
    public function index()
    {
        return view('tenant.dashboard', ['mode' => 'saas']);
    }


}





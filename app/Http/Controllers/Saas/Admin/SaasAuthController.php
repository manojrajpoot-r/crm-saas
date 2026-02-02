<?php

namespace App\Http\Controllers\Saas\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class SaasAuthController extends Controller
{


    public function showLogin()
    {
        return view('saas.auth.saas_login');
    }

    public function login(Request $request)
    {

        if (Auth::guard('web')->attempt(
            $request->only('email','password')
        )) {
            return response()->json([
            'message' => 'SAAS admin login success',
           // 'redirect' => route('saas.2fa.index')
           'redirect' => route('saas.dashboard.index')
        ]);

        }

        return response()->json([
            'errors' => ['email' => ['Invalid SAAS credentials']]
        ], 422);
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('saas.web.login');
    }




}
<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class HomeController extends Controller
{
    public function index()
    {
        return view('front.index');
    }

    // public function loginPage()
    // {
    //     return view('front.auth.login');
    // }

    // public function login(Request $request)
    // {
    //     if (Auth::guard('web')->attempt(
    //         $request->only('email','password')
    //     )) {
    //         return response()->json([
    //             'message' => 'SAAS admin login success',
    //             'redirect' => route('face.register')
    //         ]);
    //     }

    //     return response()->json([
    //         'errors' => ['email' => ['Invalid SAAS credentials']]
    //     ], 422);
    // }





    // public function logout()
    // {
    //     Auth::guard('web')->logout();
    //     return redirect()->route('saas.login');
    // }
}
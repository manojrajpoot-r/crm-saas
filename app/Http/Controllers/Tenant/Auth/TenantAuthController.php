<?php

namespace App\Http\Controllers\Tenant\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Tenant\TenantUser;

class TenantAuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('tenant.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:tenant.users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        DB::connection('tenant')->table('users')->insert([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'created_at' => now(),
        ]);


        Auth::guard('tenant');


       return response()->json([
            'message' => 'Login success',
            'redirect' => route('tenant.dashboard')
        ]);
    }

    public function showLoginForm()
    {

         return view('tenant.auth.login');
    }

public function login(Request $request)
{


    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

        $user =TenantUser::where('email', $request->email)->first();

        if ($user && $user->status == 0) {
            return response()->json([
                'errors' => ['email' => ['Your account is disabled. Please contact admin']]
            ], 422);
        }

        if (Auth::guard('tenant')->attempt([
            'email'    => $request->email,
            'password' => $request->password,
            'status'   => 1
        ])) {
            return response()->json([
                'message'  => 'Login successfully!!',
                'redirect' => route('tenant.dashboard', ['tenant' => currentTenant()])
            ]);
        }

        return response()->json([
            'errors' => ['email' => ['Invalid tenant credentials']]
        ], 422);
}


    public function logout()
    {
        Auth::guard('tenant')->logout();
        return redirect()->route('tenant.login', ['tenant' =>currentTenant()]);
    }



}

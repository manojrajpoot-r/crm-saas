<?php

namespace App\Http\Controllers\API\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\TenantUser;
use Illuminate\Support\Facades\Hash;
use App\Services\AuthService;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
class AuthController extends Controller
{
    protected $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function login(LoginRequest $request)
    {

        $data = $this->service->login($request->validated());

        return new UserResource($data);
    }






    public function logout(Request $request)
    {
        $this->service->logout($request->user());

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}

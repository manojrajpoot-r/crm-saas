<?php
namespace App\Services;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
class AuthService
{
    protected $repo;

    public function __construct(UserRepository $repo)
    {
        $this->repo = $repo;
    }

    public function login($data)
    {

        $user = $this->repo->findByEmail($data['email']);

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw new \Exception("Invalid credentials");
        }

        $token = $user->createToken('app-token')->plainTextToken;

        $user->token = $token;

        return $user;
    }

    public function logout($user)
    {
        $user->currentAccessToken()->delete();
    }
}

<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class TenantAuthMiddleware
{
    public function handle($request, Closure $next, ...$permissions)
    {

        // $user= User::where('id',Auth::id())->first();
        //     if ($user->role === 'admin') {
        //         $user->update([
        //         'two_factor_enabled' => true,
        //         'two_factor_type' => 'sms'
        //     ]);
        // }

        // SUPER ADMIN (SAAS)
    //     if (Auth::guard('web')->check()) {
    //         $user = Auth::guard('web')->user();
    //             if (!$user) {
    //                 return redirect()->route('saas.login');
    //             }

    //         return $next($request);
    //     }




    //     $user = Auth::guard('tenant')->user();

    //     if (!$user) {
    //         return redirect()->route('tenant.login');
    //     }

    //     if ($user->master == 5) {
    //         return $next($request);
    //     }

    //     if (!empty($permissions)) {
    //         $normalize = fn($str) => strtolower(str_replace(' ', '', trim($str)));

    //         $rolePermissions = array_map(
    //             $normalize,
    //             $user->role->permissions->pluck('group')->toArray()
    //         );

    //         foreach ($permissions as $permission) {
    //             if (!in_array($normalize($permission), $rolePermissions)) {
    //                 abort(403);
    //             }
    //         }
    //     }

    //     return $next($request);
    }


}
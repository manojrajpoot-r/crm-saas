<?php

namespace App\Http\Controllers\Saas\Admin\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\OtpService;
use Illuminate\Support\Facades\Auth;
use App\Models\RecoveryCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class TwoFactorController extends Controller
{
    use OtpService;


    public function index()
    {
        return view('tenant.auth.2fa');
    }

    public function send()
    {
        $user =Auth::guard('web')->user();


        match ($user->two_factor_type) {
            'sms' => $this->sendSmsOtp($user),
            'whatsapp' => $this->sendWhatsappOtp($user),
            'email' => $this->sendEmailOtp($user),
            default => abort(403)
        };

        return response()->json(['sent' => true]);
    }

    public function verify(Request $request)
    {
        $user =Auth::guard('web')->user();


        if (!$this->verifyOtp($user, $request->otp)) {
            return response()->json(['error' => 'Invalid OTP'], 422);
        }

        return response()->json(['success' => true]);
    }




    public function generateRecoveryCodes()
    {
        $user =Auth::guard('web')->user();

        RecoveryCode::where('user_id',$user->id)->delete();

        foreach (range(1,5) as $i) {
            RecoveryCode::create([
                'user_id' => $user->id,
                'code' => Hash::make(Str::upper(Str::random(10)))
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function verifyRecoveryCode(Request $request)
    {
         $user =Auth::guard('web')->user();

        $code = RecoveryCode::where('user_id',$user->id)
            ->where('used', false)
            ->get()
            ->first(fn ($c) => Hash::check($request->code, $c->code));

        if (!$code) {
            return response()->json(['error'=>'Invalid recovery code'],422);
        }

        $code->update(['used' => true]);

        session(['2fa_verified' => true]);

        return response()->json(['success'=>true]);
    }

}
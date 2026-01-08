<?php

namespace App\Traits;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

trait OtpService
{
    protected function generateOtp()
    {
        return rand(100000, 999999);
    }

    protected function storeOtp($user, $otp)
    {
        $user->update([
            'otp_hash' => Hash::make($otp),
            'otp_expires_at' => now()->addMinutes(5),
            'otp_attempts' => 0
        ]);
    }

    protected function rateLimit($key)
    {
        if (RateLimiter::tooManyAttempts($key, 3)) {
            abort(429, 'Too many OTP requests');
        }
        RateLimiter::hit($key, 60);
    }

    protected function sendSmsOtp($user)
    {
        $this->rateLimit('sms-'.$user->id);

        $otp = $this->generateOtp();
        $this->storeOtp($user, $otp);

        $twilio = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );

        try {
            $twilio->messages->create($user->phone, [
                'from' => config('services.twilio.from'),
                'body' => "Your OTP is {$otp}"
            ]);
        } catch (\Exception $e) {
            $this->sendEmailOtp($user); // 🔄 FALLBACK
        }
    }

    protected function sendWhatsappOtp($user)
    {
        $otp = $this->generateOtp();
        $this->storeOtp($user, $otp);

        $twilio = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );

        $twilio->messages->create(
            "whatsapp:{$user->phone}",
            [
                'from' => 'whatsapp:+14155238886',
                'body' => "Your OTP is {$otp}"
            ]
        );
    }

    protected function sendEmailOtp($user)
    {
        $otp = $this->generateOtp();
        $this->storeOtp($user, $otp);

        Mail::raw("Your OTP is {$otp}", function ($m) use ($user) {
            $m->to($user->email)->subject('OTP Verification');
        });
    }

    protected function verifyOtp($user, $otp)
    {
        if (now()->gt($user->otp_expires_at)) return false;

        if (!Hash::check($otp, $user->otp_hash)) {
            $user->increment('otp_attempts');
            return false;
        }

        session(['2fa_verified' => true]);
        $user->update(['otp_hash' => null]);

        return true;
    }
}
<?php

namespace App\Services;

use App\Models\Otp;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OtpService
{
    public function generateOTP(): Otp
    {
        $user = Auth::user();
        $otpCode = rand(100000, 999999);

        // Delete any existing OTP for the user
        Otp::where('user_id', $user->id)->delete();

        // Create a new Otp
        $otp = Otp::create([
            'user_id' => $user->id,
            'code' => $otpCode,
            'expires_at' => now()->addMinutes(15),
        ]);

        // Send OTP Email Notification
        Mail::to($user->email)->send(new OtpMail($otpCode));

        return $otp;
    }

    public function verifyOTP(string $code): bool
    {
        $otp = Otp::where('user_id', Auth::id())
            ->where('code', $code)
            ->where('expires_at', '>', now())
            ->first();

        $isValid = false;
        if ($otp) {
            $otp->delete(); // Ensure OTP is used only once
            $isValid = true;
        }

        return $isValid;
    }
}

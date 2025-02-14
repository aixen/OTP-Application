<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\OtpService;

class OtpInput extends Component
{
    public $otp = ['', '', '', '', '', ''];
    public $errorMessage;
    public $loading = false;
    public $userId;

    public function mount($userId)
    {
        $this->userId = $userId;
    }

    public function updated($propertyName)
    {
        if (str_starts_with($propertyName, 'otp.')) {
            $index = explode('.', $propertyName)[1];

            // Ensure only numeric input
            $this->otp[$index] = preg_replace('/\D/', '', $this->otp[$index]);

            // Auto-submit OTP when last digit is entered
            if (implode('', $this->otp) && count(array_filter($this->otp)) === 6) {
                $this->submitOtp();
            }
        }
    }

    public function submitOTP()
    {
        $this->errorMessage = null;
        $this->loading = true;
        $otpCode = implode('', $this->otp);

        if (strlen($otpCode) !== 6 || !ctype_digit($otpCode)) {
            $this->errorMessage = 'Please enter a valid 6-digit OTP.';
            $this->loading = false;

            return;
        }

        $otpService = new OtpService();
        if ($otpService->verifyOTP($otpCode)) {
            session()->flash('message', 'OTP Verified Successfully!');

            return redirect()->route('dashboard');
        }

        // Explicitly use session errors for failed OTP validation
        session()->flash('errors', ['otp' => 'Invalid OTP. Please try again.']);

        $this->errorMessage = 'Invalid OTP. Please try again.';
        $this->otp = ['', '', '', '', '', ''];
        $this->loading = false;
    }

    public function resendOTP()
    {
        $otpService = new OtpService();
        $otp = $otpService->generateOTP();

        $this->dispatch('otpResent', $otp->code);
    }

    public function render()
    {
        return view('livewire.otp-input');
    }
}

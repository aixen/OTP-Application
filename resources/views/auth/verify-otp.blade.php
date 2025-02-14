<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
    @livewireScripts
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">
    <div class="bg-white shadow-lg rounded-lg p-6 max-w-md w-full">
        <h1 class="text-2xl font-semibold mb-4 text-center">OTP Verification</h1>
        <p class="text-gray-600 mb-4 text-center">Enter the 6-digit OTP sent to your email.</p>

        <!-- Livewire OTP Component -->
        <livewire:otp-input :userId="auth()->user()->id" />

        <div class="text-center mt-4">
            <p class="text-sm text-gray-500">
                Didn't receive an OTP?
                <button wire:click="resendOTP" class="text-blue-500 hover:underline">Resend OTP</button>
            </p>
        </div>
    </div>
</body>
</html>

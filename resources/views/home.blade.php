<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">

    <div class="bg-white shadow-lg rounded-lg p-6 max-w-md w-full text-center">
        <h1 class="text-2xl font-semibold mb-4">Verify Your OTP</h1>
        <p class="text-gray-600 mb-4">Enter the 6-digit OTP sent to your registered account.</p>

        <!-- Livewire OTP Component -->
        <livewire:otp-input :userId="auth()->id()" />

        <p class="text-sm text-gray-500 mt-4">Didn't receive an OTP? <a href="#" class="text-blue-500 hover:underline">Resend</a></p>
    </div>

    @livewireScripts
</body>
</html>

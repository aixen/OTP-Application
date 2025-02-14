<div class="flex flex-col items-center">
    <h2 class="text-lg font-semibold mb-2">Enter OTP</h2>

    <!-- OTP Input Boxes -->
    <div class="flex space-x-2">
        @foreach ($otp as $index => $digit)
            <input
                type="text"
                wire:model.lazy="otp.{{ $index }}"
                x-data
                x-ref="otp{{ $index }}"
                x-on:input="
                    if ($event.target.value.length === 1) {
                        document.querySelector(`[x-ref='otp{{ $index + 1 }}']`)?.focus();
                    }
                "
                x-on:keydown.backspace="
                    if (!$event.target.value) {
                        document.querySelector(`[x-ref='otp{{ $index - 1 }}']`)?.focus();
                    }
                "
                maxlength="1"
                class="w-12 h-12 text-center border rounded text-lg focus:ring focus:ring-blue-400"
                pattern="[0-9]*"
                inputmode="numeric"
            />
        @endforeach
    </div>

    <!-- Error Message -->
    @if ($errorMessage)
        <p class="text-red-500 mt-2">{{ $errorMessage }}</p>
    @endif
    <!-- Loading State -->
    <div wire:loading>
        <p class="text-blue-500 mt-2">Verifying OTP...</p>
    </div>

    <script>
        document.addEventListener('livewire:load', () => {
            Livewire.on('otpVerified', () => {
                alert("OTP Verified Successfully!");
            });
        });
    </script>
</div>

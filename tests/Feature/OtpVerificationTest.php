<?php

namespace Tests\Feature;

use App\Livewire\OtpInput;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;
use Tests\TestCase;

class OtpVerificationTest extends TestCase
{
    protected $user;
    protected $otpCode;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $this->otpCode = Otp::factory()->create([
            'user_id' => $this->user->id,
            'code' => '123456',
            'expires_at' => now()->addMinutes(15),
        ]);
    }

    public function testValidAuthentication()
    {
        $response = $this->post('/login', [
            'email' => $this->user->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect('/otp-verify');
        $this->assertAuthenticatedAs($this->user);
    }

    public function testInvalidAuthentication()
    {
        $response = $this->post('/login', [
            'email' => $this->user->email,
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function testValidAuthenticationWithOtp()
    {
        Auth::login($this->user);

        $this->assertDatabaseHas('otps', [
            'user_id' => $this->user->id,
            'code' => $this->otpCode->code
        ]);

        Livewire::test(OtpInput::class, ['userId' => $this->user->id])
            ->set('otp', str_split($this->otpCode->code))
            ->call('submitOTP')
            ->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($this->user);
        $this->assertDatabaseMissing('otps', ['user_id' => $this->user->id]);
    }
    public function testValidAuthenticationInvalidOtp()
    {
        Auth::login($this->user);

        $this->assertDatabaseHas('otps', [
            'user_id' => $this->user->id,
            'code' => $this->otpCode->code
        ]);

        $incorrectOtp = '999999';
        while ($incorrectOtp === $this->otpCode->code) {
            $incorrectOtp = strval(rand(100000, 999999)); // Regenerate if it accidentally matches
        }

        Livewire::test(OtpInput::class, ['userId' => $this->user->id])
            ->set('otp', str_split($incorrectOtp))
            ->call('submitOTP')
            ->assertSee('Invalid OTP. Please try again.');

        // Ensure the user is still authenticated
        $this->assertAuthenticatedAs($this->user);
        $this->assertDatabaseHas('otps', [
            'user_id' => $this->user->id,
            'code' => $this->otpCode->code
        ]);
    }
}

<?php

namespace Database\Factories;

use App\Models\Otp;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Otp>
 */
class OtpFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Otp::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'code' => $this->faker->randomNumber(6, true),
            'expires_at' => Carbon::now()->addMinutes(15),
        ];
    }

    // State to generate an expired OTP
    public function expired()
    {
        return $this->state([
            'expires_at' => Carbon::now()->subMinutes(1),
        ]);
    }
}

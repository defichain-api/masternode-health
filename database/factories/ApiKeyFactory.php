<?php

namespace Database\Factories;

use App\Models\ApiKey;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApiKeyFactory extends Factory
{
    protected $model = ApiKey::class;

    public function definition(): array
    {
        return [
            'throttle'          => $this->faker->randomNumber(2),
            'is_active'         => true,
            'throttle_disabled' => false,
            'created_at'        => now(),
            'updated_at'        => now(),
        ];
    }

    public function throttleDisabled()
    {
        return $this->state(function (array $attributes) {
            return [
                'throttle_disabled' => true,
            ];
        });
    }

    public function inactive()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_active' => false,
            ];
        });
    }
}

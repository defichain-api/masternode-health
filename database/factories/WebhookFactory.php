<?php

namespace Database\Factories;

use App\Models\ApiKey;
use App\Models\Webhook;
use Illuminate\Database\Eloquent\Factories\Factory;

class WebhookFactory extends Factory
{
    protected $model = Webhook::class;

    public function definition(): array
    {
        return [
            'max_tries'          => $this->faker->randomNumber(1, 10),
            'timeout_in_seconds' => $this->faker->randomNumber(1, 5),
            'url'                => $this->faker->url,
            'reference'          => bcrypt($this->faker->word),
            'api_key_id'         => function () {
                return ApiKey::factory()->create()->key();
            },
        ];
    }

    public function apiKey(string $apiKey)
    {
        return $this->state(function (array $attributes) use ($apiKey) {
            return [
                'api_key_id' => $apiKey,
            ];
        });
    }
}

<?php

namespace Database\Factories;

use App\Enum\ServerStatTypes;
use App\Models\ApiKey;
use App\Models\ServerStat;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class ServerStatFactory extends Factory
{
    protected $model = ServerStat::class;

    public function definition(): array
    {
        $allServerStatTypes = array_merge(ServerStatTypes::SERVER_STATS, ServerStatTypes::NODE_INFO);

        return [
            'api_key_id' => ApiKey::factory()->create(),
            'type'       => Arr::random($allServerStatTypes, 1)[0],
            'value'      => $this->faker->word,
            'created_at' => now(),
            'updated_at' => now(),
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

    public function serverStat(?string $type = null)
    {
        if (is_null($type)) {
            $type = Arr::random(ServerStatTypes::SERVER_STATS, 1)[0];
        }
        return $this->state(function (array $attributes) use ($type){
            return [
                'type' => $type,
            ];
        });
    }

    public function nodeInfo()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => Arr::random(ServerStatTypes::NODE_INFO, 1)[0],
            ];
        });
    }
}

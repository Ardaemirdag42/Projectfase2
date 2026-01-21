<?php

namespace Database\Factories;

use App\Models\Game;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameFactory extends Factory
{
    protected $model = Game::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'console' => $this->faker->randomElement(['PlayStation', 'Xbox', 'Switch', 'DS', '3DS', 'NES', 'GBA', 'Wii']),
            'description' => $this->faker->paragraph(),
            'file_path' => $this->faker->imageUrl(), // of laat leeg als je echte files gebruikt
        ];
    }
}

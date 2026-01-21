<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\User;
use App\Models\Game;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),   // maakt automatisch een user aan als er nog geen is
            'game_id' => Game::factory(),   // maakt automatisch een game aan als er nog geen is
            'rating' => $this->faker->numberBetween(1, 5),
            'content' => $this->faker->paragraph(),
        ];
    }
}

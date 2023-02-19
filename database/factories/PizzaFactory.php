<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pizza>
 */
class PizzaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'titre' => fake()->name(),
            'description' => fake()->paragraph(),
            'imageurl' =>"http://pizza.test/img.jpg",
            'user_id' => User::factory()->create(),
            'prix'=>100,
            'ingredients'=>'tomate sel ',
            'visiblity' =>"oui"
        ];
    }
}

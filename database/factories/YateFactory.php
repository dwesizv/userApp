<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Yate>
 */
class YateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $users = User::all()->count();
        return [
            'iduser'        => $this->faker->numberBetween(1, $users),
            'idastillero'   => $this->faker->numberBetween(1, 10),
            'idtipo'        => $this->faker->numberBetween(1, 4),
            'nombre'        => $this->faker->name(),
            'descripcion'   => $this->faker->text(),
            'precio'        => $this->faker->numberBetween(1000, 999999)
        ];
    }
}

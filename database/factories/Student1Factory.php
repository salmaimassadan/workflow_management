<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Student1;


class Student1Factory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student1::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'username' => $this->faker->unique()->userName,
            'firstname' => $this->faker->firstName,
            'name' => $this->faker->lastName,
            'age' => $this->faker->numberBetween(18, 25),
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'), // You can hash a default password here
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}


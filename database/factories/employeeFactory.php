<?php

namespace Database\Factories;

use App\Models\employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class employeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = employee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'emp_first_name' => $this->faker->word,
        'emp_surname' => $this->faker->word,
        'date_of_birth' => $this->faker->word,
        'gender' => $this->faker->word,
        'contact_number' => $this->faker->word,
        'emergency_contact' => $this->faker->word,
        'email' => $this->faker->word,
        'street' => $this->faker->word,
        'city' => $this->faker->word,
        'county' => $this->faker->word,
        'pps_number' => $this->faker->word,
        'role' => $this->faker->word,
        'iban' => $this->faker->word,
        'bic' => $this->faker->word,
        'username' => $this->faker->word,
        'password' => $this->faker->word,
        'practice_id' => $this->faker->randomDigitNotNull
        ];
    }
}

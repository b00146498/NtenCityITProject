<?php

namespace Database\Factories;

use App\Models\client;
use Illuminate\Database\Eloquent\Factories\Factory;

class clientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = client::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->word,
        'surname' => $this->faker->word,
        'date_of_birth' => $this->faker->word,
        'gender' => $this->faker->word,
        'email' => $this->faker->word,
        'contact_number' => $this->faker->word,
        'street' => $this->faker->word,
        'city' => $this->faker->word,
        'county' => $this->faker->word,
        'username' => $this->faker->word,
        'password' => $this->faker->word,
        'account_status' => $this->faker->word,
        'practice_id' => $this->faker->randomDigitNotNull
        ];
    }
}

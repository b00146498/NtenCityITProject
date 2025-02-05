<?php

namespace Database\Factories;

use App\Models\practice;
use Illuminate\Database\Eloquent\Factories\Factory;

class practiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = practice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_name' => $this->faker->word,
        'company_type' => $this->faker->word,
        'street' => $this->faker->word,
        'city' => $this->faker->word,
        'county' => $this->faker->word,
        'iban' => $this->faker->word,
        'bic' => $this->faker->word
        ];
    }
}

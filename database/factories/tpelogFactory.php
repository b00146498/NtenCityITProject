<?php

namespace Database\Factories;

use App\Models\tpelog;
use Illuminate\Database\Eloquent\Factories\Factory;

class tpelogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = tpelog::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'plan_id' => $this->faker->randomDigitNotNull,
        'exercise_id' => $this->faker->randomDigitNotNull,
        'num_sets' => $this->faker->randomDigitNotNull,
        'num_reps' => $this->faker->randomDigitNotNull,
        'minutes' => $this->faker->randomDigitNotNull,
        'intensity' => $this->faker->word,
        'incline' => $this->faker->word,
        'times_per_week' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}

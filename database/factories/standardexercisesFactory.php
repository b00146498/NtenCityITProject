<?php

namespace Database\Factories;

use App\Models\standardexercises;
use Illuminate\Database\Eloquent\Factories\Factory;

class standardexercisesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = standardexercises::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'exercise_name' => $this->faker->word,
        'exercise_video_link' => $this->faker->word,
        'target_body_area' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}

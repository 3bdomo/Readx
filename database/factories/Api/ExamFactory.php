<?php

namespace Database\Factories\Api;

use Illuminate\Database\Eloquent\Factories\Factory;


class ExamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $directory = 'public/storage/images/Exams';
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        $image = $this->faker->image($directory, 300, 300, null, true);
        return [
            'subject_name' => $this->faker->word,
            'image_path' =>$image,
            'year' => $this->faker->year,
            'type' => 'final',
            'professor_name' => $this->faker->name,
            'grade' => $this->faker->numberBetween(1,4),
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'name' => fake()->name,
            'description' => fake()->msedge,
            'year' => fake()->year,
            'Professor_name' => fake()->name,
            'Professor_email' => fake()->email,
            'Assistant_teacher_name' => fake()->name,
            'Assistant_teacher_email' => fake()->email,
            'classification' => fake()->text,
            'faculty' =>'FCI',
            'status'=>'accepted',
        ];
    }
}

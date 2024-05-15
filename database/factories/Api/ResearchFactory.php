<?php

namespace Database\Factories\Api;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Api\Research>
 */
class ResearchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       // protected $table_name='researches';
        return [
            'name' => $this->faker->name,
            'researcher_name' => $this->faker->name,
            'researcher_email' => $this->faker->email,
            'publishing_year' => $this->faker->year,
            'field' => $this->faker->word,
            'description' => $this->faker->text,
            'status' => $this->faker->word,
            'the_supervisory_authority' => $this->faker->word,
            'faculty' => $this->faker->word,
            'file' => $this->faker->word,
        ];
    }
}

<?php

namespace Database\Factories\Api;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $image = $this->faker->image('public/storage/images/BooksCovers', 300, 300, null, true);
        $imageURL = str_replace('public/storage/images/BooksCovers/', '', $image);
        return [
            'name' => $this->faker->domainName,
            'author_name' => $this->faker->name,
            'publishing_year' => $this->faker->year,
            'edition' => $this->faker->randomDigit,
            'category' => $this->faker->word,
            'description' => $this->faker->text,
            'ISBN' => $this->faker->isbn13,
            'rating' => 4.5,
            'status' => $this->faker->randomElement(['available', 'unavailable']),
            'faculty' => $this->faker->word,
            'pages_number' => $this->faker->randomDigit,
            'image' => $imageURL,
        ];
    }
}

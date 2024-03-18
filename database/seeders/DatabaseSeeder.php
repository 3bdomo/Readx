<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use HasFactory;

    public function run(): void
    {
        \App\Models\Api\Project::factory(50)->create();
        \App\Models\Api\Book::factory(20)->create();
        \App\Models\Api\Research::factory(20)->create();

         \App\Models\Admin\Admin::factory()->create([
             'username' => 'abdo',
             'password' => '123',
         ]);
        // \App\Models\Api\User::factory(10)->create();

        // \App\Models\Api\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}

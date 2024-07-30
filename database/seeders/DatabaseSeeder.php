<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Setting;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use HasFactory;

    public function run(): void
    {
      //  \App\Models\Api\Project::factory(50)->create();
    //  \App\Models\Api\Book::factory(20)->create();
      //  \App\Models\Api\Research::factory(20)->create();
     //   \App\Models\Api\Exam::factory(20)->create();

        Setting::create([
            'key' => 'registration_status',
            'value' => 'open',
        ]);

         \App\Models\Admin\Admin::create([
             'username' => 'fciadmin',
             'password' => Hash::make('admin@fciminia'),
         ]);
        // \App\Models\Api\User::factory(10)->create();

        // \App\Models\Api\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}

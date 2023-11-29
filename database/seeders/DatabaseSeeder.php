<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'dev01',
            'email' => 'dev01@gmail.com',
            'github' => 'https://github.com/Joenathan-15',
            'password' => bcrypt("password"),
        ]);
    }
}

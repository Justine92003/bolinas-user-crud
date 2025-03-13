<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $names = ["J", "James", "Jameson"];
        $n = 0;
        $password = '12345678';

        foreach ($names as $name) {
            User::factory()->create([
                "name" => $name,
                "email" => $n . "@gmail.com",
                "password" => bcrypt($password),
            ]);
            $n++;
        }
    }
}
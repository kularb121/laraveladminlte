<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    // Seed the application's database.
    
    public function run(): void
    {
        $user = User::where('email', 'thummasin@gmail.com')->first();
        $password = 'modx1234567';
        if ($user) {
            // Update the existing user's password

            $user->update([
                'password' => bcrypt($password),
            ]);
        } else {
            // Create a new user
            User::factory()->create([
                'name' => 'Thummasin Piyarattanatrai',
                'email' => 'thummasin@gmail.com',
                'password' => bcrypt($password),
            ]);
        }
    }
}
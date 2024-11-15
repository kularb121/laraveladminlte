<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role; // Import the Role model
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'thummasin@gmail.com')->first();
        $password = 'modx1234567';
        $roleId = Role::where('name', 'Administrator')->value('id'); // Fetch the role ID

        if ($user) {
            $user->update([
                'password' => bcrypt($password),
                'role_id' => $roleId, // Assign the role ID
            ]);
        } else {
            User::factory()->create([
                'name' => 'Thummasin Piyarattanatrai',
                'email' => 'thummasin@gmail.com',
                'password' => bcrypt($password),
                'role_id' => $roleId, // Assign the role ID
            ]);
        }
    }
}
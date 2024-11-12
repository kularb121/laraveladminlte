<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $roles = [
            'Administrator',
            'Super Admin',
            'Manager',
            'Editor',
            'Viewer',
            'User',
            'Guest',
            'Approver',
        ];

        foreach ($roles as $role) {
            if (!Role::where('name', $role)->exists()) {
                Role::create([
                    'name' => $role,
                    'slug' => strtolower(str_replace(' ', '-', $role)),
                    'description' => $role . ' role',
                    'permissions' => json_encode([]), // Add permissions as needed
                    'level' => 1, // Adjust the level as needed
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $roles = [
            'Administrator',
            'Super Admin',
            'Manager',
            'Editor',
            'Viewer',
            'User',
            'Guest',
            'Approver',
        ];

        foreach ($roles as $role) {
            Role::where('name', $role)->delete();
        }
    }
};
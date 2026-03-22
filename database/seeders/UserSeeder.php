<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('role', 'admin')->first();
        $ownerRole = Role::where('role', 'owner')->first();
        $supportRole = Role::where('role', 'support')->first();


        // Create one user
        User::factory()->create([
            'fullname' => "user user",
            'email' => 'user@astanait.edu.kz',
            'password' => 'User123.',
        ]);

        // Create one admin
        $admin = User::factory()->create([
            'fullname' => "admin admin",
            'email' => 'admin@astanait.edu.kz',
            'password' => 'Admin123.',
        ]);

        $owner = User::factory()->create([
            'fullname' => "owner",
            'email' => 'owner@astanait.edu.kz',
            'password' => 'Owner123.',
        ]);

        $support = User::factory()->create([
            'fullname' => "suppot",
            'email' => 'suppot@astanait.edu.kz',
            'password' => 'Suppot123.',
        ]);

        $admin->roles()->attach($adminRole->id);
        $owner->roles()->attach($ownerRole->id);
        
        $support->roles()->attach($supportRole->id); 
    }
}

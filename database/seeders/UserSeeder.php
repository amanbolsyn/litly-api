<?php

namespace Database\Seeders;

use App\Models\Organization;
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
            'email' => 'user@example.com',
            'password' => 'User123.',
        ]);

        // Create one admin
        $admin = User::factory()->create([
            'fullname' => "admin admin",
            'email' => 'admin@example.com',
            'password' => 'Admin123.',
        ]);

        $owner = User::factory()->create([
            'fullname' => "owner",
            'email' => 'owner@aexample.com',
            'password' => 'Owner123.',
        ]);

        $support = User::factory()->create([
            'fullname' => "suppot",
            'email' => 'suppot@example.com',
            'password' => 'Suppot123.',
        ]);

        $admin->roles()->attach($adminRole->id);
        $orgz = Organization::inRandomOrder()->first();
        $admin->organization()->associate($orgz)->save();

        $owner->roles()->attach($ownerRole->id);
        $owner->organization()->associate($orgz)->save();

        $support->roles()->attach($supportRole->id);
    }
}

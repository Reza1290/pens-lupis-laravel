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
        \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@gmail.com',
            'password' => 'password',
            'roles' => 'admin'
        ]);
        \App\Models\User::factory()->create([
            'name' => 'g',
            'email' => 'a@gmail.com',
            'password' => 'password',
            'roles' => 'mahasiswa'
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'b@gmail.com',
            'password' => 'password',
            'roles' => 'dosen'
        ]);
    }
}
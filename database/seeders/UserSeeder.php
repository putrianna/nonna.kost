<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate([
            'username' => 'developer',
        ], [
            'public_id' => Str::uuid(),
            'name' => 'developer',
            'password' => bcrypt('password'),
        ]);
    }
}

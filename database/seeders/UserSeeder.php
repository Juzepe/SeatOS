<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate([
            'email' => 'john@doe.com',
        ], [
            'name' => 'John',
            'surname' => 'Doe',
            'password' => 'password',
        ]);
    }
}

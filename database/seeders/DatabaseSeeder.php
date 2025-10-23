<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Pacient;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@sss.ss',
            'password' => '11111111',
            'role' => 'admin',
        ]);

        /*User::factory()->create([
            'name' => 'Pac',
            'email' => 'pac@sss.ss',
            'password' => '11111111',
            'role' => 'patient',
        ]);

        User::factory()->create([
            'name' => 'Doc',
            'email' => 'doc@sss.ss',
            'password' => '11111111',
            'role' => 'doctor',
        ]);*/
        /*Doctor::factory()->create([
            'user_id' => 3,
        ]);
        Pacient::factory()->create([
            'user_id' => 2,
        ]);*/

    }
}

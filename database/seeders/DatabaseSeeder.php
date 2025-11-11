<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Pacient;
use App\Models\Service;
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

        Service::factory()->create([
            'name' => 'Якість шкіри',
        ]);
        Service::factory()->create([
            'name' => 'Контурна пластика',
        ]);
        Service::factory()->create([
            'name' => 'Ботулінотерапія',
        ]);
Service::factory()->create([
            'name' => 'Колагеностимуляція',
        ]);
        Service::factory()->create([
            'name' => 'Апаратна косметологія',
        ]);
        Service::factory()->create([
            'name' => 'Чистки та базовий догляд',
        ]);
Service::factory()->create([
            'name' => 'Anti-age програми',
        ]);
        Service::factory()->create([
            'name' => 'Лікування проблемної шкіри',
        ]);
        Service::factory()->create([
            'name' => 'Догляд за тілом',
        ]);
Service::factory()->create([
            'name' => 'Дерматологія',
        ]);
        Service::factory()->create([
            'name' => 'Підліткова косметологія',
        ]);
        Service::factory()->create([
            'name' => 'Навчання косметологів',
        ]);

        /*User::factory()->create([
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

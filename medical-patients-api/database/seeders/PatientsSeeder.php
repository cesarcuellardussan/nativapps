<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Patient;

class PatientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Crear 10 pacientes de ejemplo
        for ($i = 0; $i < 10; $i++) {
            Patient::create([
                'document'   => $faker->unique()->numberBetween(10000000, 99999999),
                'first_name' => $faker->firstName,
                'last_name'  => $faker->lastName,
                'birth_date' => $faker->date,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->numerify('##########'),
                'genre' => $faker->randomElement(['Male', 'Female']),
            ]);
        }
    }
}

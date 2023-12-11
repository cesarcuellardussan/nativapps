<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Patient;
use App\Models\Diagnostic;
use Faker\Factory as Faker;

class PatientDiagnosticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Obtén 10 pacientes y 10 diagnósticos
        $patients    = Patient::inRandomOrder()->limit(10)->get();
        $diagnostics = Diagnostic::inRandomOrder()->limit(10)->get();

        // Asigna cada diagnóstico a un paciente con una observación
        foreach ($patients as $patient) {
            $diagnostic  = $diagnostics->random();
            $observation = $faker->sentence;

            // Usa la relación para agregar la asignación
            $patient->diagnostics()->attach($diagnostic, ['observation' => $observation]);
        }
    }
}

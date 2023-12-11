<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Diagnostic;

class DiagnosticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $diagnostics = [
            [
                'name' => 'Pneumonia',
                'description' => 'Inflammation of the lungs',
            ],
            [
                'name' => 'Cancer',
                'description' => 'A group of diseases involving abnormal cell growth with the potential to invade or spread to other parts of the body',
            ],
            [
                'name' => 'Heart disease',
                'description' => 'A group of conditions that affect your heart and blood vessels',
            ],
            [
                'name' => 'Stroke',
                'description' => 'A sudden loss of blood flow to part of the brain caused by a clot or bleeding',
            ],
            [
                'name' => 'Diabetes',
                'description' => 'A group of metabolic diseases characterized by high blood sugar levels over a prolonged period of time',
            ],
            [
                'name' => 'Alzheimer\'s disease',
                'description' => 'A progressive brain disorder that causes memory loss, difficulty thinking and problem-solving, and changes in personality',
            ],
            [
                'name' => 'Parkinson\'s disease',
                'description' => 'A brain disorder that causes shaking, stiffness, and difficulty with walking, balance, and coordination',
            ],
            [
                'name' => 'Depression',
                'description' => 'A mood disorder that causes a persistent feeling of sadness and loss of interest in activities once enjoyed',
            ],
            [
                'name' => 'Anxiety disorder',
                'description' => 'A group of mental health conditions characterized by excessive fear, worry, nervousness, or apprehension',
            ],
            [
                'name' => 'COVID-19',
                'description' => 'A respiratory illness caused by the SARS-CoV-2 virus',
            ],
        ];

        foreach ($diagnostics as $diagnostic) {
            Diagnostic::create($diagnostic);
        }
    }
}

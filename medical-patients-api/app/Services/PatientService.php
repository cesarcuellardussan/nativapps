<?php

namespace App\Services;

use App\Models\Patient;
use App\Models\Diagnostic;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class PatientService
{
    /**
     * Gets all patients.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAll()
    {
        return Patient::all();
    }

    /**
     * Gets a patient by their identifier.
     *
     * @param int $id
     *
     * @return Patient|null
     */
    public function getById(int $id)
    {
        return Patient::find($id);
    }

    /**
     * Create a new patient.
     *
     * @param array $data
     *
     * @return Patient
     */
    public function create(array $data)
    {

        $patient = new Patient();
        $patient->document = $data['document'];
        $patient->first_name = $data['first_name'];
        $patient->last_name = $data['last_name'];
        $patient->birth_date = $data['birth_date'];
        $patient->email = $data['email'];
        $patient->phone = $data['phone'];
        $patient->genre = $data['genre'];

        $patient->save();

        return $patient;
    }

    /**
     * Update an existing patient.
     *
     * @param int $id
     * @param array $data
     *
     * @return Patient|null
     */
    public function update(int $id, array $data)
    {
        $patient = $this->getById($id);

        if (is_null($patient)) {
            return null;
        }

        $patient->document = $data['document'];
        $patient->first_name = $data['first_name'];
        $patient->last_name = $data['last_name'];
        $patient->birth_date = $data['birth_date'];
        $patient->email = $data['email'];
        $patient->phone = $data['phone'];
        $patient->genre = $data['genre'];

        $patient->save();

        return $patient;
    }

    /**
     * Delete a patient.
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $patient = $this->getById($id);

        if (is_null($patient)) {
            return;
        }

        $patient->delete();
    }


    /**
     * Assign a diagnostic to a patient with an optional observation.
     *
     * @param  int      $patientId     ID of the patient.
     * @param  int      $diagnosticId  ID of the diagnostic.
     * @param  string   $observation   (Optional) Observation for the diagnostic assignment.
     *
     * @return void
     */
    public function assignDiagnostic(int $patientId, int $diagnosticId, ?string $observation = null)
    {
        // Find the patient by ID
        $patient = Patient::findOrFail($patientId);

        // Find the diagnostic by ID
        $diagnostic = Diagnostic::findOrFail($diagnosticId);

        // Check if the diagnostic is already assigned to the patient
        if ($patient->diagnostics()->where('diagnostic_id', $diagnosticId)->exists()) {
            abort(422, 'The diagnostic has already been assigned to this patient.');
        }

        // Assign the diagnostic to the patient
        $patient->diagnostics()->attach($diagnostic, [
            'observation' => $observation
        ]);
    }

    /**
     * Search for patients by name, last name, or document.
     *
     * @param  string  $query  The search query for name, last name, or document.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function search(string $query)
    {
        // Use the Eloquent query builder to search for patients
        // Matching first name, last name, or document that contains the given query
        $patients = Patient::where('first_name', 'like', "%$query%")
            ->orWhere('last_name', 'like', "%$query%")
            ->orWhere('document', 'like', "%$query%")
            ->get();

        // Return the collection of patients matching the search query
        return $patients;
    }

    /**
     * Get the list of the top 5 diagnostics assigned to patients in the last 6 months.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getTopDiagnosticsLastSixMonths()
    {
        // Utilize the Eloquent query builder to retrieve the top diagnostics
        $topDiagnostics = Diagnostic::select('diagnostics.*', DB::raw('COUNT(patient_diagnostics.id) as diagnostic_count'))
            ->join('patient_diagnostics', 'diagnostics.id', '=', 'patient_diagnostics.diagnostic_id')
            ->where('patient_diagnostics.created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('diagnostics.id')
            ->orderByDesc('diagnostic_count')
            ->limit(5)
            ->get();

        // Return a collection with the top diagnostics
        return $topDiagnostics;
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientRequest;
use App\Http\Requests\AssignDiagnosticRequest;
use App\Http\Requests\SearchPatientsRequest;

use App\Services\PatientService;
use Illuminate\Http\Request;

class PatientController extends Controller
{

    /**
     * @var $patientService
     */
    private $patientService;

    /**
     * PatientService constructor
     *
     * @param PatientService $patientService
     */
    public function __construct(PatientService $patientService)
    {
        $this->patientService = $patientService;
    }

    /**
     * List all patients.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patients = $this->patientService->getAll();
        return response()->json($patients);
    }

    /**
     * Gets a patient by their ID.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $patient = $this->patientService->getById($id);

        if (is_null($patient)) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        return response()->json($patient);
    }

    /**
     * Create a new patient.
     *
     * @param PatientRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PatientRequest $request)
    {
        $patient = $this->patientService->create($request->validated());

        return response()->json($patient, 201);
    }

    /**
     * Update a patient.
     *
     * @param int $id
     * @param PatientRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(int $id, PatientRequest $request)
    {
        $patient = $this->patientService->update($id, $request->validated());

        if (is_null($patient)) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        return response()->json($patient, 200);
    }

    /**
     * Delete a patient.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $this->patientService->delete($id);

        return response()->json(['message' => 'Patient eliminated'], 200);
    }


    /**
     * Assign a diagnostic to a patient with an optional observation.
     *
     * @param  \App\Http\Requests\AssignDiagnosticRequest  $request       The request containing validation rules.
     * @param  int                                       $patientId     ID of the patient.
     * @param  int                                       $diagnosticId  ID of the diagnostic.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function assignDiagnostic(AssignDiagnosticRequest $request, $patientId, $diagnosticId)
    {
        try {
            // Get the observation from the request
            $observation = $request->input('observation');

            // Attempt to assign the diagnostic
            $this->patientService->assignDiagnostic($patientId, $diagnosticId, $observation);

            // If successful, return a successful response
            return response()->json(['message' => 'Diagnostic assigned correctly']);
        } catch (\Exception $exception) {
            // If an exception occurs, return an error response with the exception message
            return response()->json(['error' => $exception->getMessage()], 422);
        }
    }

    /**
     * Search for patients by name, last name, or document.
     *
     * @param  \App\Http\Requests\SearchPatientsRequest  $request  The request containing validation rules.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(SearchPatientsRequest $request)
    {
        // Get the search query from the request
        $query = $request->input('query');

        // Call the patient service to perform the search
        $patients = $this->patientService->search($query);

        // Return a JSON response with the search results
        return response()->json($patients);
    }

    /**
     * Get the list of the top 5 diagnostics assigned to patients in the last 6 months.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTopDiagnosticsLastSixMonths()
    {
        // Call the patient service to retrieve the top diagnostics
        $topDiagnostics = $this->patientService->getTopDiagnosticsLastSixMonths();

        // Return a JSON response with the top diagnostics
        return response()->json($topDiagnostics);
    }
}

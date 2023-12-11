<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiagnosticRequest;
use App\Models\Diagnostic;
use App\Services\DiagnosticService;
use Illuminate\Http\Request;

class DiagnosticController extends Controller
{
    /**
     * @var $diagnosticService
     */
    protected $diagnosticService;

    /**
     * DiagnosticService constructor
     *
     * @param DiagnosticService $diagnosticService
     */
    public function __construct(DiagnosticService $diagnosticService)
    {
        $this->diagnosticService = $diagnosticService;
    }

    /**
     * List all diagnostics.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $diagnostics = $this->diagnosticService->getAll();

        return response()->json($diagnostics);
    }

    /**
     * Get a diagnostic by your identifier.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $diagnostic = $this->diagnosticService->getById($id);

        if (is_null($diagnostic)) {
            return response()->json(['message' => 'Diagnostic not found'], 404);
        }

        return response()->json($diagnostic);
    }

    /**
     * Create a new diagnostic.
     *
     * @param DiagnosticRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(DiagnosticRequest $request)
    {
        $diagnostic = $this->diagnosticService->create($request->validated());

        return response()->json($diagnostic, 201);
    }

    /**
     * Update an existing diagnostic.
     *
     * @param int $id
     * @param DiagnosticRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(int $id, DiagnosticRequest $request)
    {
        $diagnostic = $this->diagnosticService->update($id, $request->validated());

        if (is_null($diagnostic)) {
            return response()->json(['message' => 'Diagnostic not found'], 404);
        }

        return response()->json($diagnostic, 200);
    }

    /**
     * Delete a diagnostic.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $diagnostic = $this->diagnosticService->delete($id);

        return response()->json(['message' => 'Diagnostic removed'], 200);
    }
}

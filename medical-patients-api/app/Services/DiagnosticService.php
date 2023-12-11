<?php

namespace App\Services;

use App\Models\Diagnostic;

class DiagnosticService
{

    /**
     * Get all diagnoses.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAll()
    {
        return Diagnostic::all();
    }

    /**
     * Gets a diagnostic by its identifier.
     *
     * @param int $id
     *
     * @return Diagnostic|null
     */
    public function getById(int $id)
    {
        return Diagnostic::find($id);
    }

    /**
     * Create a new diagnostic.
     *
     * @param array $data
     *
     * @return Diagnostic
     */
    public function create(array $data)
    {
        $diagnostic = new Diagnostic();
        $diagnostic->name = $data['name'];
        if (isset($data['description'])) {
            $diagnostic->description = $data['description'];
        }

        $diagnostic->save();

        return $diagnostic;
    }

    /**
     * Updates an existing diagnostic.
     *
     * @param int $id
     * @param array $data
     *
     * @return Diagnostic|null
     */
    public function update(int $id, array $data)
    {
        $diagnostic = $this->getById($id);

        if (is_null($diagnostic)) {
            return null;
        }

        $diagnostic->name = $data['name'];

        if (isset($data['description'])) {
            $diagnostic->description = $data['description'];
        }


        $diagnostic->save();

        return $diagnostic;
    }

    /**
     * Eliminate a diagnostic.
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $diagnostic = $this->getById($id);

        if (is_null($diagnostic)) {
        return;
        }

        $diagnostic->delete();
    }
}

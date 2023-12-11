<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class PatientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $patientId = $this->route('id');
        return [
            'document'   => ['required', 'numeric', 'digits_between:1,20', Rule::unique('patients')->ignore($patientId)],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date'],
            'email'      => ['required', 'string', 'email', 'max:255'],
            'phone'      => ['required', 'numeric', 'digits_between:1,20'],
            'genre'      => ['required', Rule::in(['Male', 'Female'])],
        ];
    }



    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'document.unique' => 'The patient has already been registered'
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        // Throw an HttpResponseException with a JSON response containing validation errors
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors()
        ], 419));
    }
}

<?php

namespace App\Http\Requests;

use App\Exceptions\CredentialMismatchException;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LoginRequest extends FormRequest
{
    use WithCustomFailedValidation;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::attempt($this->only('email', 'password'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ];
    }

    /**
     * {@inheritDoc}
     *
     * @throws CredentialMismatchException
     */
    public function failedAuthorization(): void
    {
        throw new CredentialMismatchException();
    }
}

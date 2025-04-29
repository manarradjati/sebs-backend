<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // adjust based on auth logic
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'company_name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'website' => 'nullable|url|max:255',
        ];
    }
}

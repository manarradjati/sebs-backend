<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user'); // assumes route model binding or ID in route

        $emailRule = Rule::unique('users', 'email');
        $usernameRule = Rule::unique('users', 'username');

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $emailRule = $emailRule->ignore($userId);
            $usernameRule = $usernameRule->ignore($userId);
        }

        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', $emailRule],
            'username' => ['required', 'string', 'max:255', $usernameRule],
            'is_banned' => 'boolean',
            'address' => 'nullable|string|max:500',
            'age' => 'nullable|integer|min:0',
            'phone' => 'nullable|string|max:20',
        ];
    }
}

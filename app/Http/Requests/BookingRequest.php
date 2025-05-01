<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id'     => 'required|exists:users,id',
            'event_id'    => 'required|exists:events,id',
            'count'       => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
            'status'      => 'in:pending,confirmed,cancelled',
        ];
    }
}

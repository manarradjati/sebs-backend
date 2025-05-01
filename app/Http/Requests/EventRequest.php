<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'organizer_id' => 'required|exists:organizers,id',
            'category_id'  => 'required|exists:categories,id',
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'tags'         => 'nullable|array',
            'tags.*'       => 'string',
            'image_url'    => 'nullable|url',
            'start_date'   => 'required|date|before_or_equal:end_date',
            'end_date'     => 'required|date|after_or_equal:start_date',
            'price'        => 'required|numeric|min:0',
            'status'       => 'in:upcoming,ongoing,completed',
            'is_approved'  => 'boolean',
        ];
    }
}

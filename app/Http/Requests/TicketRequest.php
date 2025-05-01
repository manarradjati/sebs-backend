<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'booking_id'     => 'required|exists:bookings,id',
            'ticket_number'  => 'required|string|unique:tickets,ticket_number,' . $this->route('ticket'),
            'qr_code_image'  => 'nullable|string',
            'qr_code_pdf'    => 'nullable|string',
            'status'         => 'in:active,used,expired',
        ];
    }
}

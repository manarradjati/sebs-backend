<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'ticket_number',
        'qr_code_image',
        'qr_code_pdf',
        'status'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}

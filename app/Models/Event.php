<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'organizer_id',
        'category_id',
        'title',
        'description',
        'tags',
        'image_url',
        'start_date',
        'end_date',
        'price',
        'status',
        'is_approved'
    ];

    protected $casts = [
        'tags' => 'array',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_approved' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function organizer()
    {
        return $this->belongsTo(Organizer::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
